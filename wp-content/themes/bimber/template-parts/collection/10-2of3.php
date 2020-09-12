<?php
/**
 * The Template for displaying collection.
 *
 * @package Bimber_Theme 5.4
 * @license For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$bimber_data = bimber_get_template_part_data();
$bimber_query = $bimber_data['query'];
$bimber_title = $bimber_data['title'];
$bimber_title_size = $bimber_data['title_size'];
$bimber_title_align = $bimber_data['title_align'];
?>
<div class="g1-collection g1-module-10-2of3" style="max-width: 758px;">
	<?php if ( ! empty( $bimber_title ) ) : ?>
		<?php echo do_shortcode( '[bimber_title size="' . $bimber_title_size . '" align="' . $bimber_title_align . '" class="g1-collection-title"]' . $bimber_title . '[/bimber_title]' ); ?>
	<?php endif; ?>

	<?php if ( $bimber_query->have_posts() ) : ?>
		<div class="g1-collection-viewport">
			<ul class="g1-collection-items">
				<?php while ( $bimber_query->have_posts() ) : $bimber_query->the_post(); ?>

					<?php if ( ! $bimber_query->current_post % 3 ) : ?>
						<li class="g1-collection-item">
							<?php get_template_part( 'template-parts/content-grid-l', get_post_format() ); ?>
						</li>
					<?php else : ?>
						<li class="g1-collection-item">
							<?php
								// Override elements visibility.
								$bimber_data['elements'] = bimber_hide_highlighted_elements( $bimber_data['elements'] );
								bimber_set_template_part_data( $bimber_data );
								get_template_part( 'template-parts/content-grid-s', get_post_format() );
								// Restore original elements visibility.
								bimber_reset_template_part_data();
							?>
						</li>
					<?php endif; ?>

				<?php endwhile; ?>
			</ul>
		</div>
	<?php endif; ?>
</div><!-- .g1-collection -->