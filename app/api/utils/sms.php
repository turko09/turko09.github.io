<?php
namespace TeamAlpha\Web;

class Sms
{
    private $authToken;
    private $smsHost;
    private $provisionedNo;

    public function __construct()
    {
        // Load configuration
        $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini');
        $this->smsHost = $config['telstra_sms_host'];
        $this->provisionedNo = $config['telstra_provisioned_no'];
        $tokenResponse = $this->getToken($config['telstra_auth_host'], $config['telstra_client_id'], $config['telstra_client_secret'], $config['telstra_grant_type']);
        $this->authToken = $tokenResponse->token_type . ' ' . $tokenResponse->access_token;
    }

    private function getToken($host, $clientId, $clientSecret, $grantType)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $host);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'client_id=' . $clientId . '&client_secret=' . $clientSecret . '&grant_type=' . $grantType);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    public function send($recipient, $message)
    {
        $payload = array(
            'to' => $recipient,
            'body' => $message,
            'from' => $this->provisionedNo,
            'validity' => 5,
            'replyRequest' => false,
        );

        $fields = json_encode($payload);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->smsHost);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: ' . $this->authToken,
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }
}
