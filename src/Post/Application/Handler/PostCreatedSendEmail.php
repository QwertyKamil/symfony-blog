<?php

declare(strict_types=1);

namespace App\Post\Application\Handler;

use App\Post\Domain\Event\PostCreated;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler(
    method: 'handle'
)]
class PostCreatedSendEmail
{
    public function __construct(
        private readonly MailerInterface $mailer,
        #[Autowire('%admin_email%')] private readonly string $adminEmail
    ) {
    }

    /**
     * @param PostCreated $postCreated
     * @return void
     * @throws TransportExceptionInterface
     */
    public function handle(PostCreated $postCreated): void
    {
        $email = (new Email())
            ->from($this->adminEmail)
            ->to($postCreated->email)
            ->subject(sprintf('New post %s', $postCreated->title))
            ->text(sprintf('New post %s created', $postCreated->title));

        $this->mailer->send($email);
    }
}
