const dashboardItem = document.querySelector('[data-widget-key="failedMessages"]');

if (dashboardItem) {
    dashboardItem.addEventListener('widgetContentRendered', (event) => {
        const urlParams = new URLSearchParams(window.location.search);
        const messageId = urlParams.get('messageId');

        if (!messageId) return;

        const element = event.target.querySelector(
            `#failed-widget-${messageId}`
        );

        if (element) {
            element.style.backgroundColor = '#ffeeba';
            element.scrollIntoView();
        }
    });
}
