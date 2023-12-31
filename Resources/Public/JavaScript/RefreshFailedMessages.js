define(['require', "TYPO3/CMS/Dashboard/WidgetContentCollector"], function (require, DashboardWidget) {
    "use strict";
    return new class {
        refresh() {
            const failedMessages = document.querySelector('[data-widget-key="failedMessages"]');
            DashboardWidget.getContentForWidget(failedMessages);
        }
    }
});
