<?php

namespace Style_Versions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Handle_Style_Versions
 * @package Style_Versions
 */
class Handle_Style_Versions {

	/**
	 * @var
	 */
	static private $instance;

	/**
	 *
	 */
	public function init() {
		add_action( 'wp_head', array( $this, 'change_style_versions' ), 1 );
	}

	/**
	 * Handle_Style_Versions constructor.
	 */
	private function __construct() {
	}

	/**
	 * @return Handle_Style_Versions
	 */
	static function app() {
		return is_null( self::$instance ) ? ( self::$instance = new self ) : self::$instance;
	}

	/**
	 * @return bool
	 */
	public function change_style_versions() {
		global $wp_styles;
		foreach ( $wp_styles->registered as $name => $settings ) {
			if ( Options::app()->get_option( 'change_all' ) or false === $settings->ver ) {
				$wp_styles->registered[ $name ]->ver = Options::app()->get_option( 'version' ) ;
			}
		}

		return true;
	}
}
