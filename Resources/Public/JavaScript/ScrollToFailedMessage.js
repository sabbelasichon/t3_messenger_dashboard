define(['jquery'], function ($) {
    $('.dashboard-item[data-widget-key="failedMessages"]').on('widgetContentRendered', function (event) {
        var urlParams = new URLSearchParams(window.location.search);
        var $element = $(event.target).find('#failed-widget-' + urlParams.get('messageId'));
        if ($element.length) {
            $element.css("background-color","#ffeeba");
            $element[0].scrollIntoView();
        }
    });
});
