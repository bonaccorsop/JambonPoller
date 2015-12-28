<?php

namespace GAvenue\Google;

use \Google_Client;


class Client
{
    private static $instance = null;

    private static $appName = 'Gmail API PHP Quickstart';

    private static $credentialsPath = '~/.google-assets/google-credentials.json';

    private static $secretPath = '~/.google-assets/google-token.json';

    private static $scopes = [];


    private function __construct();

    /**
     * Singleton Instantiation
     *
     * @return Client
     */
    public static function getInstance()
    {
        if(empty(self::$instance)) {
            self::$instance = self::getGoogleClient();
        }

        return self::$instance;
    }

    /**
     * Set The Google Client Credentials Path
     *
     * @param string $path
     * @return bool
     */
    public static function setAppName($path)
    {
        //'~/.credentials/gmail-php-quickstart.json'
        self::$credentialsPath = $path;

        return true;
    }

    /**
     * Set The Google Client Application Name
     *
     * @param string $name
     * @return bool
     */
    public static function setSecretPath($path)
    {
        //APP_CWD . '/credentials/client_secret.json'
        self::$secretPath = $path;

        return true;
    }

    /**
     * Set The Google Client file path where it will parse credetials
     *
     * @param string $path
     * @return bool
     */
    public static function setCredentialsPath($path)
    {
        //'~/.credentials/gmail-php-quickstart.json'
        self::$credentialsPath = $path;

        return true;
    }

    /**
     * Set The Google Client Scopes for validating actions
     *
     * @param array $scopes
     * @return bool
     */
    public static function setScopes(array $scopes)
    {
        // [
        //     Google_Service_Gmail::GMAIL_READONLY,
        //     Google_Service_Gmail::GMAIL_MODIFY,
        //     Google_Service_Gmail::GMAIL_SEND,
        // ]
        self::$scopes = implode(' ', $scopes);

        return true;
    }

    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    private static function getGoogleClient()
    {

        // $APPLICATION_NAME = 'Gmail API PHP Quickstart';
        // $CREDENTIALS_PATH = '~/.credentials/gmail-php-quickstart.json';
        // $CLIENT_SECRET_PATH = APP_CWD . '/credentials/client_secret.json';
        // $SCOPES = implode(' ', [
        //     Google_Service_Gmail::GMAIL_READONLY,
        //     Google_Service_Gmail::GMAIL_MODIFY,
        //     Google_Service_Gmail::GMAIL_SEND,
        // ]);

        $client = new Google_Client();
        $client->setApplicationName(self::$appName);
        $client->setScopes(self::$scopes);
        $client->setAuthConfigFile(self::$secretPath);
        $client->setAccessType('offline');

        // Load previously authorized credentials from a file.
        $credentialsPath = self::expandHomeDirectory(self::$credentialsPath);

        if (file_exists($credentialsPath)) {
            $accessToken = file_get_contents($credentialsPath);
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->authenticate($authCode);

            // Store the credentials to disk.
            if(!file_exists(dirname($credentialsPath))) {
              mkdir(dirname($credentialsPath), 0700, true);
            }
            file_put_contents($credentialsPath, $accessToken);
            printf("Credentials saved to %s\n", $credentialsPath);
        }

        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->refreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, $client->getAccessToken());
        }

        return $client;
    }


    /**
     * Expands the home directory alias '~' to the full path.
     * @param string $path the path to expand.
     * @return string the expanded path.
     */
    private static function expandHomeDirectory($path)
    {
      $homeDirectory = getenv('HOME');
      if (empty($homeDirectory)) {
        $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
      }
      return str_replace('~', realpath($homeDirectory), $path);
    }

}