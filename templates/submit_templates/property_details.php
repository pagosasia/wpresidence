<?php
global $unit;
global $property_size;
global $property_lot_size;
global $property_rooms;
global $property_bedrooms;
global $property_bathrooms;
global $custom_fields_array;
$measure_sys            = esc_html ( get_option('wp_estate_measure_sys','') ); 
?> 


<div class="submit_container">
<div class="submit_container_header"><?php _e('Listing Details','wpestate');?></div>

    <p class="half_form">
        <label for="property_size"> <?php _e('Size in','wpestate');print ' '.$measure_sys.'<sup>2</sup>';?></label>
        <input type="text" id="property_size" size="40" class="form-control"  name="property_size" value="<?php print $property_size;?>">
    </p>

    <p class="half_form half_form_last">
        <label for="property_lot_size"> <?php  _e('Lot Size in','wpestate');print ' '.$measure_sys.'<sup>2</sup>';?> </label>
        <input type="text" id="property_lot_size" size="40" class="form-control"  name="property_lot_size" value="<?php print $property_lot_size;?>">
    </p>

    <p class="half_form ">
        <label for="property_rooms"><?php _e('Rooms','wpestate');?></label>
        <input type="text" id="property_rooms" size="40" class="form-control"  name="property_rooms" value="<?php print $property_rooms;?>">
    </p>

     <p class="half_form half_form_last">
        <label for="property_bedrooms "><?php _e('Bedrooms','wpestate');?></label>
        <input type="text" id="property_bedrooms" size="40" class="form-control"  name="property_bedrooms" value="<?php print $property_bedrooms;?>">
    </p>

    <p class="half_form ">
        <label for="property_bedrooms"><?php _e('Bathrooms','wpestate');?></label>
        <input type="text" id="property_bathrooms" size="40" class="form-control"  name="property_bathrooms" value="<?php print $property_bathrooms;?>">
    </p>

     <!-- Add custom details -->

     <?php
     $custom_fields = get_option( 'wp_estate_custom_fields', true);    

     $i=0;
     if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){
           $name  =   $custom_fields[$i][0];
           $label =   $custom_fields[$i][1];
           $type  =   $custom_fields[$i][2];
           $slug  =   str_replace(' ','_',$name);
           
           $slug         =   wpestate_limit45(sanitize_title( $name ));
           $slug         =   sanitize_key($slug);
            
           $i++;
           
           if (function_exists('icl_translate') ){
                $label     =   icl_translate('wpestate','wp_estate_property_custom_front_'.$label, $label ) ;
            }   

           if($i%2!=0){
                print '<p class="half_form half_form_last">';
           }else{
                print '<p class="half_form">';
           }
           print '<label for="'.$slug.'">'.$label.'</label>';

           if ($type=='long text'){
                print '<textarea type="text" class="form-control"  id="'.$slug.'"  size="0" name="'.$slug.'" rows="3" cols="42">'.$custom_fields_array[$slug].'</textarea>';
           }else{
                print '<input type="text" class="form-control"  id="'.$slug.'" size="40" name="'.$slug.'" value="'.$custom_fields_array[$slug].'">';
           }
           print '</p>';

           if ($type=='date'){
               print '<script type="text/javascript">
                  //<![CDATA[
                  jQuery(document).ready(function(){
                          jQuery("#'.$slug.'").datepicker({
                                  dateFormat : "yy-mm-dd"
                          });
                  });
                  //]]>
                  </script>';
           }

       }
    }

    ?>

</div>  
