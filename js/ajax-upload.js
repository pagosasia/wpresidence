 ///////////////////////////////////////////////////////////////////////////////////////////  
  ////////  profile uploader
  ////////////////////////////////////////////////////////////////////////////////////////////   
  jQuery(document).ready(function($) {
     "use strict";
  
      if (typeof(plupload) !== 'undefined') {
            var uploader = new plupload.Uploader(ajax_vars.plupload);
            uploader.init();
            uploader.bind('FilesAdded', function (up, files) {
                
                $.each(files, function (i, file) {
                    
                    $('#aaiu-upload-imagelist').append(
                        '<div id="' + file.id + '">' +
                        file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                        '</div>');
                });

                up.refresh(); // Reposition Flash/Silverlight
                uploader.start();
            });

            uploader.bind('UploadProgress', function (up, file) {
                $('#' + file.id + " b").html(file.percent + "%");
            });

            // On erro occur
            uploader.bind('Error', function (up, err) {
                $('#aaiu-upload-imagelist').append("<div>Error: " + err.code +
                    ", Message: " + err.message +
                    (err.file ? ", File: " + err.file.name : "") +
                    "</div>"
                );
                up.refresh(); // Reposition Flash/Silverlight
            });



            uploader.bind('FileUploaded', function (up, file, response) {
              
                var result = $.parseJSON(response.response);
            
             
                $('#' + file.id).remove();
                if (result.success) {               
                   
                    $('#profile-image').attr('src',result.html);
                    $('#profile-image').attr('data-profileurl',result.html);
                    $('#profile-image').attr('data-smallprofileurl',result.attach);
                    
                    var all_id=$('#attachid').val();
                    all_id=all_id+","+result.attach;
                    $('#attachid').val(all_id);
                    $('#imagelist').append('<div class="uploaded_images" data-imageid="'+result.attach+'"><img src="'+result.html+'" alt="thumb" /><i class="fa deleter fa-trash-o"></i> </div>');
                    delete_binder();
                    thumb_setter();
                }
            });

     
            $('#aaiu-uploader').click(function (e) {
                      uploader.start();
                      e.preventDefault();
                  });
            
            $('#aaiu-uploader2').click(function (e) {
                      uploader.start();
                      e.preventDefault();
                  });
                     
 }
 
 });
 function thumb_setter(){
  
    jQuery('#imagelist img').click(function(){
    
        jQuery('#imagelist .uploaded_images .thumber').each(function(){
            jQuery(this).remove();
        });

        jQuery(this).parent().append('<i class="fa thumber fa-star"></i>')
        jQuery('#attachthumb').val(   jQuery(this).parent().attr('data-imageid') );
    });   
 }
 
 
 
 function delete_binder(){
      jQuery('#imagelist i').click(function(){
          var curent='';  
          jQuery(this).parent().remove();
          
          jQuery('#imagelist .uploaded_images').each(function(){
             curent=curent+','+jQuery(this).attr('data-imageid'); 
          });
          jQuery('#attachid').val(curent); 
          
      });
           
 }