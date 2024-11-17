<?php
declare(strict_types=1);

/**
 * File: UserCreatedEvent.php
 *
 * @author Łukasz Kilijański <kilijanskilukasz@gmail.com>
 */

namespace App\Core\User\Application\EventListener;

use App\Core\User\Domain\Event\UserCreatedEvent;
use App\Common\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendEmailUserCreatedEventSubscriberListener implements EventSubscriberInterface
{
    public function __construct(private readonly MailerInterface $mailer) {}

    public function send(UserCreatedEvent $event): void
    {
        $this->mailer->send(
            $event->user->getEmail(),
            'Zarejestrowano konto w systemie. Aktywacja konta trwa do 24h',
            'Zarejestrowano konto w systemie. Aktywacja konta trwa do 24h'
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserCreatedEvent::class => 'send'
        ];
    }
}
