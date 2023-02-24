<?php
/*
Plugin Name: Subscribe 
Plugin URI: http://localhost/just/wordpress
Description: A simple subscribe form for WordPress
Version: 1.0
Author: eleven
Author URI: http://localhost/just/wordpress 
*/




function simple_subscribe_form_install() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newrr';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      email varchar(255) NOT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
  }
  register_activation_hook( __FILE__, 'simple_subscribe_form_install' );

  




  function simple_subscribe_form_shortcode() {
    ob_start();
    ?>
    <form class="first" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
      <label for="email">Subscribe to our newsletter </label>
      <input type="email" id="email" name="email" required>
      <input type="submit" value="Subscribe">
    </form>
    <?php
    return ob_get_clean();
  }
  add_shortcode( 'simple_subscribe_form', 'simple_subscribe_form_shortcode' );
  


  function handle_subscribe_form() {
    if ( isset( $_POST['email'] ) ) {
      global $wpdb;
      $table_name = $wpdb->prefix . 'newrr';
      $email = sanitize_email( $_POST['email'] );
      $data = array( 'email' => $email );
      $format = array( '%s' );
      $wpdb->insert( $table_name, $data, $format );
      $subject = 'Subscribe to our mailing list';
      $message = 'Thank you for subscribing to our mailing list!';
      $headers = array('Content-Type: text/html; charset=UTF-8');
      wp_mail( $email, $subject, $message, $headers );
    }
  }
  add_action( 'init', 'handle_subscribe_form' );
  















?>
  <style>

  .first {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    padding: 20px 20px 20px 20px;
    background: #c7bbee;
  }
  input {
  border: 1px solid #c7bbee;
  background: #c7bbee;
  color: black;
}
input[type=email]:focus {
  background-color: #e3a51073;
}


</style>