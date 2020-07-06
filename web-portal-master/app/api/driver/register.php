<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/email.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/sms.php';

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
        $db = new Db('INSERT INTO `driver` (firstname, lastname, email, password, address, mobile, active, verified, blocked, token, photo, datecreated, datemodified)
                                VALUES (:firstname, :lastname, :email, :password, :address, :mobile, :active, :verified, :blocked, :token, :photo, :datecreated, :datemodified)');

        // Bind parameters
        $db->bindParam(':firstname', property_exists($input, 'firstname') ? $input->firstname : null);
        $db->bindParam(':lastname', property_exists($input, 'lastname') ? $input->lastname : null);
        $db->bindParam(':email', property_exists($input, 'email') ? $input->email : null);
        $db->bindParam(':password', property_exists($input, 'password') ? password_hash($input->password, PASSWORD_DEFAULT) : null);
        $db->bindParam(':address', property_exists($input, 'address') ? $input->address : null);
        $db->bindParam(':mobile', property_exists($input, 'mobile') ? $input->mobile : null);
        $db->bindParam(':active', 0);
        $db->bindParam(':verified', 0);
        $db->bindParam(':blocked', 0);
        $db->bindParam(':token', null);
        $db->bindParam(':photo', property_exists($input, 'photo') ? $input->photo : null);
        $db->bindParam(':datecreated', date('Y-m-d H:i:s'));
        $db->bindParam(':datemodified', date('Y-m-d H:i:s'));

        // Execute and get id
        $db->execute();
        $id = $db->lastInsertId();

        // Commit transaction
        $db->commit();

        // Send email
        $htmlbody = 'Hi ' . $input->firstname . ',<br/><br/><strong>Welcome to Team Alpha Ride Booking Service Network!</strong><br/><br/>A Team Alpha administrator will look into your application soon and once you\'re approved, you can start transporting passengers from our network.<br/><br/>Once again, welcome to our growing network and enjoy driving soon!<br/><br/><br/><small>This message was sent by Team Alpha\'s Driver Registration Module.</small>';
        $altbody = 'Hi ' . $input->firstname . ', Welcome to Team Alpha Ride Booking Service Network! A Team Alpha administrator will look into your application soon and once you\'re approved, you can start transporting passengers from our network. Once again, welcome to our growing network and enjoy driving soon! This message was sent by Team Alpha\'s Driver Registration Module.';
        $email = new Email();
        $email->send($input->email, $input->firstname, 'Welcome to Team Alpha!', $htmlbody, $altbody);

        // Send SMS
        if (property_exists($input, 'mobile')) {
            $sms = new Sms();
            $sms->send(
                $input->mobile,
                'Hey ' . $input->firstname . ', Thank you for your interest on being one of the awesome drivers of Team Alpha. An administrator will review your application soon and we\'ll inform you of the outcome.');
        }

        // Reply with successful response
        Http::ReturnCreated('/api/driver/get.php?id=' . $id, array('message' => 'Driver registered.', 'id' => (int) $id));
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
