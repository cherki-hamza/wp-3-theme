<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user = dokan()->vendor->get( get_query_var( 'author' ) );
$vendor_id = $store_user->get_id();
$store_info   = $store_user->get_shop_info();
$map_location = $store_user->get_location();
$totaldeals = count_user_posts( $vendor_id, $post_type = 'product' );
$store_url = dokan_get_store_url( $vendor_id );
$social_fields = dokan_get_social_profile_fields();
$store_description = '';
$tnc_enable = dokan_get_option( 'seller_enable_terms_and_conditions', 'dokan_general', 'off' );
if ( isset($store_info['enable_tnc']) && $store_info['enable_tnc'] == 'on' && $tnc_enable == 'on' ) {
	$store_description = wpautop( wptexturize( wp_kses_post( $store_info['store_tnc'] ) ) );
}

$store_address_arr = $store_info['address'];
$store_address = '';
if( is_array( $store_address_arr ) && !empty( $store_address_arr ) ) {
	if( !empty($store_address_arr['street_1'] )) $store_address = $store_address_arr['street_1'];
	if( !empty($store_address_arr['street_2'] )) $store_address .= ', '. $store_address_arr['street_2'];
	if( !empty($store_address_arr['city'] )) $store_address .= ', '. $store_address_arr['city'];
	if( !empty($store_address_arr['state'] )) $store_address .= ', '. $store_address_arr['state'];
	if( !empty($store_address_arr['zip'] )) $store_address .= ' '. $store_address_arr['zip'];
	if( !empty($store_address_arr['country'] )) $store_address .= ', '. $store_address_arr['country'];
}
if(function_exists('mycred_get_users_rank')){
	if(rehub_option('rh_mycred_custom_points')){
		$custompoint = rehub_option('rh_mycred_custom_points');
		$mycredrank = mycred_get_users_rank($vendor_id, $custompoint );
	}
	else{
		$mycredrank = mycred_get_users_rank($vendor_id);		
	}
}
if(function_exists('mycred_render_shortcode_my_balance')){
    if(rehub_option('rh_mycred_custom_points')){
        $custompoint = rehub_option('rh_mycred_custom_points');
        $mycredpoint = mycred_render_shortcode_my_balance(array('type'=>$custompoint, 'user_id'=>$vendor_id, 'wrapper'=>'', 'balance_el' => '') );
        $mycredlabel = mycred_get_point_type_name($custompoint, false);
    }
    else{
        $mycredpoint = mycred_render_shortcode_my_balance(array('user_id'=>$vendor_id, 'wrapper'=>'', 'balance_el' => '') );
        $mycredlabel = mycred_get_point_type_name('', false);           
    }
}
$count_likes = ( get_user_meta( $vendor_id, 'overall_post_likes', true) ) ? get_user_meta( $vendor_id, 'overall_post_likes', true) : 0;
$count_wishes = ( get_user_meta( $vendor_id, 'overall_post_wishes', true) ) ? get_user_meta( $vendor_id, 'overall_post_wishes', true) : 0;
$count_p_votes = (int)$count_likes + (int)$count_wishes; 
$widget_args = array( 'before_widget' => '<div class="rh-cartbox widget"><div>', 'after_widget'  => '</div></div>', 'before_title'  => '<div class="widget-inner-title rehub-main-font">', 'after_title' => '</div>' );
?>

<?php get_header(); ?>
<?php dokan_get_template_part( 'store-header' ); ?>

