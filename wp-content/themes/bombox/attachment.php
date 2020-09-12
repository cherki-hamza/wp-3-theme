<?php
/**
 * The template for displaying attachment
 * @package BoomBox_Theme
 * @since   1.0.0
 * @version 2.5.0
 * @var $template_helper Boombox_Single_Post_Template_Helper Template Helper
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

get_header();

$template_helper = Boombox_Template::init( 'post' );
$template_options = $template_helper->get_options( 'boombox_image768' );

if ( $template_options[ 'featured_strip' ] ) {
	boombox_get_template_part( 'template-parts/featured', 'strip' );
}

boombox_the_advertisement( 'boombox-after-header', array(
	'class' => 'container large bb-after-header',
) );

if ( false && ! $template_options[ 'enable_primary_sidebar' ] && have_posts() ) {
	the_post();
	$boombox_fimage_style = '';
	if ( $template_options[ 'media' ] && boombox_has_post_thumbnail() && boombox_show_multipage_thumbnail() ) {
		$thumbnail_size = 'full';
		$boombox_thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size );
		$boombox_thumbnail_url = ! empty( $boombox_thumbnail_url ) ? $boombox_thumbnail_url[ 0 ] : boombox_get_post_dafault_thumbnail_url( $thumbnail_size );
		$boombox_fimage_style = $boombox_thumbnail_url ? 'style="background-image: url(\'' . esc_url( $boombox_thumbnail_url ) . '\')"' : '';
	} ?>
	<div class="post-featured-image" <?php echo $boombox_fimage_style; ?>>
		<div class="content">
			<!-- entry-header -->
			<header class="entry-header">
				<?php boombox_get_template_part( 'template-parts/single/single', 'header' ); ?>
			</header>
		</div>
	</div>
	<?php
	rewind_posts();
} ?>

	<div class="container main-container">
		<div class="bb-row">
			<div class="bb-col col-content">
				<div class="bb-row">
					<div class="bb-col col-site-main">
						<div class="site-main" role="main">
							<?php
							boombox_the_advertisement( 'boombox-single-before-content', array( 'class' => 'large bb-before-cnt-area' ) );

							if ( have_posts() ) {
								the_post();

								do_action( 'boombox/single/before-main-content' );

								boombox_get_template_part( 'template-parts/single/content' );

								boombox_get_template_part( 'template-parts/single/sortable' );

								if ( $template_options[ 'side_navigation' ] ) {
									boombox_get_template_part( 'template-parts/single/fixed', 'navigation' );
								}

								do_action( 'boombox/single/after-main-content' );

							} ?>
						</div>
					</div>

					<?php if ( $template_options[ 'enable_secondary_sidebar' ] ) {
						get_sidebar( 'secondary' );
					} ?>
				</div>
			</div>

			<?php if ( $template_options[ 'enable_primary_sidebar' ] ) {
				get_sidebar();
			} ?>
		</div>
	</div>

<?php get_footer(); ?>