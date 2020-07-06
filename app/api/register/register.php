<?php
// Load dependencies
$files = glob(__DIR__ . '/lib/PHPMailer-6.0.3/src/*.php');
foreach ($files as $file) {
    require_once $file;
}
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Load configuration
$config = parse_ini_file('config.ini');

// Extract posted data and prepare data
$input = json_decode(file_get_contents('php://input'), true);
$id = trim($input['id']);
$prevEmail = trim($input['prevEmail']);
$username = trim($input['username']);
$password = trim($input['password']);
$encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
$email = trim($input['email']);
$loginattempts = 0;
$admin = 0;
$active = 0;
$verified = 0;
$datecreated = date('Y-m-d H:i:s');
$datemodified = date('Y-m-d H:i:s');
$token = base64_encode(random_bytes(50));
$verifylink = $config['verify_link'] . '?u=' . base64_encode($username) . '&t=' . $token;
$response = [
    'success' => false,
    'errorcode' => 0,
    'message' => '',
];

try {
    $pdo = new PDO('mysql:host=' . $config['localhost'] . ';dbname=' . $config['assignment1db'], $config['root'], $config['']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    // Insert user record
    $query = "";

    if($id == 0)
    {
        $query = "INSERT INTO users (username, password, email, loginattempts, admin, active, verified, datecreated, datemodified, token)
                VALUES (:username, :password, :email, :loginattempts, :admin, :active, :verified, :datecreated, :datemodified, :token)";
    }
    else
    {
        $query = "UPDATE `users` SET `username` = :username, 
                                    `email` = :email,
                                    `loginattempts` = :loginattempts,
                                    `admin` = :admin,
                                    `active` = :active,
                                    `verified` = :verified,
                                    `datemodified` = :datemodified,
                                    `token` = :token
                                    WHERE `users`.`id` = :id";
    }

    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $username);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':loginattempts', $loginattempts);
    $statement->bindParam(':admin', $admin);
    $statement->bindParam(':active', $active);
    $statement->bindParam(':verified', $verified);
    $statement->bindParam(':datemodified', $datemodified);
    $statement->bindParam(':token', $token);

    if($id == 0)
    {
        $statement->bindParam(':datecreated', $datecreated);
        $statement->bindParam(':password', $encryptedPassword);
    }
    else{
        $statement->bindParam(':id', $id);
    }

    $result = $statement->execute();

    // Send confirmation email

    if($prevEmail != $email){
        $mail = new PHPMailer;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ));
        $mail->isSMTP();
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Host = $config['smtp_server'];
        $mail->Port = $config['smtp_port'];
        $mail->Username = $config['smtp_username'];
        $mail->Password = $config['smtp_password'];
        $mail->From = $config['smtp_username'];
        $mail->FromName = '';
        $mail->addAddress($email, $username);
        $mail->isHTML(true);
        $mail->Subject = '';
        $mail->Body = 'Hi ' . $username . ',<br/><br/><strong></strong><br/><br/>In order to login to the module, you need to verify your account first. Please click the following link or copy it and navigate to it using your browser: <strong><i><a href="' . $verifylink . '">' . $verifylink . '</a></i></strong><br/><br/>Have a nice day!<br/><br/><br/><small></small>';
        $mail->AltBody = 'Hi ' . $username . ', Welcome to CMSC-207 Group B\'s Web Login Module! In order to login to the module, you need to verify your account first. Please click the following link or copy it and navigate to it using your browser: ' . $verifylink . ' Have a nice day! This message was sent by CMSC-207 Group B\'s Web Login Module.';
        $mail->send();
    }

    // Commit transaction
    $pdo->commit();

    // Set successful response
    $response['success'] = true;

    if($prevEmail != $email)
    {
        $response['message'] = 'Please check your email for the verification link.';
    }
    else
    {
        $response['message'] = 'User updated.';
    }
} catch (PDOException $pe) {
    // Set failure response
    $errorCode = $pe->getCode();
    $response['errorcode'] = $errorCode;
    if ((string) $errorCode === '23000') {
        $response['message'] = 'The provided username or email address already exists. Please specify a different value.';
    } else if ((string) $errorCode === '2002') {
        $response['message'] = 'The database couldn\'t be reached. Please inform the administrator.';
    } else if ((string) $errorCode === '1045') {
        $response['message'] = 'The database credentials are incorrect. Please inform the administrator.';
    } else {
        $response['message'] = $pe->getMessage() . ' Please inform the administrator.';
    }
} catch (Exception $e) {
    // Set failure response
    $response['errorcode'] = 1000;
    $response['message'] = $e->getMessage() . ' Please inform the administrator.';
}

// Return response
header('Content-Type: application/json');
print_r(json_encode($response));
