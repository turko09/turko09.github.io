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
    // Request body is null
    Http::ReturnError(400, array('message' => 'Vehicle details are empty.'));
} else {
    try {
        // Create Db object
        $db = new Db('INSERT INTO `vehicle` (driverid, plateno, type, make, model, color, photo, active, available, locationlat, locationlong, datecreated, datemodified)
                                VALUES (:driverid, :plateno, :type, :make, :model, :color, :photo, :active, :available, :locationlat, :locationlong, :datecreated, :datemodified)');

        // Bind parameters
        $db->bindParam(':driverid', property_exists($input, 'driverid') ? $input->driverid : null);
        $db->bindParam(':plateno', property_exists($input, 'plateno') ? $input->plateno : null);
        $db->bindParam(':type', property_exists($input, 'type') ? $input->type : null);
        $db->bindParam(':make', property_exists($input, 'make') ? $input->make : null);
        $db->bindParam(':model', property_exists($input, 'model') ? $input->model : null);
        $db->bindParam(':color', property_exists($input, 'color') ? $input->color : null);
        $db->bindParam(':photo', property_exists($input, 'photo') ? $input->photo : null);
        $db->bindParam(':active', 0);
        $db->bindParam(':available', 0);
        $db->bindParam(':locationlat', null);
        $db->bindParam(':locationlong', null);
        $db->bindParam(':datecreated', date('Y-m-d H:i:s'));
        $db->bindParam(':datemodified', date('Y-m-d H:i:s'));

        // Execute and get id
        $db->execute();
        $id = $db->lastInsertId();

        // Commit transaction
        $db->commit();

        // Reply with successful response
        Http::ReturnCreated('/api/vehicle/get.php?id=' . $id, array('message' => 'Vehicle added.', 'id' => (int) $id));
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
