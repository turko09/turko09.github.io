<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/farelist.php';

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
    Http::ReturnError(400, array('message' => 'Fare computation details are empty.'));
} else {
    try {
        // Create Db object
        $db = new Db('SELECT * FROM `fare` WHERE vehicle_type = :vehicle_type LIMIT 1');

        // Bind parameters
        $db->bindParam(':vehicle_type', property_exists($input, 'vehicle_type') ? $input->vehicle_type : 0);

        // Execute
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Vehicle type not found.'));
        } else {
            // Retrieve fare matrix
            $record = $db->fetchAll()[0];
            $vehicletype = $record['vehicle_type'];
            $basefare = $record['base_fare'];
            $perkm = $record['per_km'];
            $perminute = $record['per_minute'];
            $surgerushthreshold = (int) $record['surge_rush_threshold'];
            $surgerushmultiplier = (double) $record['surge_rush_multiplier'];
            $surgetimemultiplier = (double) $record['surge_time_multiplier'];

            // Retrieve active requests
            $db = new Db('SELECT COUNT(*) activerequests FROM
                                (SELECT t.id,
                                    ( 6371 * acos( cos( radians(:source_lat) ) * cos( radians(t.sourcelat) )
                                        * cos( radians(t.sourcelong) - radians(:source_long) ) + sin( radians(:source_lat) )
                                        * sin(radians(t.sourcelat)) ) ) AS distance
                                FROM `trip` t INNER JOIN `vehicle` v ON t.vehicleid = v.id
                                WHERE t.stage IN (\'Requested\', \'Rejected\')
                                AND v.type = :vehicle_type
                                HAVING distance <= :radius) activetrips');
            $db->bindParam(':vehicle_type', property_exists($input, 'vehicle_type') ? $input->vehicle_type : null);
            $db->bindParam(':source_lat', property_exists($input, 'source_lat') ? $input->source_lat : 0);
            $db->bindParam(':source_long', property_exists($input, 'source_long') ? $input->source_long : 0);
            $db->bindParam(':radius', property_exists($input, 'radius') ? $input->radius : 5);
            $db->execute();
            $record = $db->fetchAll()[0];
            $activerequests = (int) $record['activerequests'];

            // Calculation
            $distance = $input->distance_km;
            $time = $input->distance_minute;
            $baseamount = $basefare + ($distance * $perkm) + ($time * $perminute);
            $rushsurgeamount = 0;
            if ($activerequests > $surgerushthreshold) {
                $rushsurgeamount = ($baseamount * $surgerushmultiplier) - $baseamount;
            }
            $timesurgeamount = 0;
            date_default_timezone_set('Asia/Manila');
            if ((date('H:i') >= '07:00' && date('H:i') <= '09:00') ||
                (date('H:i') >= '11:00' && date('H:i') <= '13:00') ||
                (date('H:i') >= '17:00' && date('H:i') <= '21:00')) {
                $timesurgeamount = ($baseamount * $surgetimemultiplier) - $baseamount;
            }
            $totalsurgeamount = $rushsurgeamount + $timesurgeamount;
            $totalamount = $baseamount + $totalsurgeamount;

            Http::ReturnSuccess(array('Vehicle Type' => $vehicletype, 'Base Fare' => round($basefare, 2), 'Per KM' => round($perkm, 2), 'Per Minute' => round($perminute, 2), 'Distance' => round($distance, 2), 'Base Amount' => round($baseamount, 2), 'Rush Hour Surge Amount' => round($rushsurgeamount, 2), 'Time Surge Amount' => round($timesurgeamount, 2), 'Total Surge Amount' => round($totalsurgeamount, 2), 'Total Amount' => round($totalamount, 2)));
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
