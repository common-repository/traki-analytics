<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.bigg.co.uk
 * @since      1.0.0
 *
 * @package    Traki_Analytics
 * @subpackage Traki_Analytics/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Traki_Analytics
 * @subpackage Traki_Analytics/admin
 * @author     Bigg <aidan@bigg.co.uk>
 */
class Traki_Analytics_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Traki_Analytics_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Traki_Analytics_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/traki-analytics-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Traki_Analytics_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Traki_Analytics_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/traki-analytics-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_plugin_admin_menu() {
		add_options_page( 'Traki Analytics Setup', 'Traki Analytics', 'manage_options', $this->plugin_name, array(
			$this,
			'display_plugin_setup_page'
		) );
	}

	public function add_action_links( $links ) {

		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>',
		);

		return array_merge( $settings_link, $links );
	}

	public function display_plugin_setup_page() {
		include_once( 'partials/traki-analytics-admin-display.php' );
	}

	public function validate( $input ) {

		$valid   = array();
		$message = '';
		$type    = '';

		// check we have input
		if ( isset( $input['traki_code'] ) && ! empty( $input['traki_code'] ) ) {

			// make request to validate the users Traki code
			$request = wp_remote_get( 'http://api.traki.co.uk/websites/validate/wskey/' . $input['traki_code'] . '/key/123' );

			// check for any internal errors on the request
			if ( is_wp_error( $request ) ) {
				$message = __( 'It appears there\'s an issue our end. Please try again later. If the issue is persistent, please contact <a target="_blank" href="http://support.traki.co.uk/">support</a>.' );
				$type    = 'error';
			} else {

				// get the json response from the request
				$response = json_decode( wp_remote_retrieve_body( $request ) );

				// check for errors
				if ( $response[0]->result != false ) {
					$valid['traki_code'] = $input['traki_code'];
					$message             = __( 'Awesome! ' . $response[0]->result . ', you\'re good to go!' );
					$type                = 'updated';
				} else {
					$message = __( 'The Traki code you\'ve supplied is not valid. Please verify the code is correct. If you need additional help, head to our <a target="_blank" href="http://support.traki.co.uk/">support</a> page.', 'my-text-domain' );
					$type    = 'error';
				}
			}
		} else {
			$message = __( 'Please enter your Traki code.' );
			$type    = 'error';
		}

		add_settings_error(
			'trakiAnalytics',
			esc_attr( 'settings_updated' ),
			$message,
			$type
		);

		return $valid;
	}

	public function options_update() {
		register_setting( $this->plugin_name, $this->plugin_name, array( $this, 'validate' ) );
	}
}
