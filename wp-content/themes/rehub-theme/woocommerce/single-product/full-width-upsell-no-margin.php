<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;
?>
<?php
    $upsells = $product->get_upsell_ids();

    if ( sizeof( $upsells ) === 0 ) {                                
    }
    else{
        echo '<div class="upsells-woo-area flowhidden" id="upsell-section-woo-area">';
        $upsells = implode(',',$upsells);
        echo '<h3>'.__( 'You may also like&hellip;', 'rehub-theme' ).'</h3>';
        $upsells_array = array('ids'=>$upsells, 'columns'=>'5_col', 'data_source'=>'ids', 'show'=> 5);
        if(rehub_option('width_layout') =='extended'){
            $upsells_array['columns'] = '6_col';
            $upsells_array['show'] = 6;
        }        
        if (rehub_option('woo_design') == 'grid') { 
            echo wpsm_woogrid_shortcode($upsells_array);                  
        }
        elseif (rehub_option('woo_design') == 'gridtwo') { 
            $upsells_array['gridtype'] = 'compact';
            echo wpsm_woogrid_shortcode($upsells_array);                  
        } 
        elseif (rehub_option('woo_design') == 'gridrev') { 
            $related_array['gridtype'] = 'review';
            echo wpsm_woogrid_shortcode($related_array);                  
        }                 
        else{
            echo wpsm_woocolumns_shortcode($upsells_array);           
        } 
        echo '</div>';                               
    }
?>