<!-- CONTENT -->
<div class="rh-container wcvcontent woocommerce"> 
    <div class="rh-content-wrap clearfix">
    	<?php do_action( 'dokan_store_profile_frame_after', $store_user->data, $store_info ); ?>
	    <div class="rh-mini-sidebar-content-area floatright page clearfix tabletblockdisplay">
	        <article class="post" id="page-<?php the_ID(); ?>">
	        	<?php do_action( 'woocommerce_before_main_content' ); ?>
	        	<div role="tabvendor" class="tab-pane active" id="vendor-items">
				<?php if ( have_posts() ) : ?>
					<div class="seller-items">
						<?php do_action( 'woocommerce_before_shop_loop' ); ?>
						
						<?php 
							$classes = array();  
						?>
						<?php 
							if(rehub_option('width_layout') == 'extended'){
								$classes[] = 'col_wrap_fourth';
							}
							else{
								$classes[] = 'col_wrap_three';
							}
						?>					
						<?php 
						if (rehub_option('woo_design') == 'grid') {
							$classes[] = 'rh-flex-eq-height grid_woo';
						}
						elseif (rehub_option('woo_design') == 'list' || rehub_option('woo_design') == 'deallist') {
							$classes[] = 'list_woo';
						}
						elseif (rehub_option('woo_design') == 'gridrev') {
							$classes[] = 'rh-flex-eq-height woogridrev';
						}						
						elseif (rehub_option('woo_design') == 'gridtwo'){
						    $classes[] = 'eq_grid post_eq_grid rh-flex-eq-height';
						}					
						else {
							$classes[] = 'rh-flex-eq-height column_woo';
						}
						if (rehub_option('woo_design') == 'deallist') {
							$classes[] = 'woo_offer_list';
						}
						?>					
						<div class="products <?php echo implode(' ',$classes);?>">
							<?php while ( have_posts() ) : the_post(); ?>
								<?php 
									if(rehub_option('width_layout') == 'extended'){
										$columns = '4_col';
									}
									else{
										$columns = '3_col';
									}
								?>							
								<?php if (rehub_option('woo_design') == 'list'){
								    include(rh_locate_template('inc/parts/woolistmain.php'));
								}
								elseif (rehub_option('woo_design') == 'grid'){
								    include(rh_locate_template('inc/parts/woogridpart.php'));
								}
								elseif (rehub_option('woo_design') == 'deallist'){
								    include(rh_locate_template('inc/parts/woolistpart.php'));
								}
								elseif (rehub_option('woo_design') == 'gridrev'){
    								include(rh_locate_template('inc/parts/woogridrev.php'));
								}								
								elseif (rehub_option('woo_design') == 'gridtwo'){
								    include(rh_locate_template('inc/parts/woogridcompact.php'));
								}							
								else{
									$custom_col = 'yes'; 
									$custom_img_height = 284; 
									$custom_img_width = 284; 								
								    include(rh_locate_template('inc/parts/woocolumnpart.php'));
								} ?>
							<?php endwhile; // end of the loop. ?>
						</div>

						<?php dokan_content_nav( 'nav-below' ); ?>
						
						<?php do_action( 'woocommerce_after_shop_loop' ); ?>
					</div>
				
				<?php else : ?>
						<?php wc_get_template( 'loop/no-products-found.php' ); ?>
				<?php endif; ?>
				</div>
				<?php if( !empty( $store_description ) ) { ?>
				<div role="tabvendor" class="tab-pane" id="vendor-about">
					<div class="rh-cartbox widget">
						<div>
							<div class="widget-inner-title rehub-main-font"><?php esc_html_e( 'Terms and Conditions', 'rehub-theme' );?></div>
							<?php echo wp_kses_post($store_description); ?>
						</div>
					</div>
				</div>
				<?php } ?>
				
				<?php do_action( 'woocommerce_after_main_content' ); ?>				
			</article>
		</div>    	
	    <!-- Sidebar -->
	    <aside class="rh-mini-sidebar user-profile-div floatleft tabletblockdisplay">	    
			<div class="rh-cartbox widget">
				<div>
					<div class="widget-inner-title rehub-main-font">
						<?php if ( function_exists('bp_displayed_user_avatar') ) : ?>
							<?php esc_html_e('Shop owner:', 'rehub-theme');?>
						<?php else : ?>
							<?php esc_html_e('Store details', 'rehub-theme');?>
						<?php endif; ?>							
					</div>
					
					<?php if ( function_exists('bp_displayed_user_avatar') ) : ?>
						<div class="profile-avatar text-center">
							<?php bp_displayed_user_avatar( 'type=full&width=110&height=110&&item_id='.$vendor_id ); ?>
							<div class="profile-usertitle-name mt20">
								<a href="<?php echo bp_core_get_user_domain( $vendor_id ); ?>"><?php the_author_meta( 'nickname',$vendor_id); ?>
								</a>
							</div>
						</div>
					<?php endif; ?>
					<?php if (!empty($mycredrank) && is_object( $mycredrank)) :?>
						<div class="profile-usertitle text-center mt20">
							<span class="rh-user-rank-mc rh-user-rank-<?php echo (int)$mycredrank->post_id; ?>">
								<?php echo esc_html($mycredrank->title) ;?>
							</span>
						</div>
					<?php endif;?>					
					
					<div class="profile-stats">
						<div><i class="rhicon rhi-heartbeat"></i><?php esc_html_e( 'Product Votes', 'rehub-theme' ); echo ': ' . $count_p_votes; ?></div>
						<div><i class="rhicon rhi-briefcase"></i><?php esc_html_e( 'Total submitted', 'rehub-theme' ); echo ': ' . $totaldeals; ?></div>
	                    <?php if (!empty($mycredpoint)) :?><div><i class="rhicon rhi-chart-bar"></i><?php echo esc_html($mycredlabel);?>: <?php echo ''.$mycredpoint;?> </div><?php endif;?>
					</div>
					<div class="profile-description">
						<div>
							<span><?php esc_html_e( 'Contacts', 'rehub-theme' ); ?></span>
							<p>
							<?php if ( isset( $store_address ) && !empty( $store_address ) ) { ?>
								<i class="rhicon rhi-map-marker-alt"></i> <?php echo ''.$store_address; ?>
							<?php } ?>
							<?php if ( !empty( $store_user->get_phone() ) ) { ?>
								<br />
								<i class="rhicon rhi-mobile"></i> <a href="tel:<?php echo esc_html( $store_user->get_phone() ); ?>"><?php echo esc_html( $store_user->get_phone() ); ?></a>
							<?php } ?>
							<?php if ( $store_user->show_email() == 'yes' ) { ?>
								<br />
								<i class="rhicon rhi-envelope"></i> <a href="mailto:<?php echo antispambot( $store_user->get_email() ); ?>"><?php echo antispambot( $store_user->get_email() ); ?></a>
							<?php } ?>							
							</p>
						</div>
					</div>
					<?php if ( $social_fields ) { ?>
					<div class="profile-socbutton">
						<div class="social_icon small_i">
							<?php foreach( $social_fields as $key => $field ) { ?>
								<?php if ( isset( $store_info['social'][ $key ] ) && !empty( $store_info['social'][ $key ] ) ) { ?>
									<?php $iconcode = $field['icon']; $iconcode = str_replace('-square', '', $iconcode);?>

									  <a href="<?php echo esc_url( $store_info['social'][ $key ] ); ?>" class="author-social <?php echo esc_attr( $key ) ?>" title="<?php echo esc_attr($field['title']); ?>" target="_blank"><i class="rhicon rhi-<?php echo esc_attr($field['icon']); ?>"></i></a>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
					
					<?php if ( !empty( $store_user->description ) ) { ?>
	                <div class="profile-description">
	                    <div>
	                        <span><?php esc_html_e( 'About author', 'rehub-theme' ); ?></span>
	                        <p><?php echo wp_kses_post($store_user->description); ?></p>
	                    </div>
	                </div>
					<?php } ?>
					
					<?php if ( function_exists( 'mycred_get_users_badges' ) ) : ?>
	                <div class="profile-achievements mb15 text-center">
                        <div>
                            <?php rh_mycred_display_users_badges( $vendor_id ) ?>
                        </div>
	                </div>
	            	<?php endif; ?>
                <?php if ( function_exists('bp_core_get_user_domain') ) : ?>
                	<?php if ( bp_is_active( 'xprofile' ) ) : ?>
						<?php if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => true, 'user_id'=>$vendor_id ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
							<?php $numberfields = explode(',', bp_get_the_profile_field_ids());?>
							<?php $count = (!empty($numberfields)) ? count($numberfields) : '';?>
							<?php $bp_profile_description = rehub_option('rh_bp_seo_description');?>
							<?php $bp_profile_phone = rehub_option('rh_bp_phone');	?>

							<?php if ($count > 1) :?>
								<ul id="xprofile-in-wcstore">
									<?php $fieldid = 0; while ( bp_profile_fields() ) : bp_the_profile_field(); $fieldid++; ?>
										<?php if ($fieldid == 1) continue;?>
										<?php $fieldname = bp_get_the_profile_field_name();?>
										<?php if($fieldname == $bp_profile_phone) continue;?>
										<?php if($fieldname == $bp_profile_description) continue;?>
										<?php if ( bp_field_has_data() ) : ?>
											<li>
												<div class="floatleft mr5"><?php echo esc_attr($fieldname) ?>: </div>
												<div class="floatleft"><?php bp_the_profile_field_value() ?></div>	
											</li>
										<?php endif; ?>
									<?php endwhile; ?>
								</ul>
							<?php endif; ?>
						<?php endwhile; endif; ?>
                	<?php endif;?>
					
                    <div class="profile-usermenu mt20">
	                    <ul class="user-menu-tab" role="tablist">
	                        <li class="text-center">
	                            <a href="<?php echo bp_core_get_user_domain( $vendor_id ); ?>"><i class="rhicon rhi-folder-open"></i><?php esc_html_e( 'Show full profile', 'rehub-theme' ); ?></a>
	                        </li>
	                    </ul>
                    </div>
					<?php endif; ?>
	            </div>	    		
			</div>
			<?php do_action( 'dokan_sidebar_store_before', $store_user->data, $store_info ); ?>
	        <?php if ( is_active_sidebar( 'sidebar-store' ) ) : ?>
	            <?php dynamic_sidebar( 'sidebar-store' ); ?>
	        <?php endif;?>
            <?php
            if ( ! is_active_sidebar( 'sidebar-store' ) ) {
                if ( dokan()->widgets->is_exists( 'store_category_menu' ) ) {
                    the_widget( dokan()->widgets->store_category_menu, array( 'title' => __( 'Store Product Category', 'rehub-theme' ) ), $widget_args );
                }

                if ( dokan()->widgets->is_exists( 'store_location' ) && dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on'  && ! empty( $map_location ) ) {
                    the_widget( dokan()->widgets->store_location, array( 'title' => __( 'Store Location', 'rehub-theme' ) ), $widget_args );
                }

                if ( dokan()->widgets->is_exists( 'store_open_close' ) && dokan_get_option( 'store_open_close', 'dokan_general', 'on' ) == 'on' ) {
                    the_widget( dokan()->widgets->store_open_close, array( 'title' => __( 'Store Time', 'rehub-theme' ) ), $widget_args );
                }

                if ( dokan()->widgets->is_exists( 'store_contact_form' ) && dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
                    the_widget( dokan()->widgets->store_contact_form, array( 'title' => __( 'Contact Vendor', 'rehub-theme' ) ), $widget_args );
                }
            }
            ?>
            <?php do_action( 'dokan_sidebar_store_after', $store_user->data, $store_info ); ?>	
	        <?php if ( is_active_sidebar( 'wcw-storepage-sidebar' ) ) : ?>
	            <?php dynamic_sidebar( 'wcw-storepage-sidebar' ); ?>
	        <?php endif;?> 		                   		
		
		</aside>
		<!-- /Main Side --> 
    </div>
</div>
<!-- /CONTENT -->

<?php get_footer(); ?>