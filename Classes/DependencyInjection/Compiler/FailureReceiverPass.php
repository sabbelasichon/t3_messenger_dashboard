<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3MessengerDashboard\DependencyInjection\Compiler;

use Ssch\T3MessengerDashboard\Dashboard\Widgets\Controller\FailedMessageController;
use Ssch\T3MessengerDashboard\Dashboard\Widgets\Provider\FailedMessagesDataProvider;
use Ssch\T3MessengerDashboard\Repository\FailedMessageRepository;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use TYPO3\CMS\Core\Core\Environment;

final class FailureReceiverPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if(!$container->hasDefinition(FailedMessageRepository::class)) {
            return;
        }

        $failureMessageRepositoryDefinition = $container->getDefinition(FailedMessageRepository::class);

        // Remove everything if no fail queued is defined
        if(!$container->hasDefinition('console.command.messenger_failed_messages_show')) {
            $container->removeDefinition(FailedMessageRepository::class);
            $container->removeDefinition(FailedMessageController::class);
            $container->removeDefinition(FailedMessagesDataProvider::class);
            $container->removeDefinition('dashboard.widget.failedMessages');
            return;
        }

        $failedMessagesShowCommandDefinition = $container->getDefinition('console.command.messenger_failed_messages_show');
        $failureMessageRepositoryDefinition->replaceArgument(0, $failedMessagesShowCommandDefinition->getArgument(1));
    }
}
