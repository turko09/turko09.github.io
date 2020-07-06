<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';

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
            // Create Db object
            $db = new Db('SELECT COUNT(*) count FROM `trip` WHERE vehicleid IN (SELECT id from `vehicle` WHERE driverid = :id) LIMIT 1');

            // Bind parameters
            $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);

            // Execute
            $db->execute();

            // Get record
            $record = $db->fetchAll()[0];
            if ((int) $record['count'] > 0) {
                Http::ReturnError(400, array('message' => 'Cannot delete driver - associated trip records detected.'));
            } else {
                // Create Db object
                $db = new Db('DELETE FROM `vehicle` WHERE driverid = :id;');
                // Bind parameters
                $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
                // Execute
                $db->execute();
                // Commit transaction
                $db->commit();

                // Create Db object
                $db = new Db('DELETE FROM `driverdocument` WHERE driverid = :id;');
                // Bind parameters
                $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
                // Execute
                $db->execute();
                // Commit transaction
                $db->commit();

                // Create Db object
                $db = new Db('DELETE FROM `driver` WHERE id = :id;');
                // Bind parameters
                $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
                // Execute
                $db->execute();
                // Commit transaction
                $db->commit();

                // Reply with successful response
                Http::ReturnSuccess(array('message' => 'Driver deleted.', 'id' => $input->id));
            }
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
