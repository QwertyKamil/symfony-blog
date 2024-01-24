<?php

declare(strict_types=1);

namespace App\Post\UI\Console;

use App\Post\Application\Command\CreateNewPost;
use App\Post\Application\Dto\PostDTO;
//use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:create-post',
    description: 'Creates a new post'
)]
class CreatePostCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly ValidatorInterface $validator,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument('title', InputArgument::REQUIRED, 'Post title')
            ->addArgument('description', InputArgument::REQUIRED, 'Post description')
            ->addArgument('image', InputArgument::REQUIRED, 'Post image url')
            ->addArgument('author_uuid', InputArgument::OPTIONAL, 'Post author uuid');
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $helper = $this->getHelper('question');

        if ($input->getArgument('title') == null) {
            $question = new Question('Provide title');
            $title = $helper->ask($input, $output, $question);
            $input->setArgument('title', $title);
        }

        if ($input->getArgument('description') == null) {
            $question = new Question('Provide description');
            $description = $helper->ask($input, $output, $question);
            $input->setArgument('description', $description);
        }

        if ($input->getArgument('image') == null) {
            $question = new Question('Provide image url');
            $image = $helper->ask($input, $output, $question);
            $input->setArgument('image', $image);
        }

        if ($input->getArgument('author_uuid') == null) {
            $question = new Question('Provide author uuid');
            $authorName = $helper->ask($input, $output, $question);
            $input->setArgument('author_uuid', $authorName);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            '<info>Creating post</info>',
            '-------------------',
        ]);

        $post = new PostDTO(
            $input->getArgument('title'),
            $input->getArgument('description'),
            Uuid::fromString($input->getArgument('author_uuid')),
        );

        $errors = $this->validator->validate($post, null, ['create']);

        if (count($errors) > 0) {
            $output->writeln([
                '<error>Errors:</error>',
                "<error>$errors</error>"
            ]);
            return Command::FAILURE;
        }


        $this->bus->dispatch(
            new CreateNewPost(
                $post
            )
        );

        $output->writeln(['<info>Post Created</info>']);

        return Command::SUCCESS;
    }
}
