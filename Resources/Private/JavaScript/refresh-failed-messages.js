import DashboardWidget from '@typo3/dashboard/widget-content-collector.js';

export default class RefreshFailedMessages {
    refresh() {
        const failedMessages = document.querySelector('[data-widget-key="failedMessages"]');
        DashboardWidget.getContentForWidget(failedMessages);
    }
}
