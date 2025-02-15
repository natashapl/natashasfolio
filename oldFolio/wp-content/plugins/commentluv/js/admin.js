jQuery(document).ready(function () {
    clsubmit = jQuery('#clsubmit');

    jQuery(clsubmit).data('form', jQuery('form.cl_admin_form').serialize());
    jQuery(clsubmit).data('background', clsubmit.css('background'));
    // set width in px to make button center align for all languages

    jQuery('#cl_notify').css('width', jQuery('#cl_notify').width());

    // hide options if commentluv is disabled
    if (jQuery('.clenable:checked').val() == 'no') {
        jQuery('.ifenable').hide();
    }

    // change save settings button if any options were changed
    jQuery('.cl_admin_form input').change(check_change);
    // listener for click of button to subscribe

    // listener for click of enable radio buttons
    jQuery('.clenable').click(function () {
        if (jQuery(this).val() == 'yes') {
            // show the rest of the functions
            jQuery('.ifenable').show();
        } else {
            jQuery('.ifenable').hide();
        }
    });
    // listener for change of badge drop down
    jQuery('#badge_type').change(function () {
        var choice = jQuery(this).val();
        var image = notify_signup_settings[choice];
        jQuery('#display_badge').attr('src', notify_signup_settings.image_url + image);
        jQuery('#display_badge').show();

    });
    // listener for focus of input in display settings panel
    jQuery('.display-settings input').focus(function () {
        jQuery(this).prev('input').attr('checked', true);
        check_change();
    });
});

function check_change() {
    var formdata = jQuery('form.cl_admin_form').serialize();
    if (formdata != jQuery(clsubmit).data('form')) {
        jQuery('#clsubmit').css({'background': 'orange', 'font-weight': 'bolder'});
    } else {
        jQuery('#clsubmit').css({'background': jQuery(clsubmit).data('background'), 'font-weight': 'inherit'});
    }
}