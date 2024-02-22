import { default as Modal } from '@typo3/backend/modal.js'
import { SeverityEnum } from '@typo3/backend/enum/severity.js'
import RegularEvent from '@typo3/core/event/regular-event.js'
import AjaxRequest from '@typo3/core/ajax/ajax-request.js'
import DashboardWidget from '@typo3/dashboard/widget-content-collector.js';

(() => {
    return new class {
        constructor() {
            this.selector = ".js-t3-messenger-remove-message", this.initialize()
        }

        initialize() {
            new RegularEvent("click", (function (e) {
                e.preventDefault();

                const messageTransport = this.dataset.messageTransport
                const id = this.dataset.messageId
                Modal.advanced({
                    title: this.dataset.modalTitle,
                    content: this.dataset.modalQuestion,
                    severity: SeverityEnum.warning,
                    staticBackdrop: true,
                    buttons: [
                        {
                            text: this.dataset.modalCancel,
                            active: !0,
                            btnClass: "btn-default",
                            name: "cancel",
                            trigger: (event, modal) => modal.hideModal()
                        },
                        {
                            text: this.dataset.modalOk,
                            btnClass: "btn-warning",
                            name: "delete",
                            trigger: function(event, modal) {
                                const payload = {'id': id, 'transport': messageTransport};
                                new AjaxRequest(TYPO3.settings.ajaxUrls.t3_messenger_failed_messages_delete)
                                    .delete(JSON.stringify(payload))
                                    .then(async function () {
                                        modal.hideModal();
                                        const failedMessages = document.querySelector('[data-widget-key="failedMessages"]');
                                        DashboardWidget.getContentForWidget(failedMessages);
                                    });
                            }
                        }
                    ]
                });
            })).delegateTo(document, this.selector)
        }
    }
})();
