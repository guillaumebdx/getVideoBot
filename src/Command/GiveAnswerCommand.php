<?php

namespace App\Command;

use App\Repository\MediaRepository;
use App\Service\AnswerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GiveAnswerCommand extends Command
{
    protected static $defaultName = 'give-answer';

    private $mediaRepository;
    private $answerService;
    private $entityManager;

    public function __construct(MediaRepository $mediaRepository,
                                AnswerService $answerService,
                                EntityManagerInterface $entityManager,
                                string $name = null)
    {
        parent::__construct($name);
        $this->mediaRepository = $mediaRepository;
        $this->answerService = $answerService;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Send an answer to twitter user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $media = $this->mediaRepository->findBy(['isAnswered' => false], null, 2);
        foreach ($media as $medium) {
            $this->answerService->sendMessage($medium->getTweetIdentifier(), $medium->getTwitterUser()->getUsername());
            $medium->setIsAnswered(true);
        }
        $this->entityManager->flush();

        $io->success('Answers sent with success');

        return 0;
    }
}
