<?php


namespace App\Service;


class MentionManager extends AbstractAuth
{
    private $mentionUrl = 'statuses/mentions_timeline';

    public function getMentions()
    {
        return $this->client->get($this->mentionUrl);
    }
}
