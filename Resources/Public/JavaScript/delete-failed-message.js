import e from"@typo3/backend/modal.js";import{SeverityEnum as t}from"@typo3/backend/enum/severity.js";import s from"@typo3/core/event/regular-event.js";import a from"@typo3/core/ajax/ajax-request.js";import n from"@typo3/dashboard/widget-content-collector.js";class o{refresh(){const e=document.querySelector('[data-widget-key="failedMessages"]');n.getContentForWidget(e)}}new class{constructor(){this.selector=".js-t3-messenger-remove-message",this.initialize()}initialize(){new s("click",(function(s){s.preventDefault();const n=this.dataset.messageTransport,i=this.dataset.messageId;e.advanced({title:this.dataset.modalTitle,content:this.dataset.modalQuestion,severity:t.warning,staticBackdrop:!0,buttons:[{text:this.dataset.modalCancel,active:!0,btnClass:"btn-default",name:"cancel",trigger:(e,t)=>t.hideModal()},{text:this.dataset.modalOk,btnClass:"btn-warning",name:"delete",trigger:function(e,t){const s={id:i,transport:n};new a(TYPO3.settings.ajaxUrls.t3_messenger_failed_messages_delete).delete(JSON.stringify(s)).then((async function(){t.hideModal(),o.refresh()}))}}]})})).delegateTo(document,this.selector)}};
