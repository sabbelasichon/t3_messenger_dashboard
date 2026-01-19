<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3MessengerDashboard\Repository;

use Ssch\T3MessengerDashboard\Dashboard\Widgets\Dto\MessageSpecification;
use Ssch\T3MessengerDashboard\Domain\Dto\FailedMessage;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Receiver\ListableReceiverInterface;
use Symfony\Contracts\Service\ServiceProviderInterface;

final readonly class FailedMessageRepository
{
    /**
     * @param ServiceProviderInterface<ListableReceiverInterface> $failureTransports
     */
    public function __construct(
        private ServiceProviderInterface $failureTransports
    ) {
    }

    /**
     * @return FailedMessage[]
     */
    public function list(): array
    {
        $allFailedMessages = [];
        foreach ($this->failureTransports->getProvidedServices() as $serviceId => $_) {
            try {
                $failureTransport = $this->getReceiver($serviceId);
            } catch (\RuntimeException) {
                continue;
            }

            $failedMessages = $this->inReverseOrder($failureTransport->all());

            foreach ($failedMessages as $failedMessage) {
                $allFailedMessages[] = FailedMessage::createFromEnvelope($failedMessage, $serviceId);
            }
        }

        return $allFailedMessages;
    }

    public function removeMessage(MessageSpecification $messageSpecification): void
    {
        $failureTransport = $this->getReceiver($messageSpecification->getTransport());

        $envelope = $this->findMessage($messageSpecification->getId(), $failureTransport);

        $failureTransport->reject($envelope);
    }

    /**
     * @param Envelope[] $failedMessages
     *
     * @return Envelope[]
     */
    private function inReverseOrder(iterable $failedMessages): array
    {
        if (! is_array($failedMessages)) {
            $failedMessages = iterator_to_array($failedMessages);
        }

        return array_reverse($failedMessages);
    }

    private function getReceiver(string $transport): ListableReceiverInterface
    {
        $failureTransport = $this->failureTransports->get($transport);

        if (! $failureTransport instanceof ListableReceiverInterface) {
            throw new RuntimeException(sprintf(
                'The "%s" receiver does not support removing specific messages.',
                $transport
            ));
        }

        return $failureTransport;
    }

    private function findMessage(int|string $messageId, ListableReceiverInterface $failureTransport): Envelope
    {
        $envelope = $failureTransport->find($messageId);
        if ($envelope === null) {
            throw new RuntimeException(sprintf('The message with id "%s" was not found.', $messageId));
        }

        return $envelope;
    }
}
