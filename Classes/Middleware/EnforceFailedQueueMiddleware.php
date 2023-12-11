<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

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
        if ($envelope->last(SentToFailureTransportStamp::class) !== null) {
            $envelope = $envelope->withoutAll(SentToFailureTransportStamp::class);
        }

        return $stack->next()
            ->handle($envelope, $stack);
    }
}
