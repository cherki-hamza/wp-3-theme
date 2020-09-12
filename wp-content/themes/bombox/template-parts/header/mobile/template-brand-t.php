<?php
/**
 * The template part for displaying the site mobile navigation "Brand Top" template
 *
 * @package BoomBox_Theme
 * @since   2.0.0
 * @version 2.0.0
 * @var $template_helper Boombox_Header_Template_Helper Header Template Helper
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$template_helper = Boombox_Template::init( 'header' );
$template_options = $template_helper->get_mobile_options();

echo $template_options[ 'before' ]; ?>
	<header class="bb-header header-mobile g-style g-style-top large <?php echo $template_options[ 'class' ]; ?>">

		<div class="container header-row header-row-btm header-c">
			<div class="header-col">
				<?php get_template_part( 'template-parts/header/mobile/branding' ); ?>
			</div>
		</div>

		<?php echo $template_options['components_before']; ?>
		<div class="container header-row header-main <?php echo $template_options[ 'components_class' ]; ?>">
			<div class="header-row-layout">

				<?php if ( ! empty( $template_options[ 'components' ][ 'left' ] ) ) {
					$template_helper->set_component_location( 'left' ); ?>
					<div class="header-col header-l">
						<?php foreach ( $template_options[ 'components' ][ 'left' ] as $component ) {
							$slug = $template_helper->get_composition_item_template_slug( $component );
							if ( $slug ) {
								boombox_get_template_part( $slug );
							} else {
								do_action( 'boombox/mobile/header/render_composition_item/' . $component, 'left' );
							}
						} ?>
					</div>
				<?php } ?>

				<?php if ( ! empty( $template_options[ 'components' ][ 'right' ] ) ) {
					$template_helper->set_component_location( 'right' ); ?>
					<div class="header-col header-r">
						<?php foreach ( $template_options[ 'components' ][ 'right' ] as $component ) {
							$slug = $template_helper->get_composition_item_template_slug( $component );
							if ( $slug ) {
								boombox_get_template_part( $slug );
							} else {
								do_action( 'boombox/mobile/header/render_composition_item/' . $component, 'right' );
							}
						} ?>
					</div>
				<?php } ?>

			</div>
		</div>
		<?php echo $template_options['components_after']; ?>
	</header>
<?php echo $template_options[ 'after' ]; ?>