<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Ssch\T3MessengerDashboard\Dashboard\Widgets\ListOfFailedMessagesWidget;
use Ssch\T3MessengerDashboard\Dashboard\Widgets\Provider\FailedMessagesDataProvider;
use Ssch\T3MessengerDashboard\DependencyInjection\Compiler\FailureReceiverPass;
use Ssch\T3MessengerDashboard\Repository\FailedMessageRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\abstract_arg;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->private()
        ->autowire()
        ->autoconfigure();

    // Test configuration ignore
    $containerConfigurator->import(__DIR__ . '/../Classes/Test/Configuration/Services.php', null, true);

    $services->load('Ssch\\T3MessengerDashboard\\', __DIR__ . '/../Classes/')
        ->exclude([
            __DIR__ . '/../Classes/DependencyInjection',
            __DIR__ . '/../Classes/Test/Configuration',
            __DIR__ . '/../Classes/Test/Command',
        ]);

    // Dashboard Integration
    $services->set(FailedMessageRepository::class)->args(
        [abstract_arg('failure_transports'), service('event_dispatcher')]
    );
    $services
        ->set('dashboard.widget.failedMessages')
        ->class(ListOfFailedMessagesWidget::class)
        ->arg('$dataProvider', service(FailedMessagesDataProvider::class))
        ->arg('$view', service('dashboard.views.widget'))
        ->tag(
            'dashboard.widget',
            [
                'identifier' => 'failedMessages',
                'groupNames' => 'news',
                'title' => 'LLL:EXT:t3_messenger_dashboard/Resources/Private/Language/locallang.xlf:widgets.failedMessages.title',
                'description' => 'LLL:EXT:t3_messenger_dashboard/Resources/Private/Language/locallang.xlf:widgets.failedMessages.description',
                'iconIdentifier' => 'tx-messenger-failed-messages-icon',
                'height' => 'large',
                'width' => 'large',
            ]
        );

    $containerBuilder->addCompilerPass(new FailureReceiverPass());
};
