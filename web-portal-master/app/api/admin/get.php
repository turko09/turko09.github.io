<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/admin.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/adminlistitem.php';

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

$id = 0;

// Extract request query string
if (array_key_exists('id', $_GET)) {
    $id = intval($_GET['id']);
}

try {
    if ($id === 0) {
        // Id was not given
        // Return all Administrator

        // Create Db object
        $db = new Db('SELECT * FROM `admin`');

        $response = array();

        // Execute
        if ($db->execute() > 0) {
            // Administrators were found
            $records = $db->fetchAll();
            foreach ($records as &$record) {
                $admin = new AdminListItem($record);
                array_push($response, $admin);
            }
        }

        // Reply with successful response
        Http::ReturnSuccess($response);
    } else {
        // Create Db object
        $db = new Db('SELECT * FROM `admin` WHERE id = :id LIMIT 1');

        // Bind parameters
        $db->bindParam(':id', $id);

        // Execute
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Administrator not found.'));
        } else {
            // Administrator was found
            $record = $db->fetchAll()[0];
            $admin = new Admin($record);

            // Reply with successful response
            Http::ReturnSuccess($admin);
        }
    }
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}
