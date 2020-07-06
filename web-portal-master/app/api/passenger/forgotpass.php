<?php
namespace TeamAlpha\Web;

error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING);
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/email.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/sms.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
$dbconfig = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini');
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

$url = 'php://input'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$vals = json_decode($data); // decode the JSON feed

if (is_null($vals)) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('message' => 'No contents to process'));

} else {
    $semail = $vals->email;

//check value
    $checkexisting = mysqli_query($conn, "SELECT id,email,firstname,lastname,mobile FROM passenger WHERE email LIKE '$semail' LIMIT 1");
    if (mysqli_num_rows($checkexisting) > 0) {
        $rv = mysqli_fetch_array($checkexisting);
        $rand = substr(md5(microtime()), rand(0, 26), 6);
        $hashed = password_hash($rand, PASSWORD_DEFAULT);
        $name = "$rv[lastname], $rv[firstname]";
        $updatepass = mysqli_query($conn, "UPDATE passenger SET password='$hashed' WHERE id = $rv[id] LIMIT 1");
        $body = "Use this temporary password to update your password: $rand";
        $remail = $semail;
        $subject = "Forgot password Temporary Password";
        // Send email
        $htmlbody = 'Hi ' . $semail . ',<br/><br/>Here is your forgot Password Token<br/>' . $rand . '<br/><br/>Please do Use this temporary password to log in your account!<br/><br/><br/><small>This message was sent by Team Alpha\'s Passenger Forgot Pass.</small>';
        $altbody = 'Hi ' . $semail . ', Here is your forgot Password Token: ' . $rand . ' Please do Use this temporary password to log in your account!This message was sent by Team Alpha Passenger Forgot Pass.';
        $email = new Email();
        $email->send($semail, $name, 'Temporary Password sent', $htmlbody, $altbody);

        // Send SMS
        $sms = new Sms();
        $sms->send(
            $rv['mobile'],
            'Hey ' . $rv['firstname'] . ', please check your email for your new Team Alpha passenger account password. Cheers!');

        header('HTTP/1.1 200 OK');
        echo json_encode(array('message' => 'Sent a temporary Password to be used'));
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array('message' => 'Invalid Email Credentials'));
    }

}
