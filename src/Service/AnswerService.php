<?php


namespace App\Service;


class AnswerService extends AbstractAuth
{
    const URL = 'http://127.0.0.1:8000/';

    private $statusUrl = 'statuses/update';

    private function generateMessage($username)
    {

        $messages = [
            'Ok ' . $username . 'you will find your video on this url : ' . self::URL . $username,
            'Your media has just been downloaded here : ' . self::URL . $username,
            'GG ' . $username . ' you have a new media on your page : ' . self::URL . $username,
            'I did it for you my dear ' . $username . ', here is your precious media : ' . self::URL . $username,
            'Check your media on this url and don\'t forget to follow me ! : ' . self::URL . $username,
        ];
        return $messages[array_rand($messages)];
    }

    public function sendMessage($tweetId, $username)
    {
        try {

            $options = [
                'status' => '@' . $username . ' ' . $this->generateMessage($username),
                'in_reply_to_status_id' => $tweetId,
            ];
            $this->client->post($this->statusUrl, $options);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
