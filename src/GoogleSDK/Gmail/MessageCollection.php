<?php

namespace GAvenue\Google\Gmail;

class MessageCollection
{
    private $messages = null;

    public function __construct(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Filters messages from the collection
     *
     * @param callable $callback
     * @return MessageCollection
     */
    public function filter(callable $callback)
    {
        $this->messages = array_filter($this->messages, $callback);

        return $this;
    }

    /**
     * Removes Messages with specified ids from the collection
     *
     * @param array $ids
     * @return MessageCollection
     */
    public function excludeIds(array $ids)
    {
        $this->filter(function($message) use ($ids) {

            return ! in_array($message->getId(), $ids);

        });

        return $this;
    }

    /**
     * Returns a list of Message
     *
     * @return array
     */
    public function getMessages()
    {
        return array_map(function($m) {
            return new Message($m->getId());
        }, $this->messages);
    }

    /**
     * Returns a list of Message
     *
     * @param callable $callback
     * @return MessageCollection
     */
    public function each(callable $callback)
    {
        foreach ($this->getMessages() as $message) {
            $callback($message);
        }

        return $this;
    }

}