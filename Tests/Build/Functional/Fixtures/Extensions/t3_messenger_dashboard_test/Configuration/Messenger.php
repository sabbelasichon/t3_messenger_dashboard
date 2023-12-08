<?php

declare(strict_types=1);


use Ssch\T3MessengerDashboard\Tests\Functional\Fixtures\Extensions\t3_messenger_dashboard_test\Classes\Command\MyFailingCommand;

return [
    'failure_transport' => 'failed',
    'default_bus' => 'command.bus',
    'transports' => [
        'async' => [
            'dsn' => 'typo3-db://Default',
            'retry_strategy' => [
                'max_retries' => 0,
            ],
        ],
        'failed' => [
            'dsn' => 'typo3-db://Default?queue_name=failed',
        ],
        'sync' => [
            'dsn' => 'sync://',
        ],
    ],
    'routing' => [
        MyFailingCommand::class => [
            'senders' => ['sync'],
        ],
    ],
    'buses' => [
        'command.bus' => [],
    ],
];
