<?php
/*
* Plugin Name: Vimeotheque PRO 2 - Theme BuddyBoss compatibility
* Plugin URI: https://vimeotheque.com
* Description: Add-on plugin for Vimeotheque PRO - Vimeo videos importer which introduces compatibility with theme BuddyBoss
* Author: CodeFlavors
* Version: 1.0
* Author URI: https://vimeotheque.com
*/

namespace Vimeotheque_BuddyBoss_Compatibility;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Plugin
 * @package Vimeotheque_BuddyBoss_Compatibility
 */
class Plugin{
	/**
	 * Holds compatible theme name
	 */
	const THEME = 'BuddyBoss Theme';
	/**
	 * Holds class instance
	 * @var Plugin|null
	 */
	private static $instance = null;

	/**
	 * Plugin constructor.
	 */
	private function __construct() {
		add_action( 'plugins_loaded', [ $this, 'on_init' ] );
	}

	/**
	 * @return Plugin|null
	 */
	public static function get_instance(){
		if( null === self::$instance ){
			self::$instance = new Plugin();
		}
		return self::$instance;
	}

	/**
	 * Hook "init" callback, verifies that plugin is loaded and
	 * that loaded theme is the right theme
	 */
	public function on_init(){
		if( !did_action('vimeotheque_pro_loaded') ){
			return;
		}
		$theme = $this->get_theme();
		if( !$theme ||  self::THEME != $theme->get('Name') ){
			return;
		}

		require_once plugin_dir_path( __FILE__ ) . '/includes/compatibility.class.php';
		new Compatibility( self::THEME );
	}

	/**
	 * Get currently installed parent theme
	 * @return bool|false|WP_Theme
	 */
	private function get_theme(){
		// get template details
		$theme = wp_get_theme();
		if( is_a( $theme, 'WP_Theme' ) ){
			// check if it's child theme
			if( is_a( $theme->parent(), 'WP_Theme' ) ){
				// set theme to parent
				$theme = $theme->parent();
			}
		}else{
			$theme = false;
		}
		return $theme;
	}
}

Plugin::get_instance();