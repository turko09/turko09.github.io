<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/adminstats.php';

// Declare use on objects to be used
use Exception;
use PDOException;

// HTTP headers for response
Http::SetDefaultHeaders('GET');

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
            (SELECT COUNT(id) FROM `admin` WHERE datecreated BETWEEN :datestart AND :dateend) total,
            (SELECT COUNT(id) FROM `admin` WHERE stage = \'Active\' AND datecreated BETWEEN :datestart AND :dateend) totalcancelled');

    // Bind parameters
    $db->bindParam(':datestart', $datestart);
    $db->bindParam(':dateend', $dateend);

    // Execute query
    $db->execute();

    // Extract result
    $record = $db->fetchAll()[0];
    $adminstats = new AdminStats($record);

    // Reply with successful response
    Http::ReturnSuccess($adminstats);
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}
