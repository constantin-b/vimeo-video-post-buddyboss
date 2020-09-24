<?php
/**
 * @author CodeFlavors
 */

namespace Vimeotheque_BuddyBoss_Compatibility;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Compatibility
 * @package Vimeotheque_BuddyBoss_Compatibility
 */
class Compatibility {
	/**
	 * Theme name
	 * @var string
	 */
	private $theme_name;

	/**
	 * Compatibility constructor.
	 *
	 * @param $theme_name
	 */
	public function __construct( $theme_name ) {
		$this->theme_name = $theme_name;
		add_filter( 'vimeotheque_pro\theme_support', [ $this, 'theme_support' ] );
	}

	/**
	 * @param array $themes
	 *
	 * @return array
	 */
	public function theme_support( $themes ) {
		$theme_name = strtolower( $this->theme_name );
		$themes[ $theme_name ] = [
			'post_type'    => 'post',
			'taxonomy'     => 'category',
			'tag_taxonomy' => 'post_tag',
			'post_meta'    => [],
			'post_format'  => 'video',
			'theme_name'   => $this->theme_name,
			'autoembed'		=> 'before', // add video URL to auto embed videos before the post content
			'url'          => 'https://www.buddyboss.com/'
		];

		return $themes;
	}
}