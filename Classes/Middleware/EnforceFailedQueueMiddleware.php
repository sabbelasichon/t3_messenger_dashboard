<?php

declare(strict_types=1);

namespace Ssch\T3MessengerDashboard\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\SentToFailureTransportStamp;

/**
 * @see https://get-the-most.de/2021/03/20/symfony-messenger-behandlung-erneut-fehlgeschlagener-nachrichten/
 */
final class EnforceFailedQueueMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (null !== $envelope->last(SentToFailureTransportStamp::class)) {
            $envelope = $envelope->withoutAll(SentToFailureTransportStamp::class);
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
