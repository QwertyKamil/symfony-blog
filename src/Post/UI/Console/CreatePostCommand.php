<?php

declare(strict_types=1);

namespace App\Post\UI\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:create-post',
    description: 'Creates a new post'
)]
class CreatePostCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('title', InputArgument::REQUIRED, 'Post title')
            ->addArgument('description', InputArgument::REQUIRED, 'Post description')
            ->addArgument('image', InputArgument::REQUIRED, 'Post image url')
            ->addArgument('author_name', InputArgument::OPTIONAL, 'Post author name')
            ->addArgument('author_email', InputArgument::OPTIONAL, 'Post author email')
            ->addArgument('author_id', InputArgument::OPTIONAL, 'Author identifier');
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

        if ($input->getArgument('author_name') == null) {
            $question = new Question('Provide author name');
            $authorName = $helper->ask($input, $output, $question);
            $input->setArgument('author_name', $authorName);
        }

        if ($input->getArgument('author_email') == null) {
            $question = new Question('Provide author email');
            $authorEmail = $helper->ask($input, $output, $question);
            $input->setArgument('author_email', $authorEmail);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            '<info>Creating post</info>',
            '============',
        ]);

        $output->writeln($input->getArguments());

        // the value returned by someMethod() can be an iterator (https://php.net/iterator)
        // that generates and returns the messages with the 'yield' PHP keyword
        // $output->writeln($this->someMethod());

        // outputs a message followed by a "\n"
        $output->writeln('Whoa!');

        return Command::SUCCESS;
    }
}
