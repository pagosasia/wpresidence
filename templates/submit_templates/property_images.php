<?php
global $action;
global $edit_id;
$images='';
$thumbid='';
$attachid='';

if ($action=='edit'){
    $arguments = array(
          'numberposts' => -1,
          'post_type' => 'attachment',
          'post_mime_type' => 'image',
          'post_parent' => $edit_id,
          'post_status' => null,
          'exclude' => get_post_thumbnail_id(),
          'orderby' => 'menu_order',
          'order' => 'ASC'
      );
    $post_attachments = get_posts($arguments);
    $post_thumbnail_id = $thumbid = get_post_thumbnail_id( $edit_id );
 
   
    foreach ($post_attachments as $attachment) {
        $preview =  wp_get_attachment_image_src($attachment->ID, 'thumbnail');    
        $images .=  '<div class="uploaded_images" data-imageid="'.$attachment->ID.'"><img src="'.$preview[0].'" alt="thumb" /><i class="fa fa-trash-o"></i>';
        if($post_thumbnail_id == $attachment->ID){
            $images .='<i class="fa thumber fa-star"></i>';
        }
        $images .='</div>';
        $attachid.= ','.$attachment->ID;
    }
}

?>
<div class="submit_container">
<div class="submit_container_header"><?php _e('Listing Images','wpestate');?></div>
    <div id="upload-container">                 
        <div id="aaiu-upload-container">                 
            <div id="aaiu-upload-imagelist">
                <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
            </div>

            <div id="imagelist">
            <?php 
                if($images!=''){
                    print $images;
                }
            ?>  
            </div>
          
            <button id="aaiu-uploader"  class="wpb_button  wpb_btn-success wpb_btn-large vc_button"><?php _e('Select Images','wpestate');?></button>
            <input type="hidden" name="attachid" id="attachid" value="<?php echo $attachid;?>">
            <input type="hidden" name="attachthumb" id="attachthumb" value="<?php echo $thumbid;?>">
            <p class="full_form full_form_image"><?php _e('* At least 1 image is required for a valid submission. **Click on the image to select featured. ','wpestate');?></p>
        </div>  
    </div>
</div>  