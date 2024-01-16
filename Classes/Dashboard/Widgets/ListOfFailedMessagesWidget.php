<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3MessengerDashboard\Dashboard\Widgets;

use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Dashboard\Widgets\JavaScriptInterface;
use TYPO3\CMS\Dashboard\Widgets\ListDataProviderInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

final class ListOfFailedMessagesWidget implements WidgetInterface, JavaScriptInterface
{
    public function __construct(private readonly WidgetConfigurationInterface $configuration, private readonly ListDataProviderInterface    $dataProvider, private readonly StandaloneView               $view, private readonly array                        $options = [])
    {
    }

    public function renderWidgetContent(): string
    {
        $this->view->setTemplate('Widget/ListOfFailedMessagesWidget');
        $this->view->assignMultiple([
            'configuration' => $this->configuration,
            'failedMessages' => $this->dataProvider->getItems(),
            'options' => $this->options,
        ]);

        return $this->view->render();
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getJavaScriptModuleInstructions(): array
    {
        return [
            JavaScriptModuleInstruction::create('@ssch/t3-messenger-dashboard/delete-failed-message.js'),
            JavaScriptModuleInstruction::create('@ssch/t3-messenger-dashboard/scroll-to-failed-message.js'),
        ];
    }

}
