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
    Http::ReturnError(400, array('message' => 'Vehicle details are empty.'));
} else {
    try {
        // Create Db object
        $db = new Db('SELECT * FROM `vehicle` WHERE id = :id LIMIT 1');

        // Bind parameters
        $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);

        // Execute
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Vehicle not found.'));
        } else {
            // Create Db object
            $db = new Db('UPDATE `vehicle` SET locationlat = :locationlat, locationlong = :locationlong, datemodified = :datemodified WHERE id = :id');

            // Bind parameters            
            $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
            $db->bindParam(':locationlat', property_exists($input, 'locationlat') ? $input->locationlat : 0);
            $db->bindParam(':locationlong', property_exists($input, 'locationlong') ? $input->locationlong : 0);
            $db->bindParam(':datemodified', date('Y-m-d H:i:s'));

            // Execute
            $db->execute();

            // Commit transaction
            $db->commit();

            // Reply with successful response
            Http::ReturnSuccess(array('message' => 'Vehicle location updated.', 'id' => $input->id));
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
