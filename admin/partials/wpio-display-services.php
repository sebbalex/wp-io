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

function wpio_create_table_html($body) {
?>
  <table style="border: 1px solid #222">
    <thead>
      <th>Servizio</th>
      <th>Scopo</th>
    </thead>
    <tbody>
      <?php
      foreach ($body->items as &$item) {
        echo "<tr><td>{$item->service_id}</td><td>{$item->scope}</td></tr>";
      }
      ?>
    </tbody>
  </table>
<?php
}

function wpio_options_page_html() {
  $options = get_option('wpio');
  $headers = array(
    'headers' => array(
      'Ocp-Apim-Subscription-Key' => $options['apikey'],
      'Content-Type' => 'application/json'
    )
  );
  $base_url = 'http://172.17.0.1:3000/api/v1';
  // $base_url = 'https://api.io.pagopa.it/api/v1';
  $url = "{$base_url}/services";
  $response = wp_remote_get($url, $headers);
  $http_code = wp_remote_retrieve_response_code($response);

  $body = json_decode(wp_remote_retrieve_body($response));
?>
  <div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <h2>WP IO - Lista servizi</h2>
    <?php
    $http_code == 200 &&
      wpio_create_table_html($body) ||
      printf("Nessun servizio trovato oppure è stato riscontrato un errore<br /><br />");
    ?>
    <button>Aggiorna</button>
  </div>
<?php
}

wpio_options_page_html()
?>