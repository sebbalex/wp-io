<?php

/**
 * The settings of the plugin.
 *
 * @link       http://
 * @since      1.0.0
 *
 * @package    WPIO_Admin
 * @subpackage WPIO_Admin/admin
 */

/**
 * Class WordPress_Plugin_Template_Settings
 *
 */
class WPIO_Admin_API
{

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct($plugin_name, $version)
  {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  /**
   * This function introduces the theme options into the 'Appearance' menu and into a top-level
   * 'WP IO' menu.
   */
  public function setup_plugin_options_menu()
  {
    add_menu_page(
      'API',
      'WP IO',
      'manage_options',
      'wp_io',
      array($this, 'wpio_options_page_html'),
      plugin_dir_url(__FILE__) . '../public/images/icon_wpio.png',
      20
    );
  }

  public function setup_plugin_options_submenu()
  {
    add_submenu_page(
      'wp_io',
      'Servizi',
      'Servizi',
      'manage_options',
      plugin_dir_path(__FILE__) . 'partials/wpio-display-services.php',
    );
    add_submenu_page(
      'wp_io',
      'Messaggi',
      'Messaggi',
      'manage_options',
      plugin_dir_path(__FILE__) . 'partials/wpio-display-messages.php',
    );
  }

  /**
   * Renders simple form to submit the API KEY
   */
  function wpio_options_page_html() {
    $options = get_option('wp_io_input');
  ?>
    <!-- Create a header in the default WordPress 'wrap' container -->
    <div class="wrap">
      <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
      <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wpio_options"
        settings_fields('wp_io_input');
        // output setting sections and their fields
        // (sections are registered for "wpio", each field is registered to a specific section)
        do_settings_sections('wp_io_input');
        // output save settings button
        submit_button(__('Salva', 'textdomain'));
        ?>
      </form>
    </div>
  <?php
  }

  /**
   * Provides default values for the Input Options.
   *
   * @return array
   */
  public function default_input_options()
  {

    $defaults = array(
      'input_example'    =>  'default input example',
    );

    return $defaults;
  }

  /**
   * This function provides a simple description for the General Options page.
   *
   * It's called from the 'wp-io_initialize_theme_options' function by being passed as a parameter
   * in the add_settings_section function.
   */
  public function general_options_callback()
  {
    $options = get_option('wp_io_display_options');
    var_dump($options);
    echo '<p>' . __('Select which areas of content you wish to display.', 'wp-io-plugin') . '</p>';
  } // end general_options_callback

  /**
   * This function provides a simple description for the Input Examples page.
   *
   * It's called from the wp-io_theme_initialize_input_examples_options' function by being passed as a parameter
   * in the add_settings_section function.
   */
  public function input_examples_callback()
  {
    $options = get_option('wp_io_input');
    // var_dump($options);
    // echo '<p>' . __('Provides examples of the five basic element types.', 'wp-io-plugin') . '</p>';
  } // end general_options_callback


  /**
   * Initializes the theme's display options page by registering the Sections,
   * Fields, and Settings.
   *
   * This function is registered with the 'admin_init' hook.
   */
  public function initialize_display_options()
  {

    // If the theme options don't exist, create them.
    if (false == get_option('wp_io_display_options')) {
      $default_array = $this->default_display_options();
      add_option('wp_io_display_options', $default_array);
    }

    // Finally, we register the fields with WordPress
    register_setting('wpio_options', 'wpio_options'); //register page to use options.php as action in <form action=""></form>
  } // end wp_io_initialize_theme_options

	public function input_element_callback() {

		$options = get_option( 'wp_io_input' );

		// Render the output
		echo '<input type="text" id="input_example" name="wp_io_input[apikey]" value="' . $options['apikey'] . '" />';

	} // end input_element_callback

  /**
   * Initializes the theme's input example by registering the Sections,
   * Fields, and Settings. This particular group of options is used to demonstration
   * validation and sanitization.
   *
   * This function is registered with the 'admin_init' hook.
   */
  public function initialize_input_examples()
  {
    //delete_option('wp_io_input');
    if (false == get_option('wp_io_input')) {
      $default_array = $this->default_input_options();
      update_option('wp_io_input', $default_array);
    } // end if

    add_settings_section(
			'input_examples_section',
			__( 'Pagina di configurazione per IO', 'wp-io-plugin' ),
			array( $this, 'input_examples_callback'),
			'wp_io_input'
		);

    add_settings_field(
      'Api Key',
      __('Api key', 'wp-io-plugin'),
      array($this, 'input_element_callback'),
      'wp_io_input',
      'input_examples_section'
    );

    register_setting(
      'wp_io_input',
      'wp_io_input',
      array($this, 'validate_input_examples')
    );
  }

  public function validate_input_examples($input)
  {

    // Create our array for storing the validated options
    $output = array();

    // Loop through each of the incoming options
    foreach ($input as $key => $value) {

      // Check to see if the current option has a value. If so, process it.
      if (isset($input[$key])) {

        // Strip all HTML and PHP tags and properly handle quoted strings
        $output[$key] = strip_tags(stripslashes($input[$key]));
      } // end if

    } // end foreach

    // Return the array processing any additional functions filtered by this action
    return apply_filters('validate_input_examples', $output, $input);
  } // end validate_input_examples
}
