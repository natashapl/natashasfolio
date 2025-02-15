// commentluv 2.94.8
jQuery(document).ready(function () {
    // get the form object and fields
    var formObj = jQuery('#cl_post_title').parents('form');
    var urlObj = cl_settings['urlObj'] = jQuery("input[name='" + cl_settings['url'] + "']", formObj);
    var comObj = cl_settings['comObj'] = jQuery("textarea[name='" + cl_settings['comment'] + "']", formObj);
    var autObj = jQuery("input[name='" + cl_settings['name'] + "']", formObj);
    var emaObj = jQuery("input[name='" + cl_settings['email'] + "']", formObj);
    // setup localized object with temporary vars
    cl_settings['url_value'] = urlObj.val();
    cl_settings['fired'] = 'no';

    // set event listener for textarea focus
    comObj.focus(cl_dostuff);

    // set event listener for url blur
    urlObj.blur(cl_dostuff);

    // set the event listener for the click of the checkbox
    jQuery('#doluv').click(function () {
        jQuery('#lastposts').hide();
        if (jQuery(this).is(":checked")) {
            // was unchecked, now is checked
            jQuery('#mylastpost').fadeTo("fast", 1);
            cl_settings['fired'] = 'no';
            cl_dostuff();
        } else {
            // was checked, user unchecked it so empty hidden fields in form
            jQuery('input[name="cl_post_title"]').val("");
            jQuery('input[name="cl_post_url"]').val("");
            jQuery('#mylastpost').fadeTo("slow", 0.3);
            jQuery('#lastposts').empty();
        }
    });
    // click event for last blog post link
    jQuery('.cluv a').click(function () {
        var data = jQuery(this).attr('class').split(' ');
        // store click count
        cl_try_ajax({
            type: 'POST',
            data: {
                'action': 'cl_ajax',
                'cid': data[1],
                '_ajax_nonce': data[0],
                'cl_prem': jQuery(this).hasClass('p'),
                'url': jQuery(this).attr('href'),
                'do': 'click'
            }
        });
        jQuery(this).attr('target', '_blank');
        return true;
    });
    // hover event on heart
    if (cl_settings['infopanel'] == "on") {
        jQuery('.heart_tip_box').mouseenter(heart_big);
    }
    // hide/show showmore
    jQuery(document.body).click(function () {
        if (cl_settings['lastposts'] == 'showing') {
            jQuery('#lastposts').slideUp('', function () {
                cl_settings['lastposts'] = 'not'
            });
        }
    });
    jQuery('#showmorespan img').click(function () {
        if (cl_settings['lastposts'] == 'not') {
            jQuery('#lastposts').slideDown('', function () {
                cl_settings['lastposts'] = 'showing'
            });
        }
    });
    // clear hidden inputs on load
    jQuery('#cl_post_title,#cl_post_url,#cl_prem').val('');
    // set click on anywhere closes info box 
    jQuery(document).click(heart_small);
    // add info panel to page
    jQuery("body").append('<span id="heart_tip_big" style="display: none;position:absolute; z-index: 1001; background-color: ' + cl_settings['infoback'] + '; color: ' + cl_settings['infotext'] + '; width: 62px;"></span>');

    // hover over to see raw file wrapper open
    jQuery('#commentluv').on('mouseover', '.rawfilewrap', function () {
        jQuery('.rawfile').show();
    });

    jQuery('#commentluv').on('mouseout', '.rawfilewrap', function () {
        jQuery('.rawfile').hide();
    });
});

/**
 * checks everything is in place for doing stuff
 * returns string 'ok' if, um, ok
 */
function cl_docheck() {
    // checkbox check
    if (!jQuery('#doluv').is(':checked')) {
        return 'not checked';
    }
    var url = cl_settings['urlObj'];
    var msg = jQuery('#cl_messages');
    msg.hide();
    url.removeClass('cl_error');
    // logged in user?
    var nourlmessage = cl_settings['no_url_message'];
    if (cl_settings['logged_in'] == '1') {
        nourlmessage = cl_settings['no_url_logged_in_message'];
    } else {
        // check if fb connect is active
        if (!cl_settings['urlObj'].is(':visible') && typeof FB != 'undefined') {
            var invisurl = cl_settings['urlObj'].remove();
            var invismsg = msg.remove();
            cl_settings['comObj'].after('<br><span id="invisurl">').after(invismsg);
            jQuery('#invisurl').append('URL ').after(invisurl).append('</span>');
        }

    }
    // check that there is a value in the url field
    if (url.val().length > 1) {
        var urlLower = url.val().toLowerCase();

        // is value just http:// ?
        if (urlLower == 'http://' || urlLower == 'https://') {
            url.addClass('cl_error');
            cl_message(nourlmessage);
            return;
        }
        // is the http:// missing?
        if (urlLower.substring(0, 7) != 'http://' && urlLower.substring(0, 8) != 'https://') {
            url.addClass('cl_error');
            cl_message(cl_settings['no_http_message']);
            return;
        }
    } else {
        // there is no value
        url.addClass('cl_error');
        cl_message(nourlmessage);
        return;
    }
    // if we are here, all is cool mon
    return 'ok';
}

