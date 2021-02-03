<?php


namespace App\Service;


class AnswerService extends AbstractAuth
{
    const URL = 'https://savethismedia.com/';

    private $statusUrl = 'statuses/update';

    private function generateMessage($username)
    {

        $messages = [
            'Ok ' . $username . ' tu trouveras ton fichier tout beau tout propre ici : ' . self::URL . $username,
            'Wsh, ton fichier a bien été téléchargé ici ' . self::URL . $username,
            'GG ' . $username . ' t\'as un nouveau média dans ton espace : ' . self::URL . $username,
            'J\'ai bien pris en compte tes doléances frérot. En gros, ' . $username . ', ton fichier est là : ' . self::URL . $username,
            'Ok j\'ai posé ça ici, et oublie pas de me follow frérot : ' . self::URL . $username,
            'J\'ai fais un lien rien que pour toi bg : ' . self::URL . $username,
            'Ok bg/blg ton média est ici : ' . self::URL . $username,
            'T\'as tout compris frr, tu me mentiones, je te mets ça au chaud : ' . self::URL . $username,
            'Voici ton lien bg : ' . self::URL . $username,
            'Avoue je te met bien avec un lien tout neuf pour toi : ' . self::URL . $username,
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
