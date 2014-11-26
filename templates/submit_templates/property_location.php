<?php
global $property_address;
global $country_selected;
global $property_state;
global $property_zip;
global $property_county;
global $property_latitude;
global $property_longitude;
global $google_view_check;
global $google_camera_angle;
global $property_area;
global $property_city;
?>


<div class="submit_container">
<div class="submit_container_header"><?php _e('Listing Location','wpestate');?></div>

    <p class="full_form">
        <label for="property_address"><?php _e('*Address (mandatory) ','wpestate');?></label>
        <textarea type="text" id="property_address" class="form-control" size="40" name="property_address" rows="3" cols="42"><?php print $property_address; ?></textarea>
    </p>

    <p class="half_form">
        <label for="property_country"><?php _e('Country ','wpestate'); ?></label>
        <?php print wpestate_country_list($country_selected,'select-submit2'); ?>
    </p>

    <p class="half_form half_form_last">
        <label for="property_state"><?php _e('State ','wpestate');?></label>
        <input type="text" id="property_state" class="form-control" size="40" name="property_state" value="<?php print $property_state;?>">
    </p>


        <div class="advanced_city_div half_form">
        <label for="property_city"><?php _e('City','wpestate');?></label>

            <?php 
                $args = array(
                    'hide_empty'    => false  
                ); 

                $select_city='';
                $taxonomy = 'property_city';
                $tax_terms = get_terms($taxonomy,$args);

                $selected_option='';
                $selected= get_term_by('id', $property_city, $taxonomy);
                if($selected!=''){
                print 'selected option '.    $selected_option=$selected->name;
                } 

                foreach ($tax_terms as $tax_term) {
                   $select_city.= '<option value="' . $tax_term->name . '"';
                    if($property_city==$tax_term->name ){
                              $select_city.= ' selected="selected" ';
                        }
                   $select_city.=  ' >' . $tax_term->name . '</option>';
                }
            ?>

            <select id="property_city_submit" name="property_city" class="cd-select" >
                <option value="none"><?php _e('None','wpestate'); ?></option>
                 <option value="all"><?php _e('All Cities','wpestate'); ?></option>
                <?php echo $select_city ;?>
            </select>
        </div>


        <div class="advanced_area_div half_form half_form_last">
        <label for="property_area"><?php _e('Area / Neighborhood','wpestate');?></label>

        <?php 

            $select_area='';
            $taxonomy = 'property_area';
            $tax_terms = get_terms($taxonomy,$args);

            $selected_option='';
            $selected= get_term_by('id', $property_area, $taxonomy);
             if($selected!=''){
                $selected_option=$selected->name;
            } 
           // print($selected->name);
            foreach ($tax_terms as $tax_term) {
                $term_meta=  get_option( "taxonomy_$tax_term->term_id");
                $select_area.= '<option value="' . $tax_term->name . '" data-parentcity="' . $term_meta['cityparent'] . '"';
                    if($property_area==$tax_term->name ){
                          $select_area.= ' selected="selected" ';
                    }
                $select_area.= '>' . $tax_term->name . '</option>';
            }

          ?>
         <select id="property_area_submit" name="property_area"  class="cd-select">
            <option data-parentcity="none" value="none"><?php _e('None','wpestate'); ?></option>
            <option data-parentcity="all" value="all"><?php _e('All Areas','wpestate'); ?></option>
            <?php echo $select_area; ?>
         </select>
        
        <select id="property_area_submit_hidden" name="property_area_hidden"  class="cd-select">
            <option data-parentcity="none" value="none"><?php _e('None','wpestate'); ?></option>
            <option data-parentcity="all" value="all"><?php _e('All Areas','wpestate'); ?></option>
            <?php echo $select_area; ?>
         </select>
    </div> 


    <p class="half_form">
        <label for="property_zip"><?php _e('Zip ','wpestate');?></label>
        <input type="text" id="property_zip" class="form-control" size="40" name="property_zip" value="<?php print $property_zip;?>">
    </p>

    <p class="half_form half_form_last">
        <label for="property_county"><?php _e('County ','wpestate');?></label>
        <input type="text" id="property_county" class="form-control"  size="40" name="property_county" value="<?php print $property_county;?>">
    </p>

    <p class="full_form" style="float:left;">
        <button id="google_capture"  class="wpb_button  wpb_btn-success wpb_btn-large vc_button"><?php _e('Place Pin with Property Address','wpestate');?></button>
    </p>

    <p class="full_form">
        <div id="googleMapsubmit" ></div>   
    </p>  

    <p class="half_form">            
         <label for="property_latitude"><?php _e('Latitude (for Google Maps)','wpestate'); ?></label>
         <input type="text" id="property_latitude" class="form-control" style="margin-right:20px;" size="40" name="property_latitude" value="<?php print $property_latitude; ?>">
    </p>

    <p class="half_form half_form_last">    
         <label for="property_longitude"><?php _e('Longitude (for Google Maps)','wpestate');?></label>
         <input type="text" id="property_longitude" class="form-control" style="margin-right:20px;" size="40" name="property_longitude" value="<?php print $property_longitude;?>">
    </p>

    <p class="half_form">
        <label for="property_google_view"><?php _e('Enable Google Street View','wpestate');?></label>
        <input type="hidden"    name="property_google_view" value="">
        <input type="checkbox"  id="property_google_view"  name="property_google_view" value="1" <?php print $google_view_check;?> >                           
    </p></br>

    <p class="half_form half_form_last">
        <label for="google_camera_angle"><?php _e('Google Street View - Camera Angle (value from 0 to 360)','wpestate');?></label>
        <input type="text" id="google_camera_angle" class="form-control" style="margin-right:0px;" size="5" name="google_camera_angle" value="<?php print $google_camera_angle;?>">
    </p>

</div> 
