<?php

namespace App\Controller;

use App\Service\MentionManager;
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
    public function getMentions(MentionManager $mentionManager, MessageService $messageService)
    {

        $mentions = $mentionManager->getMentions();
        $mentionMessage = $messageService->getOneById($mentions[0]->id);
        $tweetOriginal = $messageService->getOneById($mentionMessage->in_reply_to_status_id);
        $video = $tweetOriginal->extended_entities->media[0]->video_info->variants[0];
        dd($video->url);

    }
}
