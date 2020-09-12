<?php
/**
 * The Template for displaying term mega-menu (from category, tag or custom taxonomy).
 *
 * @package Bimber_Theme 4.10
 * @license For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>
<div class="sub-menu-wrapper">
	<div class="g1-row">
		<div class="g1-row-inner">
			<div class="g1-column">

				<?php echo do_shortcode( '[bimber_categories template="icongrid" orderby="count" max="12" more_url="' . esc_url( $bimber_more_url ) . '"]' ); ?>

			</div>
		</div>
	</div>

</div>