<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3MessengerDashboard\Domain\Dto;

use DateTimeInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\ErrorDetailsStamp;
use Symfony\Component\Messenger\Stamp\RedeliveryStamp;
use Symfony\Component\Messenger\Stamp\TransportMessageIdStamp;

final readonly class FailedMessage
{
    /**
     * @param class-string $message
     */
    private function __construct(
        private string $message,
        private string $shortMessageClass,
        private string $errorMessage,
        private DateTimeInterface $redelivered,
        private int $retryCount,
        private mixed $messageId,
        private string $transportName
    ) {
    }

    public function getShortMessageClass(): string
    {
        return $this->shortMessageClass;
    }

    public function getMessageId(): mixed
    {
        return $this->messageId;
    }

    /**
     * @return class-string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    public function getRedelivered(): DateTimeInterface
    {
        return $this->redelivered;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getTransportName(): string
    {
        return $this->transportName;
    }

    public function getRetryCount(): int
    {
        return $this->retryCount;
    }

    public static function createFromEnvelope(Envelope $failedMessage, string $transportName): self
    {
        $errorDetailsStamp = $failedMessage->last(ErrorDetailsStamp::class);

        if (! $errorDetailsStamp instanceof ErrorDetailsStamp) {
            throw new \UnexpectedValueException('No error details stamp given');
        }

        $errorMessage = $errorDetailsStamp->getExceptionMessage();

        $redeliveryStamp = $failedMessage->last(RedeliveryStamp::class);

        if (! $redeliveryStamp instanceof RedeliveryStamp) {
            throw new \UnexpectedValueException('No redelivery stamp given');
        }

        $transportMessageIdStamp = $failedMessage->last(TransportMessageIdStamp::class);
        if (! $transportMessageIdStamp instanceof TransportMessageIdStamp) {
            throw new \UnexpectedValueException('No transport message id stamp given');
        }

        return new self(
            $failedMessage->getMessage()::class,
            (new \ReflectionClass($failedMessage->getMessage()))->getShortName(),
            $errorMessage,
            $redeliveryStamp->getRedeliveredAt(),
            $redeliveryStamp->getRetryCount(),
            $transportMessageIdStamp->getId(),
            $transportName
        );
    }
}
