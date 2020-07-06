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
    Http::ReturnError(400, array('message' => 'Fare details are empty.'));
} else {
    try {
        // Create Db object
        $db = new Db('INSERT INTO `fare` (vehicle_type, base_fare, per_km, per_minute, surge_rush_threshold, surge_rush_multiplier, surge_time_multiplier)
                                VALUES (:vehicle_type, :base_fare, :per_km, :per_minute, :surge_rush_threshold, :surge_rush_multiplier, :surge_time_multiplier)');

        // Bind parameters
        $db->bindParam(':vehicle_type', property_exists($input, 'vehicle_type') ? $input->vehicle_type : null);
        $db->bindParam(':base_fare', property_exists($input, 'base_fare') ? $input->base_fare : null);
        $db->bindParam(':per_km', property_exists($input, 'per_km') ? $input->per_km : null);
        $db->bindParam(':per_minute', property_exists($input, 'per_minute') ? $input->per_minute : null);
        $db->bindParam(':surge_rush_threshold', property_exists($input, 'surge_rush_threshold') ? $input->surge_rush_threshold : null);
        $db->bindParam(':surge_rush_multiplier', property_exists($input, 'surge_rush_multiplier') ? $input->surge_rush_multiplier : null);
        $db->bindParam(':surge_time_multiplier', property_exists($input, 'surge_time_multiplier') ? $input->surge_time_multiplier : null);

        // Execute and get id
        $db->execute();
        $id = $db->lastInsertId();

        // Commit transaction
        $db->commit();

        // Reply with successful response
        Http::ReturnCreated('/api/fare/get.php?id=' . $id, array('message' => 'Fare matrix added.', 'id' => (int) $id));
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
