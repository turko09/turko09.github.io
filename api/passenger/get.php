<?php
namespace TeamAlpha\Web;
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING);
$dbconfig = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini');
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
$host = $dbconfig['db_server'];
$db = $dbconfig['db_name'];
$user = $dbconfig['db_user'];
$pass = $dbconfig['db_password'];
$conn = mysqli_connect("$host", "$user", "$pass", "$db");
// Declare use on objects to be used
use Exception;
use PDOException;
if (!Auth::Authenticate()) {
    Http::ReturnError(401, array('message' => 'Invalid API Key provided.'));    
    return;
}
header('Content-Type: application/json; charset=UTF-8');

if (!isset($_GET['id'])) {
    $get = mysqli_query($conn, "SELECT * FROM passenger ORDER BY id DESC");
    $response = array();
    while ($sp = mysqli_fetch_array($get)) {

        $passenger = "";
        $passenger->id = (int) "$sp[id]";
        $passenger->firstname = "$sp[firstname]";
        $passenger->lastname = "$sp[lastname]";
        $passenger->mobile = "$sp[mobile]";
        $passenger->panicmobile = "$sp[panicmobile]";
        $passenger->address = "$sp[address]";
        $passenger->email = "$sp[email]";
        $passenger->password = "$sp[password]";
        $passenger->creditcardnumber = "$sp[creditcardnumber]";
        $passenger->active = (int) "$sp[active]";
        $passenger->verified = (int) "$sp[verified]";
        $passenger->blocked = (int) "$sp[blocked]";

        array_push($response, $passenger);

    }
    echo json_encode($response);
    header('HTTP/1.1 201 Request Success');
} else {

    $id = $_GET['id'];
//Check query
    $get = mysqli_query($conn, "SELECT * FROM passenger WHERE id = $id LIMIT 1");

    if (mysqli_num_rows($get) > 0) {
        $response = array();
        $rv = mysqli_fetch_array($get);
        $passenger = "";
        $passenger->id = (int) "$rv[id]";
        $passenger->firstname = "$rv[firstname]";
        $passenger->lastname = "$rv[lastname]";
        $passenger->mobile = "$rv[mobile]";
        $passenger->panicmobile = "$rv[panicmobile]";
        $passenger->address = "$rv[address]";
        $passenger->email = "$rv[email]";
        $passenger->password = "$rv[password]";
        $passenger->creditcardnumber = "$rv[creditcardnumber]";
        $passenger->active = (int) "$rv[active]";
        $passenger->verified = (int) "$rv[verified]";
        $passenger->blocked = (int) "$rv[blocked]";
        $passenger->datecreated = "$rv[datecreated]";
        $passenger->datemodified = "$rv[datemodified]";
        array_push($response, $passenger);

        header('HTTP/1.1 200 OK');
        echo json_encode($response);
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array('message' => 'Query Error'));

    }

}
