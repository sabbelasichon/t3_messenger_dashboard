<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Ssch\T3MessengerDashboard\Dashboard\Widgets\Controller\FailedMessageController;

return [
    't3_messenger_failed_messages_delete' => [
        'path' => '/t3-messenger/failed-messages/delete',
        'target' => FailedMessageController::class . '::deleteMessageAction',
    ],
];
