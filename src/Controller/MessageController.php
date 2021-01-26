<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\TwitterUser;
use App\Repository\MediaRepository;
use App\Repository\TwitterUserRepository;
use App\Service\MentionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MessageService;

/**
 *
 * @author guillaume
 * @Route("/message", name="message_")
 *
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * @param MessageService $message
     */
    public function search(MessageService $message)
    {
        $message->search(
            [
                'macron',
                'oui'
            ],
            [
                'exclude_replies' => true,
            ]
            );
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param MessageService $message
     */
    public function showById(MessageService $message, $id)
    {
        $message->getOneById($id);
    }

    /**
     * @Route("/retweets/{id}", name="retweets")
     * @param MessageService $message
     */
    public function showRetweets(MessageService $message, $id)
    {
        $message->getRetweetsById($id);
    }

    /**
     * @Route("/mentions", name="mentions")
     * @param MessageService $message
     */
    public function getMentions(MentionManager $mentionManager,
                                MessageService $messageService,
                                EntityManagerInterface $entityManager,
                                TwitterUserRepository $twitterUserRepository,
                                MediaRepository $mediaRepository)
    {
        foreach ($mentionManager->getMentions() as $mention) {
            $mentionMessage = $messageService->getOneById($mention->id);
            $username = $mentionMessage->user->screen_name;
            if ($twitterUserRepository->userExist($username)) {
                $twitterUser = $twitterUserRepository->findOneBy(['username' => $username]);
            } else {
                $twitterUser    = new TwitterUser();
                $twitterUser->setUsername($mentionMessage->user->screen_name);
            }

            $media         = new Media();
            $tweetOriginal = $messageService->getOneById($mentionMessage->in_reply_to_status_id);

            if (isset($tweetOriginal->extended_entities) && !$mediaRepository->tweetExist($mentionMessage->id)) {
                if (!isset($tweetOriginal->extended_entities->media[0]->video_info)) {
                    $media->setUrl($tweetOriginal
                        ->extended_entities
                        ->media[0]
                        ->media_url_https);
                    $media->setType(Media::TYPE_IMAGE);
                } else {
                    $media->setType(Media::TYPE_VIDEO);
                    $video = $tweetOriginal
                        ->extended_entities
                        ->media[0]
                        ->video_info
                        ->variants[0];
                    $media->setUrl($video->url);
                }
                    $media->setTweetIdentifier($mentionMessage->id);
                    $media->setTwitterUser($twitterUser);
                    $entityManager->persist($twitterUser);
                    $entityManager->persist($media);
            }
        }
        $entityManager->flush();
        dd('ok');
        //TODO Vérifier si l utilisateur existe, si oui, ajouter le media à cet user.
        //TODO Vérifier que le tweetidentifier n existe pas déjà avant de persist (avec un findby dans le repository qui retourne true ou false
    }
}
