<?php
/**
 * Facebook Comments plugin functions
 *
 * @package BoomBox_Theme
 */

if( ! boombox_plugin_management_service()->is_plugin_active( 'facebook-comments-plugin/facebook-comments.php' ) ) {
	return;
}

if ( ! class_exists( 'Boombox_Facebook_Comments' ) ) {

	final class Boombox_Facebook_Comments {

		/**
		 * Holds class single instance
		 * @var null
		 */
		private static $_instance = null;

		/**
		 * Get instance
		 * @return Boombox_Facebook_Comments|null
		 */
		public static function get_instance() {

			if ( null == static::$_instance ) {
				static::$_instance = new self();
			}

			return static::$_instance;

		}

		/**
		 * Boombox_Facebook_Comments constructor.
		 */
		private function __construct() {
			$this->hooks();

			do_action( 'boombox/fb_comments/wakeup', $this );
		}

		/**
		 * A dummy magic method to prevent Boombox_Facebook_Comments from being cloned.
		 *
		 */
		public function __clone() {
			throw new Exception( 'Cloning ' . __CLASS__ . ' is forbidden' );
		}

		/**
		 * Setup Hooks
		 */
		public function hooks() {
			remove_filter( 'the_content', 'fbcommentbox', 100 );
			add_filter( 'boombox/single_post/sortable_section_choices', array( $this, 'add_to_customizer_sortable' ), 10, 1 );
			add_action( 'boombox/single/sortables/fb_comments', array( $this, 'render_section' ) );
		}

		/**
		 * Add facebook comments to sortable section
		 * @param array $choices Current Choices
		 *
		 * @return array
		 */
		public function add_to_customizer_sortable( $choices ) {
			$choices[ 'fb_comments' ] = __( 'Facebook Comments', 'boombox' );

			return $choices;
		}

		/**
		 * Render facebook comments section
		 */
		public function render_section() {
			echo '<div>' . do_shortcode( '[fbcomments]' ) . '</div>';
		}

	}

	Boombox_Facebook_Comments::get_instance();

}