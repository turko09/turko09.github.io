<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/triplistitemextended.php';

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

$driverid = 0;
$passengerid = 0;
$conditionSuffix = '';
// Extract request query string
if (array_key_exists('driverid', $_GET)) {
    $driverid = intval($_GET['driverid']);
    $conditionSuffix = ' AND d.id = :driverid';
}
if (array_key_exists('passengerid', $_GET)) {
    $passengerid = intval($_GET['passengerid']);
    $conditionSuffix = ' AND p.id = :passengerid';
}

try {
    // Create Db object
    $db = new Db('SELECT t.*, p.firstname passengerfirstname, p.lastname passengerlastname, v.plateno, v.type, v.make, v.model, v.color, d.firstname driverfirstname, d.lastname driverlastname FROM trip t
        INNER JOIN passenger p ON t.passengerid = p.id
        LEFT JOIN vehicle v ON t.vehicleid = v.id
        LEFT JOIN driver d ON v.driverid = d.id
        WHERE t.datecreated BETWEEN :datestart AND :dateend' . $conditionSuffix);

    $datestart = array_key_exists('datestart', $_GET) ? $_GET['datestart'] . ' 00:00:00' : '1000-01-01 00:00:00';
    $dateend = array_key_exists('dateend', $_GET) ? $_GET['dateend'] . ' 23:59:59' : '9999-12-31 23:59:59';
    // Bind parameters
    $db->bindParam(':datestart', $datestart);
    $db->bindParam(':dateend', $dateend);
    if ($driverid !== 0) {
        $db->bindParam(':driverid', $driverid);
    }
    if ($passengerid !== 0) {
        $db->bindParam(':passengerid', $passengerid);
    }

    $response = array();

    // Execute
    if ($db->execute() > 0) {
        // Drivers were found
        $records = $db->fetchAll();
        foreach ($records as &$record) {
            $trip = new TripListItemExtended($record);
            array_push($response, $trip);
        }
    }

    // Reply with successful response
    Http::ReturnSuccess($response);
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}
