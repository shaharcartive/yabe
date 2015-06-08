/*global jQuery, document, window, smoothScroll, google, behanceAPI, CBPFWTabs, WOW*/
/* ==========================================================================
Document Ready Function
========================================================================== */
jQuery(document).ready(function () {

    'use strict';

    /* ==========================================================================
    MailChimp
    ========================================================================== */
    function mailchimpCallback(response) {

        jQuery('#ResponseModal').modal('show');
        if (response.result === 'success') {
            jQuery('form#newsletter-form input').val('');
            jQuery('#ResponseModal-title').html('Newsletter');
            jQuery('#ResponseModalLabel').html('<i class="glyphicon glyphicon-ok-circle nesto_success"></i>');
            jQuery('.nesto-response').html('Please check your e-mail to complete the subscription');
        } else if (response.result === 'error') {
            jQuery('#ResponseModal-title').html('Newsletter');
            jQuery('#ResponseModalLabel').html('<i class="glyphicon glyphicon-remove-circle nesto_error"></i>');
            jQuery('.nesto-response').html('Please enter unsubscribed & valid e-mail address');
        }
    }
    jQuery('#newsletter-form').ajaxChimp({
        callback: mailchimpCallback,
        url: 'http://wew'
    });
	
});