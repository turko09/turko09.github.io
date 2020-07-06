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
$usernameOrEmail = trim($input['usernameOrEmail']);
$token = base64_encode(random_bytes(50));
$response = [
    'success' => false,
    'errorcode' => 0,
    'message' => '',
];

try {
    $pdo = new PDO('mysql:host=' . $config['db_server'] . ';dbname=' . $config['db_name'], $config['db_user'], $config['db_password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    // Check user record
    $query = "SELECT * FROM users WHERE (LCASE(username) = LCASE(:usernameOrEmail) OR LCASE(email) = LCASE(:usernameOrEmail)) AND verified = 1 AND active = 1 LIMIT 1";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':usernameOrEmail', $usernameOrEmail);
    $result = $statement->execute();

    if ($statement->rowCount() === 0) {
        // Record not found
        $response['errorcode'] = 1;
        $response['message'] = 'There were no user account found with the given username or email address. Please make sure that the provided detail is correct and the user is active and verified.';
    } else {
        // Get username and email
        $record = $statement->fetchAll();
        $username = $record[0]['username'];
        $email = $record[0]['email'];

        // Create reset link
        $resetLink = $config['reset_link'] . '?u=' . base64_encode($username) . '&t=' . $token;

        // Update user record
        $query = "UPDATE users SET token = :token, datemodified = :datemodified WHERE LCASE(username) = LCASE(:username)";
        $statement = $pdo->prepare($query);
        $datemodified = date('Y-m-d H:i:s');
        $statement->bindParam(':datemodified', $datemodified);
        $statement->bindParam(':token', $token);
        $statement->bindParam(':username', $username);
        $result = $statement->execute();

        // Send reset email
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
        $mail->FromName = 'CMSC-207 Group B Web Login Module Admin';
        $mail->addAddress($email, $username);
        $mail->isHTML(true);
        $mail->Subject = 'CMSC-207 Group B Web Login Module - Reset your password!';
        $mail->Body = 'Hi ' . $username . ',<br/><br/>Please click the following link or copy it and navigate to it using your browser to reset your password: <strong><i><a href="' . $resetLink . '">' . $resetLink . '</a></i></strong><br/><br/>Have a nice day!<br/><br/><br/><small>This message was sent by CMSC-207 Group B\'s Web Login Module.</small>';
        $mail->AltBody = 'Hi ' . $username . ', Please click the following link or copy it and navigate to it using your browser to reset your password: ' . $resetLink . ' Have a nice day! This message was sent by CMSC-207 Group B\'s Web Login Module.';
        $mail->send();

        // Commit transaction
        $pdo->commit();

        // Set successful response
        $response['success'] = true;
        $response['message'] = 'Please check your email for the password reset link.';
    }
} catch (PDOException $pe) {
    // Set failure response
    $errorCode = $pe->getCode();
    $response['errorcode'] = $errorCode;
    if ((string) $errorCode === '2002') {
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
