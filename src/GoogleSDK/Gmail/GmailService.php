<?php

namespace GAvenue\Google\Gmail;

use GAvenue\Google\GoogleService;
use \Google_Service_Gmail;

class GmailService extends GoogleService
{

    const DEFAULT_USER = 'me';

    /**
     * Lists User's messages
     *
     * @param array $options (optional)
     * @param string $user (default 'me')
     * @return MessageCollection
     */
    public function listMessages(array $options = null, $user = self::DEFAULT_USER)
    {
        $output = [];

        // Get the API client and construct the service object.
        $service = (new Google_Service_Gmail($this->getClient()))->users_messages;

        $list = $service
            ->listUsersMessages($user, array_merge($options, ['fields' => 'messages(id)']))
            ->getMessages();

        return new MessageCollection($list);
    }

}