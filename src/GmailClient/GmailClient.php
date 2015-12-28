<?php

namespace JamPoller\GmailClient;

use \Google_Service_Gmail;
use \Google_Client;
use Carbon\Carbon;


class GmailClient
{

    private static $client = null;

    public function __construct()
    {

    }

    /**
     * Restituisce le email della Inbox
     *
     * @return array
     */
    public function readEmails(array $options)
    {
        $output = [];

        // Get the API client and construct the service object.
        $service = (new Google_Service_Gmail($this->getGoogleClient()))->users_messages;

        $list = $service
            ->listUsersMessages('me', array_merge($options, ['fields' => 'messages(id)']) )
            ->getMessages();


        foreach ($list as $listedMessage) {

            $id = $listedMessage->getId();


            $message = $service->get('me', $id, ['format' => 'full'])->toSimpleObject();

            //parse to array
            $message = json_decode(json_encode($message), true);


            $msg = [
                'id' => $id,
                'time' => $message['internalDate'],
            ];

            //fetch header information
            foreach ($message['payload']['headers'] as $h) {

                if($h['name'] == 'Subject') {
                    $msg['subject'] = $h['value'];
                } elseif($h['name'] == 'From') {
                    $msg['from'] = $h['value'];
                } elseif($h['name'] == 'To') {
                    $msg['to'] = $h['value'];
                }

            }

            $body = [];

            if(! empty($message['payload']['parts'])) {
                //fetch payload parts information
                foreach ($message['payload']['parts'] as $p) {

                    if(isset($p['parts'])) {

                        foreach ($p['parts'] as $part) {


                            if(isset($part['body']['data'])) {

                                //content type
                                $contentType = @array_filter($part['headers'], function($head) {
                                    return $head['name'] == 'Content-Type';
                                })[0]['value'];

                                $data = self::decodeMessagePart($part['body']['data']);

                                if(strrpos($contentType, 'text/plain') !== false) {
                                    //convert into html
                                    $body['text'][] = $data;
                                } elseif(strrpos($contentType, 'text/html') !== false) {
                                    $body['html'][] = $data;
                                    //ok
                                } else {
                                    //ignore content
                                    continue;
                                }

                            }

                        }


                    }

                }
            } else {

                $body['html'][] = $this->decodeMessagePart($message['payload']['body']['data']);
            }

            $msg['body'] = $body;

            $output[] = $msg;
        }

        return $output;
    }

    /**
     * Decodifica il messaggio
     *
     * @param string $messagePart
     * @return string
     */
    private static function decodeMessagePart($messagePart)
    {
        return (base64_decode(strtr($messagePart, '-_', '+/')));
    }


    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    private function getGoogleClient()
    {
        if(! is_null(self::$client)) {
            return self::$client;
        }


        $APPLICATION_NAME = 'Gmail API PHP Quickstart';
        $CREDENTIALS_PATH = '~/.credentials/gmail-php-quickstart.json';
        $CLIENT_SECRET_PATH = APP_CWD . '/credentials/client_secret.json';
        $SCOPES = implode(' ', [
            Google_Service_Gmail::GMAIL_READONLY,
            Google_Service_Gmail::GMAIL_MODIFY,
            Google_Service_Gmail::GMAIL_SEND,
        ]);

        $client = new Google_Client();
        $client->setApplicationName($APPLICATION_NAME);
        $client->setScopes($SCOPES);
        $client->setAuthConfigFile($CLIENT_SECRET_PATH);
        $client->setAccessType('offline');

        // Load previously authorized credentials from a file.
        $credentialsPath = self::expandHomeDirectory($CREDENTIALS_PATH);

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

        self::$client = $client;

        return self::$client;
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