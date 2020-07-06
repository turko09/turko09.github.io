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
    Http::ReturnError(400, array('message' => 'Fare matrix details are empty.'));
} else {
    try {
        // Create Db object
        $db = new Db('SELECT * FROM `fare` WHERE id = :id LIMIT 1');

        // Bind parameters
        $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);

        // Execute
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Fare matrix not found.'));
        } else {
            $record = $db->fetchAll()[0];
            $vehicletype = $record['vehicle_type'];
            $basefare = $record['base_fare'];
            $perkm = $record['per_km'];
            $perminute = $record['per_minute'];
            $surge_rush_threshold = $record['surge_rush_threshold'];
            $surge_rush_multiplier = $record['surge_rush_multiplier'];
            $surge_time_multiplier = $record['surge_time_multiplier'];

            // Create Db object
            $db = new Db('UPDATE `fare` SET vehicle_type = :vehicle_type, base_fare = :base_fare, per_km = :per_km, per_minute = :per_minute, surge_rush_threshold = :surge_rush_threshold, surge_rush_multiplier = :surge_rush_multiplier, surge_time_multiplier = :surge_time_multiplier WHERE id = :id');

            // Bind parameters
            $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
            $db->bindParam(':vehicle_type', property_exists($input, 'vehicle_type') ? $input->vehicle_type : $vehicletype);
            $db->bindParam(':base_fare', property_exists($input, 'base_fare') ? $input->base_fare : $basefare);
            $db->bindParam(':per_km', property_exists($input, 'per_km') ? $input->per_km : $perkm);
            $db->bindParam(':per_minute', property_exists($input, 'per_minute') ? $input->per_minute : $perminute);
            $db->bindParam(':surge_rush_threshold', property_exists($input, 'surge_rush_threshold') ? $input->surge_rush_threshold : $surge_rush_threshold);
            $db->bindParam(':surge_rush_multiplier', property_exists($input, 'surge_rush_multiplier') ? $input->surge_rush_multiplier : $surge_rush_multiplier);
            $db->bindParam(':surge_time_multiplier', property_exists($input, 'surge_time_multiplier') ? $input->surge_time_multiplier : $surge_time_multiplier);

            // Execute
            $db->execute();

            // Commit transaction
            $db->commit();

            // Reply with successful response
            Http::ReturnSuccess(array('message' => 'Fare matrix updated.', 'id' => $input->id));
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
