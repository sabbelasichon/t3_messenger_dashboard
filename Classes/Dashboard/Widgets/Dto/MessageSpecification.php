<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3MessengerDashboard\Dashboard\Widgets\Dto;

use Ssch\T3MessengerDashboard\Domain\Dto\FailedMessage;
use Webmozart\Assert\Assert;

final class MessageSpecification
{
    /**
     * @param string|int $id
     */
    private function __construct(
        private $id,
        private readonly string $transport
    ) {
    }

    public static function fromArray(array $array): self
    {
        Assert::keyExists($array, 'id');
        Assert::keyExists($array, 'transport');

        return new self($array['id'], $array['transport']);
    }

    public static function fromFailedMessage(FailedMessage $failedMessage): self
    {
        return new self($failedMessage->getMessageId(), $failedMessage->getTransportName());
    }

    /**
     * @return string|int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getTransport(): string
    {
        return $this->transport;
    }
}
