<?php
/**
 * Plugin Name:       cherki wp ar social media plugin
 * Plugin URI:        https://cherki-hamza.com/plugins/cherki-wp-ar-social
 * Description:       this is the social media links for user admin .
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            cherki hamza
 * Author URI:        https://cherki-hamza.com/plugins
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

// function to add the social media links to your admin user dashboard
function Author_Profile($profile){
	$profile['github_profile'] = 'Github Profile Link';
	$profile['facebook_profile'] = 'Facebook Profile Link';
	$profile['twitter_profile'] = 'Twitter Profile Link';
	return $profile;
}
add_action('user_contactmethods' , 'Author_Profile');






