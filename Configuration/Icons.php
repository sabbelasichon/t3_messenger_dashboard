<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'tx-messenger-failed-messages-icon' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:t3_messenger_dashboard/Resources/Public/Icons/failed-messages.svg',
    ],
];
