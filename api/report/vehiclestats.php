<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/vehiclestats.php';

// Declare use on objects to be used
use Exception;
use PDOException;

// HTTP headers for response
Http::SetDefaultHeaders('GET');

// Check API Key
if (!Auth::Authenticate()) {
    Http::ReturnError(401, array('message' => 'Invalid API Key provided.'));    
    return;
}

// Check if request method is correct
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Http::ReturnError(405, array('message' => 'Request method is not allowed.'));
    return;
}

try {
    // Create Db object
    $db = new Db('SELECT
                    (SELECT COUNT(id) FROM `vehicle`) total,
                    (SELECT COUNT(id) FROM `vehicle` WHERE active = 1) totalonduty,
                    (SELECT COUNT(id) FROM `vehicle` WHERE available = 1) totalavailable,
                    (SELECT COUNT(id) FROM `vehicle` WHERE active = 1 AND available = 0) totalontrip');

    // Execute query
    $db->execute();

    // Extract result
    $record = $db->fetchAll()[0];
    $vehiclestats = new VehicleStats($record);

    // Reply with successful response
    Http::ReturnSuccess($vehiclestats);
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}
