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
class WPIO_Admin_Messages
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
   * The configuration of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      object    $config    The current configuration of this plugin.
   */
  private $config;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct($plugin_name, $version, $config)
  {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->config = $config;
  }

  /**
   * This function introduces the theme options into the 'Appearance' menu and into a top-level
   * 'WP IO' menu.
   */
  public function setup_plugin_options_submenu_messages()
  {
    add_submenu_page(
      'wp_io',
      'Messaggi',
      'Messaggi',
      'manage_options',
      'wp_io_messages',
      array($this, 'wpio_options_page_html'),
    );
  }

  /**
   * Renders simple table of services enabled for specified API KEY
   */
  function wpio_options_page_html()
  {
    $options = get_option('wpio_input');
    $headers = array(
      'headers' => array(
        'Ocp-Apim-Subscription-Key' => $options['apikey'],
        'Content-Type' => 'application/json'
      )
    );

    $url = "{$this->config['base_url']}/services";
    $response = wp_remote_get($url, $headers);
    $http_code = wp_remote_retrieve_response_code($response);

    $body = json_decode(wp_remote_retrieve_body($response));
  ?>
    <!-- Create a header in the default WordPress 'wrap' container -->
    <div class="wrap">
      <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
      <h2>WP IO - Messaggi</h2>
      
    </div>
<?php
  }
}
