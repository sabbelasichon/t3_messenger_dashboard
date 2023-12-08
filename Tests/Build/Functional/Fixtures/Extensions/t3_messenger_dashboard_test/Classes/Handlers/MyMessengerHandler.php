<?php

declare(strict_types=1);



namespace Ssch\T3MessengerDashboard\Tests\Functional\Fixtures\Extensions\t3_messenger_dashboard_test\Classes\Handlers;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Ssch\T3MessengerDashboard\Tests\Functional\Fixtures\Extensions\t3_messenger_dashboard_test\Classes\Command\MyFailingCommand;
use Ssch\T3MessengerDashboard\Tests\Functional\Fixtures\Extensions\t3_messenger_dashboard_test\Classes\Command\MyOtherFailingCommand;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class MyMessengerHandler implements MessageSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function thirdMessageMethod(MyFailingCommand $command): void
    {
        throw new \InvalidArgumentException('Failing by intention');
    }

    public function fourthMessageMethod(MyOtherFailingCommand $command): void
    {
        throw new \InvalidArgumentException('Failing by intention');
    }

    public static function getHandledMessages(): iterable
    {
        yield MyFailingCommand::class => [
            'method' => 'thirdMessageMethod',
        ];

        yield MyOtherFailingCommand::class => [
            'method' => 'fourthMessageMethod',
        ];
    }
}
