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
$vehicleid = 0;
$stage = '';

if (array_key_exists('driverid', $_GET)) {
    $passengerid = intval($_GET['driverid']);
}
if (array_key_exists('passengerid', $_GET)) {
    $passengerid = intval($_GET['passengerid']);
}
if (array_key_exists('vehicleid', $_GET)) {
    $vehicleid = intval($_GET['vehicleid']);
}
if (array_key_exists('stage', $_GET)) {
    $stage = $_GET['stage'];
}
if (array_key_exists('datestart', $_GET)) {
    $datestart = $_GET['datestart'];
}
if (array_key_exists('datesend', $_GET)) {
    $dateend = $_GET['dateend'];
}
if ($driverid === 0 && $passengerid === 0 && $stage === '') {
    Http::ReturnError(400, array('message' => 'Driver id, passenger id or trip stage was not provided.'));
    return;
}


try {
	
    if ($passengerid === 0 && $driverid ===0) {
    // Id was not given
    // Return all trips for a stage and vehicle id
    $datestart = array_key_exists('datestart', $_GET) ? $_GET['datestart'] . ' 00:00:00' : '1000-01-01 00:00:00';
    $dateend = array_key_exists('dateend', $_GET) ? $_GET['dateend'] . ' 23:59:59' : '9999-12-31 23:59:59';
    // Create Db object
    $db = new Db('SELECT t.*, p.firstname passengerfirstname, p.lastname passengerlastname, v.plateno, v.type, v.make, v.model, v.color, d.firstname driverfirstname, d.lastname driverlastname FROM trip t
    INNER JOIN passenger p ON t.passengerid = p.id
    LEFT JOIN vehicle v ON t.vehicleid = v.id
    LEFT JOIN driver d ON v.driverid = d.id WHERE datecreated BETWEEN :datestart AND :dateend' . ($vehicleid === 0 ? '' : ' AND vehicleid = :vehicleid'));
	// Bind parameters
    $db->bindParam(':datestart', $datestart);
    $db->bindParam(':dateend', $dateend);
    /*$db->bindParam('passengerfirstname', $passengerfirstname);
    $db->bindParam('passengerlastname', $passengerlastname);
    $db->bindParam('driverfirstname', $driverfirstname);
    $db->bindParam('driverlastname', $driverlastname);*/
    if ($vehicleid !== 0) {
		$db->bindParam(':vehicleid', $vehicleid);
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
   } else {
        // Create Db object
    	
        $db = new Db('SELECT * FROM `trip` WHERE passengerid = :passengerid LIMIT 1');
	$db->bindParam(':passengerid', $passengerid);
    	 /*else if (property_exists($driverid, 'driverid')) {
        $db = new Db('SELECT * FROM `trip` WHERE vehicleid IN (SELECT id FROM vehicle WHERE driverid = '$driverid') = :vehicleid LIMIT 1');
	$db->bindParam(':driverid', $driverid);
	$db->bindParam(':vehicleid', $vechileid);	
    	}*/   

        // Execute
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Trip not found.'));
        } else {
            // Driver document was found
            $record = $db->fetchAll()[0];
            $trip = new TripListItemExtended($record);
            // Reply with successful response
            Http::ReturnSuccess($trip);
        }
    }
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}
