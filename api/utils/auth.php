<?php
namespace TeamAlpha\Web;

class Auth
{
    public static function Authenticate()
    {
        // Retrieve configuration
        $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini');
        $authEnabled = $config['auth_enabled'];
        $acceptedKeys = explode(",", $config['auth_accepted_keys']);
        // Authenticate
        if ($authEnabled) {
            $key = array_key_exists('HTTP_X_API_KEY', $_SERVER) ? $_SERVER['HTTP_X_API_KEY'] : '';
            return in_array($key, $acceptedKeys);
        }
        return true;
    }
}
