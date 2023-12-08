<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

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
