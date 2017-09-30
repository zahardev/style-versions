<?php

namespace Style_Versions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Options
 * @package Style_Versions
 */
class Options {

	/**
	 * @var
	 */
	static private $instance;


	/**
	 * Handle_Style_Versions constructor.
	 */
	private function __construct() {
	}

	/**
	 * @return Options
	 */
	static function app() {
		return is_null( self::$instance ) ? ( self::$instance = new self ) : self::$instance;
	}

	/**
	 * @param $path
	 */
	public function init( $path ) {
		if ( is_admin() ) {
			add_filter( 'plugin_action_links_' . plugin_basename( $path ),
				array( $this, 'plugin_action_links' ) );
			add_action( 'admin_menu', array( $this, 'register_options' ) );
			add_action( 'admin_init', array( $this, 'register_fields' ) );
		}
	}

	public function get_option( $option ) {
		$options = get_option( 'style_versions_options' );

		return isset( $options[ $option ] ) ? $options[ $option ] : false;
	}

	/**
	 * Function register_options
	 */
	public function register_options() {
		add_submenu_page( 'options-general.php',
			'Style Versions Options',
			__( 'Style Versions Options' ),
			'manage_options',
			'style-versions-options',
			array( $this, 'render_options_page' ) );
	}

	/**
	 * Function register_fields
	 */
	public function register_fields() {
		register_setting( 'style_versions_options', 'style_versions_options' );
	}

	/**
	 * @param $links
	 *
	 * @return array
	 */
	function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=style-versions-options' )
			              . '">' . __( 'Settings' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	/**
	 * Function render_options_page
	 */
	public function render_options_page() { ?>
        <div class="wrap">
            <h2>Style Versions Options</h2>

            <form method="post" action="options.php">
				<?php settings_fields( 'style_versions_options' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Style version</th>
                        <td style="width:30%;"></td>
                        <td>
                            <input type="text"
                                   name="style_versions_options[version]"
                                   value="<?php echo esc_attr( $this->get_option( 'version' ) ); ?>"/>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <p>Change for all files</p></th>
                        <td>
                            <p>If checked, versions for all files will be
                                changed.</p>
                            <p>If not - it will be changed only for files with
                                default (wordpress) version.</p>
                        </td>
                        <td>
                            <input type="checkbox"
                                   name="style_versions_options[change_all]"
                                   value="1"
								<?php checked( $this->get_option( 'change_all' ) ) ?> />
                        </td>
                    </tr>
                </table>

                <p class="submit">
                    <input type="submit" class="button-primary"
                           value="<?php _e( 'Save Changes' ) ?>"/>
                </p>

            </form>
        </div>
		<?php
	}
}
