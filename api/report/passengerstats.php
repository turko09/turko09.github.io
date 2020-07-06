<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/passengerstats.php';

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
                    (SELECT COUNT(id) FROM `passenger`) total,
                    (SELECT COUNT(id) FROM `passenger` WHERE active = 1) totalactive,
                    (SELECT COUNT(id) FROM `passenger` WHERE blocked = 1) totalblocked');

    // Execute query
    $db->execute();

    // Extract result
    $record = $db->fetchAll()[0];
    $passengerstats = new PassengerStats($record);

    // Reply with successful response
    Http::ReturnSuccess($passengerstats);
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}
