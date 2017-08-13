//<![CDATA[

Window.keepMultiModalWindow = true;
window.bsModal = '';
var catalogWysiwygEditor = {
    overlayShowEffectOptions : null,
    overlayHideEffectOptions : null,
    modal: null,
    open : function(editorUrl, elementId) {
        bsModal = jQuery.fn.modal.noConflict();
        if (editorUrl && elementId) {
           jQuery.ajax({
                url: editorUrl,
                data: {
                    element_id: elementId + '_editor',
                    store_id: '0'
                },
                showLoader: true,
                dataType: 'html',
                success: function(data, textStatus, transport) {
                    this.openDialogWindow(data, elementId);
                }.bind(this)
            });
        }
    },
    openDialogWindow : function(data, elementId) {
        var self = this;

        if (this.modal) {
            this.modal.html(jQuery(data).html());
        } else {
            this.modal = jQuery(data).modal({
                title: 'WYSIWYG Editor',
                modalClass: 'magento',
                type: 'slide',
                firedElementId: elementId,
                buttons: [{
                    text: jQuery.mage.__('Cancel'),
                    click: function () {
                        self.closeDialogWindow(this);
                    }
                },{
                    text: jQuery.mage.__('Submit'),
                    click: function () {
                        self.okDialogWindow(this);
                    }
                }],
                close: function () {
                    self.closeDialogWindow(this);
                },
                closed: function () {
                    jQuery.fn.modal = bsModal;
                },
            });
        }
        this.modal.modal('openModal');
        $(elementId + '_editor').value = $(elementId).innerHTML;
    },
    okDialogWindow : function(dialogWindow) {
        console.log("12345");
        console.log(dialogWindow.options.firedElementId);
        if (dialogWindow.options.firedElementId) {
            wysiwygObj = eval('wysiwyg'+dialogWindow.options.firedElementId+'_editor');
            wysiwygObj.turnOff();
            console.log(wysiwygObj.id);
            console.log(tinyMCE.get(wysiwygObj.id));
            if (tinyMCE.get(wysiwygObj.id)) {
                $(dialogWindow.options.firedElementId).innerHTML = tinyMCE.get(wysiwygObj.id).getContent();
                console.log($(dialogWindow.options.firedElementId).innerHTML);
            } else {
                if ($(dialogWindow.options.firedElementId+'_editor')) {
                    $(dialogWindow.options.firedElementId).innerHTML = $(dialogWindow.options.firedElementId+'_editor').value;
                }
            }
            //tinyMCE.editors[dialogWindow.options.firedElementId].load();
            if (typeof varienGlobalEvents != undefined) {
                varienGlobalEvents.fireEvent('tinymceChange');
            }
        }
        this.closeDialogWindow(dialogWindow);
    },
    closeDialogWindow : function(dialogWindow) {
        // remove form validation event after closing editor to prevent errors during save main form
        if (typeof varienGlobalEvents != undefined && editorFormValidationHandler) {
            varienGlobalEvents.removeEventHandler('formSubmit', editorFormValidationHandler);
        }

        //IE fix - blocked form fields after closing
        try {
            $(dialogWindow.options.firedElementId).focus();
        } catch (e) {
            //ie8 cannot focus hidden elements
        }

        //destroy the instance of editor
        wysiwygObj = eval('wysiwyg'+dialogWindow.options.firedElementId+'_editor');
        if (tinyMCE.get(wysiwygObj.id)) {
           tinyMCE.execCommand('mceRemoveControl', true, wysiwygObj.id);
        }

        dialogWindow.closeModal();
        Windows.overlayShowEffectOptions = this.overlayShowEffectOptions;
        Windows.overlayHideEffectOptions = this.overlayHideEffectOptions;
    }
};

window.catalogWysiwygEditor = catalogWysiwygEditor;
//]]>
