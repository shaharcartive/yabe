jQuery( function ( $ ) {
    $("body").bind("fue_email_type_changed", function(evt, type) {
        wc_bookings_toggle_fields(type);
    });

    function wc_bookings_toggle_fields( type ) {

        if (type == "wc_bookings") {
            var show = ['.interval_type_wc_bookings', '.wc_bookings'];
            var hide = ['.interval_type_option', '.interval_duration_date', '.always_send_tr', '.signup_description', '.product_description_tr', '.product_tr', '.category_tr', '.use_custom_field_tr', '.custom_field_tr', '.var_item_names', '.var_item_categories', '.interval_type_after_last_purchase', '.var_customer'];

            $("option.interval_duration_date").attr("disabled", true);

            for (x = 0; x < hide.length; x++) {
                $(hide[x]).hide();
            }

            for (x = 0; x < show.length; x++) {
                $(show[x]).show();
            }

            $("#interval_type").change();
        } else {
            var hide = ['.interval_type_before_booking_event', '.interval_type_after_booking', '.interval_type_after_booking_approved', '.var_wc_bookings', '.wc_bookings'];

            for (x = 0; x < hide.length; x++) {
                $(hide[x]).hide();
            }
        }
    }
} );