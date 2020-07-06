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
        $db = new Db('SELECT * FROM `driver` WHERE id = :id LIMIT 1');

        // Bind parameters
        $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);

        // Execute
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Driver not found.'));
        } else {
            $changeshtml = '';
            $changesalt = '';

            // Driver was found
            $record = $db->fetchAll()[0];
            $driver = new Driver($record);

            if (property_exists($input, 'active')) {
                // Create Db object
                $db = new Db('UPDATE `driver` SET active = :active, datemodified = :datemodified WHERE id = :id');

                // Bind parameters
                $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
                $db->bindParam(':active', property_exists($input, 'active') ? $input->active : 0);
                $db->bindParam(':datemodified', date('Y-m-d H:i:s'));

                // Execute
                $db->execute();

                // Commit transaction
                $db->commit();

                // Update message
                $changeshtml = $changeshtml . '* Your account was ' . ($input->active === 1 ? 'activated' : 'deactivated') . '.<br/>';
                $changesalt = $changesalt . '* Your account was ' . ($input->active === 1 ? 'activated' : 'deactivated') . '.';
            }
            if (property_exists($input, 'verified')) {
                // Create Db object
                $db = new Db('UPDATE `driver` SET verified = :verified, datemodified = :datemodified WHERE id = :id');

                // Bind parameters
                $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
                $db->bindParam(':verified', property_exists($input, 'verified') ? $input->verified : 0);
                $db->bindParam(':datemodified', date('Y-m-d H:i:s'));

                // Execute
                $db->execute();

                // Commit transaction
                $db->commit();

                // Update message
                $changeshtml = $changeshtml . '* Your account got ' . ($input->verified === 1 ? 'verifed' : 'unverified') . '.<br/>';
                $changesalt = $changesalt . '* Your account got ' . ($input->verified === 1 ? 'verified' : 'unverified') . '.';
            }
            if (property_exists($input, 'blocked')) {
                // Create Db object
                $db = new Db('UPDATE `driver` SET blocked = :blocked, datemodified = :datemodified WHERE id = :id');

                // Bind parameters
                $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
                $db->bindParam(':blocked', property_exists($input, 'blocked') ? $input->blocked : 0);
                $db->bindParam(':datemodified', date('Y-m-d H:i:s'));

                // Execute
                $db->execute();

                // Commit transaction
                $db->commit();

                // Update message
                $changeshtml = $changeshtml . '* Your account was ' . ($input->blocked === 1 ? 'blocked' : 'unblocked') . '.<br/>';
                $changesalt = $changesalt . '* Your account was ' . ($input->blocked === 1 ? 'blocked' : 'unblocked') . '.';
            }

            // Send email
            $htmlbody = 'Hi ' . $driver->firstname . ',<br/><br/>There were changes made on your account\'s status. To summarize:<br/>' . $changeshtml . '<br/><br/>Please contact Team Alpha for inquiries regarding these actions.<br/><br/>Have a nice day!<br/><br/><br/><small>This message was sent by Team Alpha\'s Driver Status Management Module.</small>';
            $altbody = 'Hi ' . $driver->firstname . ', There were changes made on your account\'s status. To summarize: ' . $changesalt . ' Please contact Team Alpha for inquiries regarding these actions. Have a nice day! This message was sent by Team Alpha\'s Driver Status Management Module.';
            $email = new Email();
            $email->send($driver->email, $driver->firstname, 'There were changes made to your account', $htmlbody, $altbody);

            // Send SMS
            $sms = new Sms();
            $sms->send(
                $driver->mobile,
                'Hey ' . $driver->firstname . ', a Team Alpha administrator made some changes on your driver account\'s status. Please check your email for more details.');

            // Reply with successful response
            Http::ReturnSuccess(array('message' => 'Driver status updated.', 'id' => $input->id));
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
