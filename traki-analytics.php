<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.traki.co.uk
 * @since             1.0.0
 * @package           Traki_Analytics
 *
 * @wordpress-plugin
 * Plugin Name:       Traki Analytics
 * Plugin URI:        www.traki.co.uk
 * Description:       Website analytics you'll actually understand. This plugin allows you to link up your WordPress site with Traki Analytics.
 * Version:           1.0.9
 * Author:            Traki
 * Author URI:        www.traki.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       traki-analytics
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-traki-analytics-activator.php
 */
function activate_traki_analytics() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-traki-analytics-activator.php';
	Traki_Analytics_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-traki-analytics-deactivator.php
 */
function deactivate_traki_analytics() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-traki-analytics-deactivator.php';
	Traki_Analytics_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_traki_analytics' );
register_deactivation_hook( __FILE__, 'deactivate_traki_analytics' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-traki-analytics.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_traki_analytics() {

	$plugin = new Traki_Analytics();
	$plugin->run();

}
run_traki_analytics();