/**
 * tries various methods to get request through to admin-ajax url
 */
function cl_try_ajax(args) {
    args.origError = args.origError || args.error || function () {
    };

    args.lastError = args.lastError || undefined;
    args.url = args.url || cl_settings['api_url'];
    if (window.location.protocol === 'https:' && args.url.indexOf('http:') === 0) {
        // we were trying to ajax http://, but our current window is https://, so backend would likely also be https://
        // an https to http ajax request is impossible based on CORS spec
        args.url = args.url.replace(/^http:/, 'https:');
    }

    if (args.lastError !== undefined && args.url === args.lastUrl) {
        return args.origError(args.lastError.x, args.lastError.e);
    }

    args.error = function (x, e) {
        args.lastError = {x: x, e: e};
        args.lastUrl = args.url;
        args.url = cl_settings['api_url_alt'] || cl_settings['api_url'];

        // try again
        cl_try_ajax(args);
    };

    return jQuery.ajax(args);
};

/**
 * tries to fetch last blog posts for a url
 */
function cl_dostuff() {
    if (cl_docheck() != 'ok') {
        return;
    }

    var msg = jQuery('#cl_messages');

    var url = cl_settings['urlObj'];
    if (cl_settings['fired'] == 'yes') {
        // already fired, fire again if current url is different to last fired
        if (url.val() == cl_settings['url_value']) {
            msg.show();
            return;
        }
        jQuery('#lastposts,#mylastpost').empty();
    }

    // fire the request to admin
    msg.append('<img src="' + cl_settings['images'] + 'loader.gif' + '"/>').show();

    cl_try_ajax({
        type: 'post',
        dataType: 'json',
        data: {'url': url.val(), 'action': 'cl_ajax', 'do': 'fetch', '_ajax_nonce': cl_settings._fetch},
        success: function (data) {
            if (data.error == '') {
                // no error, fill up lastposts div with items returned
                msg.empty().hide();
                jQuery.each(data.items, function (j, item) {
                    var title = item.title;
                    var link = item.link;
                    var count = '';
                    jQuery('#lastposts').append('<span id="' + item.link + '" class="choosepost ' + item.type + '">' + title + '</span>');
                });
                // setup first link and hidden fields
                jQuery('#mylastpost').html('<a target="_blank" title="Click to visit this page (new window)" href="' + data.items[0].link + '"> ' + data.items[0]['title'] + '</a>').fadeIn(1000);
                jQuery('#cl_post_title').val(data.items[0].title);
                jQuery('#cl_post_url').val(data.items[0].link);
                jQuery('#cl_prem').val(data.items[0].p);
                // setup look and show dropdown
                jQuery('span.message').css({'backgroundColor': '#efefef', 'color': 'black'});
                jQuery('#showmorespan img').show();
                if (cl_settings['comObj'].width() > jQuery('#commentluv').width()) {
                    var dropdownwidth = jQuery('#commentluv').width();
                } else {
                    var dropdownwidth = jQuery(cl_settings['comObj']).width();
                }
                jQuery('#lastposts').css('width', dropdownwidth).slideDown('', function () {
                    cl_settings['lastposts'] = 'showing'
                });
                // bind click action
                jQuery('.choosepost:not(.message)').click(function () {
                    jQuery('#cl_post_title').val(jQuery(this).text());
                    jQuery('#cl_post_url').val(jQuery(this).attr('id'));
                    jQuery('#mylastpost').html('<a href="' + jQuery(this).attr('id') + '"> ' + jQuery(this).text() + '</a>').fadeIn(1000);
                });
            } else {
                if (typeof(data.rawfile) == 'undefined') {
                    data.rawfile = 'no raw data sent back';
                }
                cl_message(data.error, data.rawfile);
            }
        },
        error: function (x, e) {
            msg.find('img').remove();

            if (x.status == 0) {
                if (cl_settings['api_url'].indexOf('https') == 0) {
                    cl_message('This blog has set the api url to use https, the commentluv technical settings need to be changed for the API url to use http');
                } else {
                    cl_message('It appears that you are offline or another error occured contacting the API url, have you set it to use www or missed the www off the api url?? check the technical settings and add or remove www from the api url.');
                }

            } else if (x.status == 404) {
                cl_message('API URL not found.');
            } else if (x.status == 500) {
                cl_message('Internal Server Error.' + x.responseText);
            } else if (e == 'parsererror') {
                cl_message('Error.\nParsing JSON Request failed.' + x.responseText);
            } else if (e == 'timeout') {
                cl_message('Request Time out.');
            } else {
                cl_message('Unknown Error. ' + x.statusText + ' ' + x.responseText);
            }
        }
    });

    // save what url used and that we checked already
    cl_settings['fired'] = 'yes';
    cl_settings['url_value'] = url.val();

}

