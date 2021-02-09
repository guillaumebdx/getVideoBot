<?php

namespace App\Command;

use App\Entity\Media;
use App\Entity\TwitterUser;
use App\Repository\MediaRepository;
use App\Repository\TwitterUserRepository;
use App\Service\MentionManager;
use App\Service\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetMentionsCommand extends Command
{
    protected static $defaultName = 'get-mentions';

    private $mentionManager;
    private $messageService;
    private $entityManager;
    private $twitterUserRepository;
    private $mediaRepository;

    public function __construct(MentionManager $mentionManager,
                                MessageService $messageService,
                                EntityManagerInterface $entityManager,
                                TwitterUserRepository $twitterUserRepository,
                                MediaRepository $mediaRepository,
                                string $name = null)
    {
        parent::__construct($name);
        $this->mentionManager = $mentionManager;
        $this->messageService = $messageService;
        $this->entityManager = $entityManager;
        $this->twitterUserRepository = $twitterUserRepository;
        $this->mediaRepository = $mediaRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('This command retrieve mentions in twitter and persist in db')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->mentionManager->getMentions() as $mention) {
            if ($mention->id !== null) {
                $mentionMessage = $this->messageService->getOneById($mention->id);
                if ($mentionMessage->in_reply_to_status_id !== null) {
                    $username = $mentionMessage->user->screen_name;
                    if ($this->twitterUserRepository->userExist($username)) {
                        $twitterUser = $this->twitterUserRepository->findOneBy(['username' => $username]);
                    } else {
                        $twitterUser = new TwitterUser();
                        $twitterUser->setUsername($mentionMessage->user->screen_name);
                    }

                    $media = new Media();
                    $tweetOriginal = $this->messageService->getOneById($mentionMessage->in_reply_to_status_id);
                    if (isset($tweetOriginal->extended_entities) && !$this->mediaRepository->tweetExist($mentionMessage->id)) {
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
                        $media->setCapture($tweetOriginal
                            ->extended_entities
                            ->media[0]
                            ->media_url_https);
                        $media->setTweetIdentifier($mentionMessage->id);
                        $media->setTwitterUser($twitterUser);
                        $media->setIsAnswered(false);
                        $this->entityManager->persist($twitterUser);
                        $this->entityManager->persist($media);
                    }
                }
            }
        }
        $this->entityManager->flush();
        $io->success('Mentions pushed in db with success');

        return 0;
    }
}
