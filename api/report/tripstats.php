<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/tripstats.php';

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
    $datestart = array_key_exists('datestart', $_GET) ? $_GET['datestart'] . ' 00:00:00' : '1000-01-01 00:00:00';
    $dateend = array_key_exists('dateend', $_GET) ? $_GET['dateend'] . ' 23:59:59' : '9999-12-31 23:59:59';

    // Create Db object
    $db = new Db('SELECT
            (SELECT COUNT(id) FROM `trip` WHERE datecreated BETWEEN :datestart AND :dateend) total,
            (SELECT COUNT(id) FROM `trip` WHERE stage = \'Requested\' AND datecreated BETWEEN :datestart AND :dateend) totalrequested,
            (SELECT COUNT(id) FROM `trip` WHERE stage = \'Assigned\' AND datecreated BETWEEN :datestart AND :dateend) totalassigned,
            (SELECT COUNT(id) FROM `trip` WHERE stage = \'Rejected\' AND datecreated BETWEEN :datestart AND :dateend) totalrejected,
            (SELECT COUNT(id) FROM `trip` WHERE stage = \'Ongoing\' AND datecreated BETWEEN :datestart AND :dateend) totalongoing,
            (SELECT COUNT(id) FROM `trip` WHERE stage = \'Completed\' AND datecreated BETWEEN :datestart AND :dateend) totalcompleted,
            (SELECT COUNT(id) FROM `trip` WHERE stage = \'Cancelled\' AND datecreated BETWEEN :datestart AND :dateend) totalcancelled');

    // Bind parameters
    $db->bindParam(':datestart', $datestart);
    $db->bindParam(':dateend', $dateend);

    // Execute query
    $db->execute();

    // Extract result
    $record = $db->fetchAll()[0];
    $tripstats = new TripStats($record);

    // Reply with successful response
    Http::ReturnSuccess($tripstats);
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}
