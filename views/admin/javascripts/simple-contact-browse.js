if (!Omeka) {
    var Omeka = {};
}

Omeka.SimpleContactsBrowse = {};

(function ($) {
    Omeka.SimpleContactsBrowse.setupBatchEdit = function () {
        var simpleContactCheckboxes = $("table#simple-contacts tbody input[type=checkbox]");
        var globalCheckbox = $('th.batch-edit-heading').html('<input type="checkbox">').find('input');
        var batchEditSubmit = $('.batch-edit-option input');
        /**
         * Disable the batch submit button first, will be enabled once simple contacts
         * checkboxes are checked.
         */
        batchEditSubmit.prop('disabled', true);

        /**
         * Check all the simpleContactCheckboxes if the globalCheckbox is checked.
         */
        globalCheckbox.change(function() {
            simpleContactCheckboxes.prop('checked', !!this.checked);
            checkBatchEditSubmitButton();
        });

        /**
         * Uncheck the global checkbox if any of the simpleContactCheckboxes are
         * unchecked.
         */
        simpleContactCheckboxes.change(function(){
            if (!this.checked) {
                globalCheckbox.prop('checked', false);
            }
            checkBatchEditSubmitButton();
        });

        /**
         * Check whether the batchEditSubmit button should be enabled.
         * If any of the simpleContactCheckboxes is checked, the batchEditSubmit button
         * is enabled.
         */
        function checkBatchEditSubmitButton() {
            var checked = false;
            simpleContactCheckboxes.each(function() {
                if (this.checked) {
                    checked = true;
                    return false;
                }
            });

            batchEditSubmit.prop('disabled', !checked);
        }
    };
})(jQuery);

jQuery(document).ready(function() {
    // Set answered from any status.
    jQuery('input[name="submit-batch-answer"]').click(function(event) {
        event.preventDefault();
        jQuery('table#simple-contacts thead tr th.batch-edit-heading input').attr('checked', false);
        jQuery('.batch-edit-option input').prop('disabled', true);
        jQuery('table#simple-contacts tbody input[type=checkbox]:checked').each(function(){
            var checkbox = jQuery(this);
            var current = jQuery('.status#simple-contact-' + this.value);
            var ajaxUrl = current.attr('href') + '/simple-contact/ajax/update';
            current.addClass('transmit');
            jQuery.post(ajaxUrl,
                {
                    id: this.value,
                    status: 'answered'
                },
                function(data) {
                    checkbox.attr('checked', false);
                    current.addClass('answered');
                    current.removeClass('received');
                    current.removeClass('transmit');
                    if (current.text() != '') {
                        current.text(Omeka.messages.simpleContact.answered);
                    }
                }
            );
        });
    });

    // Set spam.
    jQuery('input[name="submit-batch-set-spam"]').click(function(event) {
        event.preventDefault();
        jQuery('table#simple-contacts thead tr th.batch-edit-heading input').attr('checked', false);
        jQuery('.batch-edit-option input').prop('disabled', true);
        jQuery('table#simple-contacts tbody input[type=checkbox]:checked').each(function(){
            var checkbox = jQuery(this);
            var current = jQuery('.is-spam#simple-contact-' + this.value);
            var ajaxUrl = current.attr('href') + '/simple-contact/ajax/update';
            current.addClass('transmit');
            jQuery.post(ajaxUrl,
                {
                    id: this.value,
                    is_spam: 'spam'
                },
                function(data) {
                    checkbox.attr('checked', false);
                    current.addClass('spam');
                    current.removeClass('not-spam');
                    current.removeClass('transmit');
                    if (current.text() != '') {
                        current.text(Omeka.messages.simpleContact.spam);
                    }
                }
            );
        });
    });

    // Set not spam.
    jQuery('input[name="submit-batch-set-not-spam"]').click(function(event) {
        event.preventDefault();
        jQuery('table#simple-contacts thead tr th.batch-edit-heading input').attr('checked', false);
        jQuery('.batch-edit-option input').prop('disabled', true);
        jQuery('table#simple-contacts tbody input[type=checkbox]:checked').each(function(){
            var checkbox = jQuery(this);
            var current = jQuery('.is-spam#simple-contact-' + this.value);
            var ajaxUrl = current.attr('href') + '/simple-contact/ajax/update';
            current.addClass('transmit');
            jQuery.post(ajaxUrl,
                {
                    id: this.value,
                    is_spam: 'not spam'
                },
                function(data) {
                    checkbox.attr('checked', false);
                    current.addClass('not-spam');
                    current.removeClass('spam');
                    current.removeClass('transmit');
                    if (current.text() != '') {
                        current.text(Omeka.messages.simpleContact.notSpam);
                    }
                }
            );
        });
    });

    // Delete a simple contact.
    jQuery('input[name="submit-batch-delete"]').click(function(event) {
        event.preventDefault();
        if (!confirm(Omeka.messages.simpleContact.confirmation)) {
            return;
        }
        jQuery('table#simple-contacts thead tr th.batch-edit-heading input').attr('checked', false);
        jQuery('.batch-edit-option input').prop('disabled', true);
        jQuery('table#simple-contacts tbody input[type=checkbox]:checked').each(function(){
            var checkbox = jQuery(this);
            var row = jQuery(this).closest('tr.simple-contact');
            var current = jQuery('#simple-contact-' + this.value);
            var ajaxUrl = current.attr('href') + '/simple-contact/ajax/delete';
            checkbox.addClass('transmit');
            jQuery.post(ajaxUrl,
                {
                    id: this.value
                },
                function(data) {
                    checkbox.attr('checked', false);
                    row.remove();
                }
            );
        });
    });
});
