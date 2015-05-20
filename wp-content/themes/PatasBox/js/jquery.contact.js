/*global jQuery, document*/
/* ==========================================================================
Document Ready Function
========================================================================== */
jQuery(document).ready(function () {

    'use strict';

    var emailReg, successmessage, failedmessage, useremail, isvalid, url, checkbox, checkbox2;

    jQuery('#newsletter-form').submit(
		function nestocontact() {

            emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

            successmessage = "Gracias" + ", te acabamos de enviar un email.</br> Estará en tu buzón de entrada y si no, </br>puedes chequear tu correo no deseado.";
            failedmessage = "Ha habido un problema, por favor intentalo de nuevo más tarde.";
            useremail = jQuery('#contact-email');
            checkbox = jQuery('#checkbox');

            isvalid = 1;
            url = "http://htcvr.es/sandbox/wp-content/themes/PatasBox/php/contact.php";

            if (useremail.val() === "") {
                jQuery('#ResponseModal-title').html('PatasBox');
                jQuery('#contact-email').addClass('form-error');
                jQuery('#ResponseModal').modal('show');
                jQuery('#ResponseModalLabel').html('<img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/no.png">');
                jQuery('.nesto-response').html('No has introducido una dirección de email');
                return false;
			}
            var valid = emailReg.test(useremail.val());
            if (!valid) {
                jQuery('#ResponseModal-title').html('PatasBox');
                jQuery('#contact-email').addClass('form-error');
                jQuery('#ResponseModal').modal('show');
                jQuery('#ResponseModalLabel').html('<img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/no.png">');
                jQuery('.nesto-response').html('Por favor introduce una dirección de email valida');
                jQuery('input[type=submit]', jQuery("#contactform")).removeAttr('disabled');
                return false;
			}

   			if (checkbox.prop('checked') == false ) {
			 	jQuery('#ResponseModal-title').html('PatasBox');
                jQuery('#contact-email').addClass('form-error');
                jQuery('#ResponseModal').modal('show');
                jQuery('#ResponseModalLabel').html('<img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/no.png">');
                jQuery('.nesto-response').html('Debes aceptar los términos y condiciones');
			 	return false;
			}
			
            jQuery.post(url, { useremail: useremail.val(), isvalid: isvalid }, function (data) {
                if (data === 'success') {
                    jQuery('#ResponseModal-title').html('PatasBox');
                    jQuery('#ResponseModal').modal('show');
                    jQuery('#ResponseModalLabel').html('<img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/ok.png">');
                    jQuery('.nesto-response').html(successmessage);
                    jQuery('#contact-email').val('');
				} else {
                    jQuery('#ResponseModal').modal('show');
                    jQuery('#ResponseModalLabel').html('<img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/no.png">');
                    jQuery('.nesto-response').html(failedmessage);
                    return false;
				}
			});
		}

	);
    jQuery('#contact-email').focus(function () {
        jQuery('#contact-email').removeClass('form-error');
        jQuery('.form-message').html('');
    });
    
    
	jQuery('#newsletter-form-2').submit(
		function nestocontact2() {
		
			checkbox2 = jQuery('#checkbox2');

            emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

            successmessage = "Gracias" + ", te acabamos de enviar un email.</br> Estará en tu buzón de entrada y si no, </br>puedes chequear tu correo no deseado.";
            failedmessage = "Ha habido un problema, por favor intentalo de nuevo más tarde.";
            useremail = jQuery('#contact-email-2');
            checkbox = jQuery('#checkbox');
            isvalid = 1;
            url = "http://htcvr.es/sandbox/wp-content/themes/PatasBox/php/contact.php";

            if (useremail.val() === "") {
                jQuery('#ResponseModal-title').html('PatasBox');
                jQuery('#contact-email-2').addClass('form-error');
                jQuery('#ResponseModal').modal('show');
                jQuery('#ResponseModalLabel').html('<img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/no.png">');
                jQuery('.nesto-response').html('No has introducido una dirección de email');
                return false;
			}
            var valid = emailReg.test(useremail.val());
            if (!valid) {
                jQuery('#ResponseModal-title').html('PatasBox');
                jQuery('#contact-email-2').addClass('form-error');
                jQuery('#ResponseModal').modal('show');
                jQuery('#ResponseModalLabel').html('<img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/no.png">');
                jQuery('.nesto-response').html('Por favor introduce una dirección de email valida');
                jQuery('input[type=submit]', jQuery("#contactform")).removeAttr('disabled');
                return false;
			}

   			if (checkbox2.prop('checked') == false ) {
			 	jQuery('#ResponseModal-title').html('PatasBox');
                jQuery('#contact-email-2').addClass('form-error');
                jQuery('#ResponseModal').modal('show');
                jQuery('#ResponseModalLabel').html('<img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/no.png">');
                jQuery('.nesto-response').html('Debes aceptar los términos y condiciones');
			 	return false;
			}
			
            jQuery.post(url, { useremail: useremail.val(), isvalid: isvalid }, function (data) {
                if (data === 'success') {
                    jQuery('#ResponseModal-title').html('PatasBox');
                    jQuery('#ResponseModal').modal('show');
                    jQuery('#ResponseModalLabel').html('<img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/ok.png">');
                    jQuery('.nesto-response').html(successmessage);
                    jQuery('#contact-email').val('');
				} else {
                    jQuery('#ResponseModal').modal('show');
                    jQuery('#ResponseModalLabel').html('<img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/no.png">');
                    jQuery('.nesto-response').html(failedmessage);
                    return false;
				}
			});
		}

	);
    jQuery('#contact-email-2').focus(function () {
        jQuery('#contact-email-2').removeClass('form-error');
        jQuery('.form-message').html('');
    });
});