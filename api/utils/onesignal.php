<?php
namespace TeamAlpha\Web;

class OneSignal
{
    private $host;
    private $apiKey;
    private $appId;

    public function __construct()
    {
        // Load configuration
        $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini');
        $this->host = $config['onesignal_host'];
        $this->apiKey = $config['onesignal_apikey'];
        $this->appId = $config['onesignal_appid'];
    }

    public function send($data, $heading, $content, $playerid)
    {
        $payload = array(
            'app_id' => $this->appId,
            'data' => $data,
            'headings' => array(
                "en" => $heading,
            ),
            'contents' => array(
                "en" => $content,
            ),
            'include_player_ids' => array($playerid)
        );

        $fields = json_encode($payload);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->host);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $this->apiKey,
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
