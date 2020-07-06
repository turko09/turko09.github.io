<?php
namespace TeamAlpha\Web;
// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/email.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/sms.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/admin.php';
// Declare use on objects to be used
use Exception;
use PDOException;
// Set default response headers
Http::SetDefaultHeaders('POST');

// Check API Key
if (!Auth::Authenticate()) {
    Http::ReturnError(401, array('message' => 'Invalid API Key provided.'));    
    return;
}

// Check if request method is correct
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Http::ReturnError(405, array('message' => 'Request method is not allowed.'));
    return;
}
// Extract request body
$input = json_decode(file_get_contents("php://input"));
if (is_null($input)) {
    Http::ReturnError(400, array('message' => 'Administrator details are empty.'));
} else {
    try {
        // Create Db object
        $db = new Db('SELECT * FROM `admin` WHERE email = :email LIMIT 1');
        // Bind parameters
        $db->bindParam(':email', property_exists($input, 'email') ? $input->email : null);
        // Execute
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Administrator not found.'));
        } else {
            // Administrator was found
            $record = $db->fetchAll()[0];
            $admin = new Admin($record);
            // Generate random password
            $temppassword = substr(md5(microtime()), rand(0, 26), 6);
            // Create Db object
            $db = new Db('UPDATE `admin` SET password = :password, datemodified = :datemodified WHERE id = :id');
            // Bind parameters
            $db->bindParam(':id', $admin->id);
            $db->bindParam(':password', password_hash($temppassword, PASSWORD_DEFAULT));
            $db->bindParam(':datemodified', date('Y-m-d H:i:s'));
            // Execute
            $db->execute();
            // Commit transaction
            $db->commit();
            // Send email
            $htmlbody = 'Hi ' . $admin->firstname . ',<br/><br/>Please use this password for logging in to Team Alpha Administrator Page: <strong>' . $temppassword . '</strong><br/><br/>Please change your password immediately upon logging in.<br/><br/>Have a nice day!<br/><br/><br/><small>This message was sent by Team Alpha\'s Administrator Management Module.</small>';
            $altbody = 'Hi ' . $admin->firstname . ', Please use this password for logging in to Team Alpha Administrator Page: ' . $temppassword . ' Please change your password immediately upon logging in. Have a nice day! This message was sent by Team Alpha\'s Administrator Management Module.';
            $email = new Email();
            $email->send($admin->email, $admin->firstname, 'Your new password', $htmlbody, $altbody);
            // Reply with successful response
            Http::ReturnSuccess(array('message' => 'Administrator password updated. New password was sent via email.', 'id' => $admin->id));
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
