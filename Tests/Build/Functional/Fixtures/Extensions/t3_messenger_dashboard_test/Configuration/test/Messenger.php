<?php

declare(strict_types=1);

use Ssch\T3MessengerDashboard\Tests\Functional\Fixtures\Extensions\t3_messenger_dashboard_test\Classes\Command\MyFailingCommand;
use Ssch\T3MessengerDashboard\Tests\Functional\Fixtures\Extensions\t3_messenger_dashboard_test\Classes\Command\MyOtherFailingCommand;


return [
    'routing' => [
        MyFailingCommand::class => [
            'senders' => ['async'],
        ],
        MyOtherFailingCommand::class => [
            'senders' => ['async'],
        ],
    ],
];
