<?php


namespace App\Service;


class AnswerService extends AbstractAuth
{
    const URL = 'https://savethismedia.com/';

    private $statusUrl = 'statuses/update';

    private function generateMessage($username)
    {

        /*$messages = [
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
        ];*/

        $messages = [
            'Ok ' . $username . ' tu trouveras ton fichier tout beau tout propre en suivant les consignes sur mon tweet épinglé',
            'Wsh ' . $username . ', ton fichier a bien été téléchargé. Suis les consignes sur mon tweet épinglé',
            'GG ' . $username . ' t\'as un nouveau média dans ton espace. Pour y accéder, va voir mon tweet épinglé',
            'C\'est fait ' . $username . ' ! En gros, ton fichier est sauvegardé. Pour le voir, suis les consignes de mon tweet épinglé',
            'Ok ' . $username . ', j\'ai posé ça sur ton espace, Pour y accéder, va voir mon tweet épinglé,  et oublie pas de me follow frérot',
            'Yo ' . $username . ', j\'ai téléchargé ça rien que pour toi bg. Suis les consignes sur mon tweet épinglé',
            'Ok bg/blg ton média est bien téléchargé, maintenant, ' . $username . ', va voir mon tweet épinglé pour le récupérer',
            'Salut ' . $username . ' ! T\'as tout compris frr, tu me mentiones, je te mets ça au chaud. Pour y accéder, va voir mon tweet épinglé',
            'Avoue ' . $username . ' je te met bien avec le fichier tout neuf pour toi : Va voir mon tweet épinglé pour le récupérer',
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
