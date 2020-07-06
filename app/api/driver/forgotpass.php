<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/email.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/sms.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/driver.php';

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
    Http::ReturnError(400, array('message' => 'Driver details are empty.'));
} else {
    try {
        // Create Db object
        $db = new Db('SELECT * FROM `driver` WHERE email = :email OR mobile = :mobile LIMIT 1');

        // Bind parameters
        $db->bindParam(':email', property_exists($input, 'email') ? $input->email : null);
        $db->bindParam(':mobile', property_exists($input, 'mobile') ? $input->mobile : null);

        // Execute
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Driver not found.'));
        } else {
            // Driver was found
            $record = $db->fetchAll()[0];
            $driver = new Driver($record);

            // Generate random password
            $temppassword = substr(md5(microtime()), rand(0, 26), 6);

            // Create Db object
            $db = new Db('UPDATE `driver` SET password = :password, datemodified = :datemodified WHERE id = :id');

            // Bind parameters
            $db->bindParam(':id', $driver->id);
            $db->bindParam(':password', password_hash($temppassword, PASSWORD_DEFAULT));
            $db->bindParam(':datemodified', date('Y-m-d H:i:s'));

            // Execute
            $db->execute();

            // Commit transaction
            $db->commit();

            // Send email
            $htmlbody = 'Hi ' . $driver->firstname . ',<br/><br/>Please use this password for logging in to Team Alpha Ride Booking Service: <strong>' . $temppassword . '</strong><br/><br/>Please change your password immediately upon logging in.<br/><br/>Have a nice day!<br/><br/><br/><small>This message was sent by Team Alpha\'s Driver Management Module.</small>';
            $altbody = 'Hi ' . $driver->firstname . ', Please use this password for logging in to Team Alpha Ride Booking Service: ' . $temppassword . ' Please change your password immediately upon logging in. Have a nice day! This message was sent by Team Alpha\'s Driver Management Module.';
            $email = new Email();
            $email->send($driver->email, $driver->firstname, 'Your new password', $htmlbody, $altbody);

            // Send SMS
            $sms = new Sms();
            $sms->send(
                $driver->mobile,
                'Hey ' . $driver->firstname . ', please check your email for your new Team Alpha driver account password. Cheers!');

            // Reply with successful response
            Http::ReturnSuccess(array('message' => 'Driver password updated. New password was sent via email.', 'id' => $driver->id));
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
