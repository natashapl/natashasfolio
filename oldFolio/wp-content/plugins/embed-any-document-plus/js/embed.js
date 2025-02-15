jQuery(document).ready(function($) {
    var $popup = $('#embed-popup'),
        $wrap = $('#embed-popup-wrap'),
        $embedurl = $('#awsm_url'),
        $shortcode = $('#shortcode'),
        $message = $('#embed_message p'),
        $ActionPanel = $('.mceActionPanel'),
        $container = $('.ead_container'),
        fileurl = "",
        newprovider = "",
        driveapiKey = emebeder.driveapiKey,
        driveclientId = emebeder.driveclientId,
        boxapikey = emebeder.boxapikey,
        DropboxApi = emebeder.DropboxApi,
        msextension = emebeder.msextension,
        drextension = emebeder.drextension;

    //Reset form data
    function ead_reset() {
        $container.show();
        $embedurl.val('');
        $('.ead-options').fadeIn();
        $('.addurl_box').hide();
        $('.upload-success').hide();
        $('#embed_message').hide();
        $('#insert_doc').attr('disabled', 'disabled');
        $('#new_provider').show();
        $('#ead_pseudo').hide();
        newprovider = "";
        $("#new_provider  option[value='microsoft']").attr('disabled', false);
        $('#ead_downloadc').show();
    }

    //Opens Embed popup
    $('body').on('click', '.awsm-embed', function(e) {
        ead_reset();
        e.preventDefault();
        $wrap.show();
        window.embed_target = $(this).data('target');
        $(this).magnificPopup({
            type: 'inline',
            alignTop: false,
            callbacks: {
                open: function() {
                    // Change z-index
                    $('body').addClass('mfp-shown ead-popon');
                    // Save selection
                    mce_selection = (typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor !== null && tinyMCE.activeEditor.hasOwnProperty('selection')) ? tinyMCE.activeEditor.selection.getContent({
                        format: "text"
                    }) : '';
                },
                close: function() {
                    // Remove narrow class
                    $popup.removeClass('generator-narrow');
                    // Clear selection
                    mce_selection = '';
                    // Change z-index
                    $('body').removeClass('mfp-shown ead-popon');
                }
            }
        }).magnificPopup('open');
    });

    //sanitize width and height
    function sanitize(dim) {
            if (dim.indexOf("%") == -1) {
                dim = dim.replace(/[^0-9]/g, '');
                dim += "px";
            } else {
                dim = dim.replace(/[^0-9]/g, '');
                dim += "%";
            }

            return dim;
        }
        //Update shortcode on change
    $(".ead_usc").change(function() {
        newprovider = "";
        updateshortcode($(this).attr('id'));
    });
    $('.embedval').keyup(function() {
        updateshortcode($(this).attr('id'));
    });

    //Wordpress Uploader
    $('#upload_doc').click(open_media_window);

    //Insert Media window
    function open_media_window() {
        var uClass = 'upload';
        if (this.window === undefined) {
            this.window = wp.media({
                title: 'Embed Any Documet',
                multiple: false,
                library: {
                    type: emebeder.validtypes,
                },
                button: {
                    text: 'Insert'
                }
            });

            var self = this; // Needed to retrieve our variable in the anonymous function below
            this.window.on('select', function() {
                var file = self.window.state().get('selection').first().toJSON();
                updateprovider(file, uClass);
            });
        }
        this.window.open();
        return false;
    }

    //update provider
    function updateprovider(file, uClass) {
        fileurl = file.url;
        validViewer(file, uClass);
        updateshortcode();
        uploaddetails(file, uClass);
    }

    //to getshortcode
    function getshortcode(url, item) {
        var height = sanitize($('#ead_height').val()),
            width = sanitize($('#ead_width').val()),
            download = $('#ead_download').val(),
            provider = $('#ead_provider').val(),
            heightstr = "",
            widthstr = "",
            downloadstr = "",
            providerstr = "",
            drivestr = "";
        if (itemcheck('height', item)) {
            heightstr = ' height="' + height + '"';
        }
        if (itemcheck('width', item)) {
            widthstr = ' width="' + width + '"';
        }
        if (itemcheck('download', item)) {
            downloadstr = ' download="' + download + '"';
        }
        if (itemcheck('provider', item)) {
            providerstr = ' viewer="' + provider + '"';
        }
        if (newprovider) {
            providerstr = ' viewer="' + newprovider + '"';
        }
        return '[embeddoc url="' + url + '"' + widthstr + heightstr + downloadstr + providerstr + drivestr + ']';

    }

    // Checks with default setting value
    function itemcheck(item, dataitem) {
        var check = $('#ead_' + item).val();
        var datacheck = 'ead_' + item;
        if (datacheck == dataitem) {
            return true;
        } else if (check != emebeder[item]) {
            return true;
        }
        return false;
    }

    //Print uploaded file details
    function uploaddetails(file, uClass) {
        $('#insert_doc').removeAttr('disabled');
        $('#ead_filename').html(file.filename);
        if (file.filesizeHumanReadable) {
            $('#ead_filesize').html(file.filesizeHumanReadable);
        } else {
            $('#ead_filesize').html('&nbsp;');
        }
        $('.upload-success').fadeIn();
        $container.hide();
        UploadClass(uClass);
    }

    //Add url
    $('#add_url').click(awsm_embded_url);

    function awsm_embded_url() {
        var checkurl = $embedurl.val();
        if (checkurl !== '') {
            validateurl(checkurl);
        } else {
            $embedurl.addClass('urlerror');
            updateshortcode();
        }

    }

    //Validate file url
    function validateurl(url) {
        var uClass = 'link';
        $('#embed_message').hide();
        $('#add_url').val(emebeder.verify);
        $.ajax({
            type: 'POST',
            url: emebeder.ajaxurl,
            dataType: 'json',
            data: {
                action: 'validateurl',
                furl: url
            },
            success: function(data) {
                if (data.status) {
                    $embedurl.removeClass('urlerror');
                    updateprovider(data.file, uClass);
                } else {
                    showmsg(data.message);
                }
                $('#add_url').val(emebeder.addurl);
            },
        });
    }

    //Show Message
    function showmsg(msg) {
        $('#embed_message').fadeIn();
        $message.text(msg);
    }

    //insert Shortcode
    $('#insert_doc').click(awsm_shortcode);

    function awsm_shortcode() {
        if (fileurl) {
            wp.media.editor.insert($shortcode.text());
            $.magnificPopup.close();
        } else {
            showmsg(emebeder.nocontent);
        }
    }

    // Add from URL support
    $('#addDocUrl').on('click', function(e) {
        e.preventDefault();
        $('.addurl_box').fadeIn();
        $('.ead-options').hide();
    });

    //Add fromrom URL cancel handler
    $('.go-back').on('click', function(e) {
        e.preventDefault();
        $('.addurl_box').hide();
        $('.ead-options').fadeIn();
    });

    //Update ShortCode
    function updateshortcode(item) {
        item = typeof item !== 'undefined' ? item : false;
        if (fileurl) {
            $shortcode.text(getshortcode(fileurl, item));
        } else {
            $shortcode.text('');
        }
    }

    // Close embed dialog
    $('#embed-popup').on('click', '.cancel_embed', function(e) {
        // Close popup
        $.magnificPopup.close();
        // Prevent default action
        e.preventDefault();
    });

    //UploadClass
    function UploadClass(uPclass) {
        $(".uploaded-doccument").removeClass("ead-link ead-upload ead-dropbox ead-drive ead-box");
        $('.uploaded-doccument').addClass('ead-' + uPclass);
    }

    //Convert Filesize to human Readable filesize
    function humanFileSize(bytes) {
        var thresh = 1024;
        if (bytes < thresh) return bytes + ' B';
        var units = ['KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        var u = -1;
        do {
            bytes /= thresh;
            ++u;
        } while (bytes >= thresh);
        return bytes.toFixed(1) + ' ' + units[u];
    }

    // Dropbox Integration
    $('#DropBoxUpload').on('click', function(e) {
        if (ApiHandling(DropboxApi, 'No Api key')) return;
        var uClass = 'dropbox';
        var validext = drextension.split(',');
        Dropbox.init({
            appKey: DropboxApi
        });
        Dropbox.choose({
            linkType: "preview",
            multiselect: false, // or true
            extensions: validext,
            success: function(files) {
                var drpbox = files[0];
                var dropURL = drpbox.link.replace("dl=0", "dl=1");
                var file = {
                    url: dropURL,
                    filename: drpbox.name,
                    filesizeHumanReadable: humanFileSize(drpbox.bytes)
                };
                updateprovider(file, uClass);
            }
        });
    });

    // Google Integration
    $('#GooglePicker').on('click', function(e) {
        if (ApiHandling(driveclientId, 'No Api key')) return;
        e.preventDefault();
        onApiLoad();
    });
    var oauthToken;

    function onApiLoad() {
        if (!oauthToken) {
            gapi.load('auth', {
                'callback': onAuthApiLoad
            });
            gapi.load('picker', 1);
        } else {
            createPicker();
        }
    }

    function onAuthApiLoad() {
        window.gapi.auth.authorize({
            'client_id': driveclientId,
            'scope': ['https://www.googleapis.com/auth/drive']
        }, handleAuthResult);
    }

    function handleAuthResult(authResult) {
        if (authResult && !authResult.error) {
            oauthToken = authResult.access_token;
            createPicker();
        }
    }

    function createPicker() {
        var picker = new google.picker.PickerBuilder()
            .addView(google.picker.ViewId.FOLDERS)
            .setOAuthToken(oauthToken)
            .setDeveloperKey(driveapiKey)
            .setCallback(pickerCallback)
            .build();
        picker.setVisible(true);
    }

    function pickerCallback(data) {
            var url = 'nothing';
            var uClass = 'drive';
            if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
                var doc = data[google.picker.Response.DOCUMENTS][0];
                var filesize = 0;
                if (doc.sizeBytes) {
                    filesize = humanFileSize(doc.sizeBytes);
                }
                var file = {
                    url: doc.embedUrl,
                    filename: doc.name,
                    filesizeHumanReadable: filesize
                };
                newprovider = "drive";
                updateprovider(file, uClass);
                validateDriveUrl(doc.embedUrl);
                ead_SetPseudo('drive');
            }
        }
        // Set Pseudo Viewer
    function ead_SetPseudo(Viewer) {
            $('#new_provider').hide();
            $('#ead_pseudo').show();
            $('#ead_downloadc').hide();
            $('select[name="ead_pseudo"]').val(Viewer);
        }
        //Validate file url
    function validateDriveUrl(url) {
            $('#insert_doc').val($('#insert_doc').data('loading')).attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: emebeder.ajaxurl,
                dataType: 'json',
                data: {
                    action: 'validateDriveUrl',
                    furl: url
                },
                success: function(data) {
                    if (!data.status) {
                        showmsg(data.message);
                    }
                    $('#insert_doc').val($('#insert_doc').data('txt')).removeAttr('disabled');
                },
            });

        }
        // Box Integration
    $('#boxPicker').on('click', function(e) {
        if (ApiHandling(boxapikey, 'No Api key')) return;
        var boxoptions = {
            clientId: boxapikey,
            linkType: 'shared',
            multiselect: false
        };
        var boxSelect = new BoxSelect(boxoptions);
        boxSelect.launchPopup();
        boxSelect.success(function(response) {
            var uClass = 'box';
            var doc = response[0];
            var filesize = 0;
            var file = {
                url: doc.url,
                filename: doc.name,
                filesizeHumanReadable: filesize
            };
            ead_SetPseudo('box');
            if (doc.access !== 'open') {
                showmsg(emebeder.nopublic);
            }
            newprovider = "box";
            updateprovider(file, uClass);
        });
    });
    // Viewer Check
    function validViewer(file, provider) {
            var cprovider = ["link", "upload", "dropbox"];
            var validext = msextension.split(',');
            var ext = '.' + file.filename.split('.').pop();
            $("#new_provider  option[value='microsoft']").attr('disabled', false);
            if ($.inArray(provider, cprovider) != -1) {
                if ($.inArray(ext, validext) == -1) {
                    newprovider = "google";
                    $("#new_provider option[value='google']").attr("selected", "selected");
                    $("#new_provider  option[value='microsoft']").attr('disabled', true);
                } else {
                    newprovider = "microsoft";
                    $("#new_provider option[value='microsoft']").attr("selected", "selected");
                }
            }
        }
        //Apikey Handling
    function ApiHandling(key, message) {
        if (!key) {
            showmsg(message);
            return true;
        } else {
            return false;
        }

    }
});