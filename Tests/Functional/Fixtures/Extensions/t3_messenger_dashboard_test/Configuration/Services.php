<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Ssch\T3MessengerDashboard\Tests\Functional\Fixtures\Extensions\t3_messenger_dashboard_test\Classes\Handlers\MyMessengerHandler;
use Ssch\T3MessengerDashboard\Tests\Functional\Fixtures\Extensions\t3_messenger_dashboard_test\Classes\Handlers\MySecondMessengerHandler;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->set(MyMessengerHandler::class);
    $services->set(MySecondMessengerHandler::class);
};
