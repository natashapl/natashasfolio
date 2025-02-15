// removeluv link click action
jQuery(document).ready(function ($) {
    $('a.removeluv').click(function () {
        var data = {
            action: 'removeluv'
        };
        var vars = $(this).attr('class').split(':');
        data.cid = vars[1];
        data._wpnonce = vars[2];
        jQuery.post(ajaxurl, data, function (response) {
            var stuff = response.split('*');
            var cid = stuff[0];
            var statuscode = stuff[1];
            if (statuscode == '200') {
                var msg = 'Luv removed';
            } else {
                var msg = 'had a booboo :(';
            }

            $('#comment-' + cid + ' td.comment .cluv').text(msg).fadeOut("slow").fadeIn("slow").fadeOut();
            $('#comment-' + cid + ' span.Remove-luv').text('');

        });

        return false;
    });
});