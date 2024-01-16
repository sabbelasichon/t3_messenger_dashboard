import $ from 'jquery';
$('.dashboard-item[data-widget-key="failedMessages"]').on('widgetContentRendered', function (event) {
    const urlParams = new URLSearchParams(window.location.search);
    const $element = $(event.target).find('#failed-widget-' + urlParams.get('messageId'));
    if ($element.length) {
        $element.css("background-color", "#ffeeba");
        $element[0].scrollIntoView();
    }
});
