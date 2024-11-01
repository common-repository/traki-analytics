<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.bigg.co.uk
 * @since      1.0.0
 *
 * @package    Traki_Analytics
 * @subpackage Traki_Analytics/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Traki_Analytics
 * @subpackage Traki_Analytics/public
 * @author     Bigg <aidan@bigg.co.uk>
 */
class Traki_Analytics_Public {

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
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/traki-analytics-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/traki-analytics-public.js', array( 'jquery' ), $this->version, false );

		if ( $traki_url = $this->build_traki_url() ) {
			wp_register_script( $this->plugin_name, $traki_url, false, null, true );
			wp_enqueue_script( $this->plugin_name );
		}
	}

	/**
	 * Builds a Traki URL
	 * @return bool|string
	 */
	public function build_traki_url() {

		$options    = get_option( $this->plugin_name );
		$traki_code = $options['traki_code'];

		if ( isset( $traki_code ) && ! empty( $traki_code ) ) {

			// make request to validate the users Traki code
			$request = wp_remote_get( 'http://api.traki.co.uk/websites/validate/wskey/' . $traki_code . '/key/123' );

			// check for any internal errors on the request
			if ( is_wp_error( $request ) ) {
				return false;
			} else {

				// convert response body to json
				$response = json_decode( wp_remote_retrieve_body( $request ) );

				// check the code being used is valid
				if ( $response[0]->result != false ) {

					// build & return url
					return 'https://traki.traki.co.uk/track/init/' . $traki_code;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}

}
