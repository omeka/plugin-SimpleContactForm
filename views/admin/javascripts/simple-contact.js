jQuery(document).ready(function() {
    // Handle status.
    jQuery('.simple-contact.toggle-status').click(function(event) {
        event.preventDefault();
        var id = jQuery(this).attr('id');
        var current = jQuery('.status#' + id);
        id = id.substr(id.lastIndexOf('-') + 1);
        var ajaxUrl = jQuery(this).attr('href') + '/simple-contact/ajax/update';
        jQuery(this).addClass('transmit');
        if (jQuery(this).hasClass('answered')) {
            jQuery.post(ajaxUrl,
                {
                    id: id,
                    status: 'received'
                },
                function(data) {
                    current.addClass('received');
                    current.removeClass('answered');
                    current.removeClass('transmit');
                    if (current.text() != '') {
                        current.text(Omeka.messages.simpleContact.received);
                    }
                }
            );
        } else {
            jQuery.post(ajaxUrl,
                {
                    id: id,
                    status: 'answered'
                },
                function(data) {
                    current.addClass('answered');
                    current.removeClass('received');
                    current.removeClass('transmit');
                    if (current.text() != '') {
                        current.text(Omeka.messages.simpleContact.answered);
                    }
                }
            );
        }
    });
    // Handle spam.
    jQuery('.simple-contact.toggle-is-spam').click(function(event) {
        event.preventDefault();
        var id = jQuery(this).attr('id');
        var current = jQuery('.is-spam#' + id);
        id = id.substr(id.lastIndexOf('-') + 1);
        var ajaxUrl = jQuery(this).attr('href') + '/simple-contact/ajax/update';
        jQuery(this).addClass('transmit');
        if (jQuery(this).hasClass('spam')) {
            jQuery.post(ajaxUrl,
                {
                    id: id,
                    is_spam: 'not spam'
                },
                function(data) {
                    current.addClass('not-spam');
                    current.removeClass('spam');
                    current.removeClass('undefined');
                    current.removeClass('transmit');
                    if (current.text() != '') {
                        current.text(Omeka.messages.simpleContact.notSpam);
                    }
                }
            );
        } else {
            jQuery.post(ajaxUrl,
                {
                    id: id,
                    is_spam: 'spam'
                },
                function(data) {
                    current.addClass('spam');
                    current.removeClass('not-spam');
                    current.removeClass('undefined');
                    current.removeClass('transmit');
                    if (current.text() != '') {
                        current.text(Omeka.messages.simpleContact.spam);
                    }
                }
            );
        }
    });
});
