<html>

<head>

    <title>Sample Login - PHP</title>
    <script src="../vendor/components/jquery/jquery.min.js"></script>
</head>

<body>

<form name="form" action="" method="post">
Email (try "johndoe@email.com"): <input id="email" name="email" /><br/>
Password (try "meh"): <input id="password" name="password" type="password" /><br/>
<input type="submit"value="Login">
</form>

<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
    $data = array(
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    );
    $data_string = json_encode($data);
    # Create a connection
    $url = 'https://cmsc-207-team-alpha.000webhostapp.com/api/admin/authenticate.php';
    $ch = curl_init($url);
    # Setting our options
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string)));
    # Get the response
    $response = json_decode(curl_exec($ch));
    curl_close($ch);

    if (property_exists($response, 'id')) {
        echo "Successful response:<br/>";
        echo "Message: " . $response->message . '<br/>';
        echo "Id: " . $response->id;
    } else {
        echo "Error response:<br/>";
        echo "Message: " . $response->message;
    }
}

?>

</body>
</html>