<?php
namespace TeamAlpha\Web;

error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING);
// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/email.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
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
//Check API KEY

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
    $firstname = $vals->firstname;
    $lastname = $vals->lastname;
    $semail = $vals->email;
    $password = $vals->password;
    $creditcardnumber = $vals->creditcardnumber;
    $hashed = password_hash("$password", PASSWORD_DEFAULT);
    $address = $vals->address;
    $mobile = $vals->mobile;
    $pmobile = $vals->panicmobile;
	$playerid = $vals->playerid;
    $datecreated = date("Y-m-d H:i:s");
    $ac = $email . " " . $lastname;
    $token = md5($ac);

    $checkexisting = mysqli_query($conn, "SELECT email,mobile,panicmobile FROM passenger WHERE email LIKE '$semail'
|| mobile LIKE '$mobile'");
    if (mysqli_num_rows($checkexisting) > 0) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array('message' => 'Email Or mobile used is currently registered try using another.'));
    } else {

        if (count(json_decode($data, 1)) == 0) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(array('message' => 'Passenger details are empty.'));
        } else {
            $qrys = mysqli_query($conn, "INSERT INTO passenger VALUES('','$firstname','$lastname','$semail','$hashed','$address','$mobile','$pmobile',
'0','0','0','$token','','$datecreated','','$creditcardnumber','$playerid')") or die("sql error");
echo mysqli_error($conn);
            if (!$qrys) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(array('message' => 'Query Error'));

            } else {
				$name = "$lastname, $firstname";
				$subject = "Account Activation";
		   		$op=mysqli_query($conn,"SELECT id FROM passenger WHERE email LIKE '$semail' LIMIT 1");
		    		$rs=mysqli_fetch_array($op);
		    		$sid=$rs['id'];
		    		$link="https://cmsc-207-team-alpha.000webhostapp.com/app/activationlink.php?id=$sid&token=$token";
				// Send email
				$htmlbody = 'Hi ' . $semail . ',<br/><br/>Here is your Account Activation Link<br/>' . $link . '<br/><br/>Please do Use this Link to activate your account.<br/><br/><br/><small>This message was sent by Team Alpha\'s Passenger Registration Module.</small>';
				$altbody = 'Hi ' . $semail . ', >Here is your Account Activation Link' . $link . ' Please do Use this link to activate your account. This message was sent by Team Alpha Passenger Registration Module.';
				$email = new Email();
				$email->send($semail, $name, 'Account Activation', $htmlbody, $altbody);

                // Send SMS
                $sms = new Sms();
                $sms->send(
                    $mobile,
                    'Welcome to Team Alpha, ' . $firstname . '! We have sent you an email for verifying your account. We\'re looking forward to serve you with awesome rides!');

                echo json_encode(array('message' => 'Passenger record created.'));
                header('HTTP/1.1 201 Created');

            }
        }
    }
}
