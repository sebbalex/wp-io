<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WPIO
 * @subpackage WPIO/admin/partials
 */

function wpio_options_page_html() {
  $options = get_option('wpio');
?>
  <div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <h2>Pagina di configurazione per IO</h2>
    <form action="options.php" method="post">
      <legend for="apikey">API KEY</legend>
      <input id="apikey" name="wpio[apikey]" type="text" value="<?php echo (isset($options['apikey']) ? $options['apikey'] : ''); ?>">
      <?php
      // output security fields for the registered setting "wpio_options"
      settings_fields('wpio_options');
      // output setting sections and their fields
      // (sections are registered for "wpio", each field is registered to a specific section)
      do_settings_sections('wpio');
      // output save settings button
      submit_button(__('Salva', 'textdomain'));
      ?>
    </form>
  </div>
<?php
}
wpio_options_page_html()
?>