/**
 * adds a message to tell the user something in the cl_message div and then slides it down
 * @param string message - the message to show
 */
function cl_message(message, rawfile) {
    jQuery('#cl_messages').empty().hide().html(message).slideDown();
    if (typeof(rawfile) != 'undefined') {
        jQuery('#cl_messages').append('<div class="rawfilewrap"><p>Hover your mouse here to see the data that CommentLuv got back from your site..<br />If you see a warning or other error message then that might help you locate the problem (maybe another plugin is spitting out an error?)</p><div class="rawfile"><pre>' + rawfile + '</pre></div></div>');
    }
}

function heart_big(e) {
    // get url and data from link
    linkspan = jQuery(this).parents(".cluv");
    var link = jQuery(linkspan).find("a:first").attr("href");
    var linkdata = jQuery('img', this).attr('class').split(' ');

    // prepare call to admin
    var data = {
        'action': 'cl_ajax',
        'cid': linkdata[2],
        'cl_prem': linkdata[1],
        'link': link,
        'do': 'info',
        '_ajax_nonce': cl_settings._info
    };
    cl_prem = linkdata[1];
    // set up position
    var position = jQuery(this).offset();
    var windowwidth = jQuery(window).width();
    windowheight = jQuery(window).height();
    var xpos = position.left;
    ypos = position.top;
    if (xpos + 350 > windowwidth) {
        xpos = windowwidth - 370;
        if (xpos < 0) xpos = 0;
    }

    // setup panel and show with loading background image
    jQuery('#heart_tip_big').empty().css({'left': xpos + "px", 'top': ypos + "px"});
    jQuery('#heart_tip_big').css("width", "350px");
    jQuery('#heart_tip_big').addClass("finalbig").show().addClass('cl_ajax');
    // has this been shown before on this page?
    if (typeof cl_settings[linkdata[2]] != 'undefined') {
        fill_panel(cl_settings[linkdata[2]]);
        return;
    }
    // execute call to admin
    cl_try_ajax({
        type: 'post',
        data: data,
        dataType: 'json',
        success: function (data) {
            if (typeof(data) == 'object' && jQuery('#heart_tip_big').is(':visible')) {
                // acceptable response, populate panel
                cl_settings[linkdata[2]] = data.panel;
                fill_panel(data.panel);
            } else {
                jQuery('#heart_tip_big').removeClass('cl_ajax').html(cl_settings['no_info_message']);
            }
            jQuery('#heart_tip_big').mouseleave(heart_small);
        }
    });
}

function fill_panel(html) {
    jQuery('#heart_tip_big').removeClass('cl_ajax').html(html).show();
    if (cl_prem == 'p') {
        jQuery('#heart_tip_big p.cl_title').css('backgroundColor', cl_settings['infoback']);
    }
    // move panel if it extends below window
    var ely = ypos - jQuery(document).scrollTop();
    var poph = jQuery('#heart_tip_big').height() + 20;
    if (ely + poph > windowheight) {
        var invis = poph - (windowheight - ely);
        ypos -= invis;
        if (ypos < 0) ypos = 0;
        jQuery('#heart_tip_big').css('top', ypos);
    }
    return;
}

function heart_small() {
    if (!jQuery('body').find('.cl_ajax').is(':visible')) {
        jQuery("body").find("#heart_tip_big").empty().hide();
    }

}

function do_nowt() {
    return;
}
