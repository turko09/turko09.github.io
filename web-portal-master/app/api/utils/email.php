<?php
namespace TeamAlpha\Web;

// Load dependencies
$files = glob($_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/*.php');
foreach ($files as $file) {
    require_once $file;
}

// Declare use on objects to be used
use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    private $mailer;

    public function __construct()
    {
        // Load configuration
        $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini');
        // Create PDO object and prepare query
        $this->mailer = new PHPMailer;
        $this->mailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ));
        $this->mailer->isSMTP();
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Host = $config['smtp_server'];
        $this->mailer->Port = $config['smtp_port'];
        $this->mailer->Username = $config['smtp_username'];
        $this->mailer->Password = $config['smtp_password'];
        $this->mailer->From = $config['smtp_username'];
        $this->mailer->FromName = 'Team Alpha Ride Booking Service';
        $this->mailer->isHTML(true);
    }

    public function send($recipientemail, $recipientname, $subject, $htmlbody, $altbody)
    {
        $this->mailer->addAddress($recipientemail, $recipientname);
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $htmlbody;
        $this->mailer->AltBody = $altbody;
        $this->mailer->send();
    }
}
