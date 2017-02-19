<?php
/*
 * Plugin Name: cathracha
 * Version: 0.1
 * Plugin URI: http://thomas.bibby.ie/
 * Description: Tour Europe's medium-sized cities with Flickr 
 * Author: Thomas Bibby
 * Author URI: http://thomas.bibby.ie/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * @package WordPress
 * @author Thomas Bibby
 * @since 1.0.0
 */
//don't allow calling of this directly
if ( ! defined( 'ABSPATH' ) ) exit;


class cathracha {

	public function __construct() {
		//register our script first
		wp_register_script('cathracha-js',plugins_url( 'cathracha.js', __FILE__ ));
		
		//register css
		add_action( 'wp_enqueue_scripts', array($this, 'load_cathracha') );
	}

	public static function activate() {

		}

	public static function deactivate() {

	}

	public function load_cathracha() {
		//need these globals to check whether we need to load
		global $post, $wp_query;
		//string to hold display contents
		$contents_to_display = '';
		//are we on a single post/page?
		if( is_singular() ) {
				$contents_to_display = $post->post_content;
			}
		//else we're displaying more than one post
		else {
			//get the ids we're displaying
			$ids_being_displayed = wp_list_pluck( $wp_query->posts, 'ID');
			//get the content of all these ids
			foreach( $ids_being_displayed as $single_id) {
				$contents_to_display .= get_post_field( 'post_content', $single_id ); 
				}
			}
		//right, now we've got the content to be displayed, we need to 
		// check if we've got a code tag, and that we're seeing 'languge-' somewhere
		$contains_form = strpos($contents_to_display, '<button id="cathracha">');
		if($contains_form) {
			wp_enqueue_script('cathracha-js');
			//jquery is built in to WordPress, apparently...
// 			wp_enqueue_script('jquery');
		}
		
	}
}
$cathracha_inst = new cathracha();	

?>