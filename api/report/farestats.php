<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/farestats.php';

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
                    (SELECT COUNT(id) FROM `fare`) totalmatrices,
                    (SELECT AVG(base_fare) FROM `fare`) avgbasefare,
                    (SELECT MIN(base_fare) FROM `fare`) lowestbasefare,
                    (SELECT MAX(base_fare) FROM `fare`) hightestbasefare,
                    (SELECT AVG(per_km) FROM `fare`) avgfareperkm,
                    (SELECT MIN(per_km) FROM `fare`) lowestfareperkm,
                    (SELECT MAX(per_km) FROM `fare`) hightestfareperkm,
                    (SELECT AVG(per_minute) FROM `fare`) avgfareperminute,
                    (SELECT MIN(per_minute) FROM `fare`) lowestfareperminute,
                    (SELECT MAX(per_minute) FROM `fare`) hightestfareperminute');

    // Execute query
    $db->execute();

    // Extract result
    $record = $db->fetchAll()[0];
    $farestats = new FareStats($record);

    // Reply with successful response
    Http::ReturnSuccess($farestats);
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}
