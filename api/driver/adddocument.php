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
    Http::ReturnError(400, array('message' => 'Driver document details are empty.'));
} else {
    try {
        // Create Db object
        $db = new Db('INSERT INTO `driverdocument` (driverid, description, type, document, datecreated, datemodified)
                                VALUES (:driverid, :description, :type, :document, :datecreated, :datemodified)');

        // Bind parameters
        $db->bindParam(':driverid', property_exists($input, 'driverid') ? $input->driverid : 0);
        $db->bindParam(':description', property_exists($input, 'description') ? $input->description : null);
        $db->bindParam(':type', property_exists($input, 'type') ? $input->type : null);
        $db->bindParam(':document', property_exists($input, 'document') ? $input->document : null);
        $db->bindParam(':datecreated', date('Y-m-d H:i:s'));
        $db->bindParam(':datemodified', date('Y-m-d H:i:s'));

        // Execute and get id
        $db->execute();
        $id = $db->lastInsertId();

        // Commit transaction
        $db->commit();

        // Reply with successful response
        Http::ReturnCreated('/api/driver/getdocument.php?id=' . $id, array('message' => 'Driver document added.', 'id' => (int) $id));
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
