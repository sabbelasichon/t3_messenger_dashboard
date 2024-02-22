<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

return [
    'dependencies' => ['core', 'backend'],
    'imports' => [
        '@ssch/t3-messenger-dashboard/' => 'EXT:t3_messenger_dashboard/Resources/Public/JavaScript/',
    ],
];
