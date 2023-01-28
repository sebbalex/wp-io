<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://devweb.it
 * @since             0.0.2
 * @package           WPIO
 * @author            sebbalex
 * @license           gplv2
 *
 * @wordpress-plugin
 * Plugin Name:       WP IO
 * Plugin URI:        https://devweb.it/wp-io
 * Description:       A wordpress plugin for IO App
 * Version:           0.0.2
 * Author:            sebbalex
 * Author URI:        https://devweb.it
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-io
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WPIO_VERSION', '0.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpio-activator.php
 */
function activate_wpio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpio-activator.php';
	WPIO_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpio-deactivator.php
 */
function deactivate_wpio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpio-deactivator.php';
	WPIO_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpio' );
register_deactivation_hook( __FILE__, 'deactivate_wpio' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpio.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpio() {

	$plugin = new WPIO();
	$plugin->run();

  add_action( 'admin_menu', 'wpio_options_page' );
  function wpio_options_page() {
      register_setting('wpio_options', 'wpio'); //register page to use options.php as action in form
      add_menu_page(
          'WP IO',
          'WP IO',
          'manage_options',
          plugin_dir_path(__FILE__) . 'admin/partials/wpio-display.php',
          null,
          plugin_dir_url(__FILE__) . 'public/images/icon_wpio.png',
          20
      );
  }
}
run_wpio();
