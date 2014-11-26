/*global $, jQuery, document, window */

jQuery(document).ready(function ($) {
    "use strict";
    ///////////////////////////////////////////////////////////////////////////////
    /// upload custom image on page - jslint checked
    ///////////////////////////////////////////////////////////////////////////////
    var formfield, imgurl;
    $('#page_custom_image_button').click(function () {
        formfield = $('#page_custom_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#page_custom_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
});
