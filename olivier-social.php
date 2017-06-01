<?php
   /*
   Plugin Name: Oh Social Links
   Plugin URI: http://olivier.uk/plugins
   Description: A social media plugin allowing you to upload your own icons and define social sevices
   Version: 1.2
   Author: Olivier Butler
   Author URI: http://olivier.uk/plugins
   Text Domain: oh-social-tdomain
   License: GPL2
   */

class ohSocialLinks {
  public function __construct() {
    add_action( 'admin_menu', array($this, 'admin_menu') );
    add_shortcode( 'public_shortcode', array($this, 'shortcode') );
    add_filter('widget_text', 'do_shortcode');
  }

  public function admin_menu() {
  	add_options_page( 'Oh Social Links Plugin', 'Oh Social Links', 'manage_options', 'oh-social-uid', array($this, 'options') );
  }

  public function options() {
    if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    // variables for the field and option names
    $opt_name = 'mt_favorite_color';
    $hidden_field_name = 'mt_submit_hidden';
    $data_field_name = 'mt_favorite_color';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );

        // Put a "settings saved" message on the screen
        ?>
        <div class="updated"><p><strong><?php _e('settings saved.', 'oh-social-tdomain' ); ?></strong></p></div>
        <?php
      }

      // Now display the settings editing screen
      echo '<div class="wrap">';
      echo "<h2>" . __( 'Plugin Settings - Oh Social Links', 'oh-social-tdomain' ) . "</h2>";
      echo '</div>';
  }
   public function shortcode() {

   }
}

$ohPlugin = new ohSocialLinks();
?>
