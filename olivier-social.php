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

  public $options = array(
    // variables for the field and option names
    'opt_name' => 'mt_favorite_color',
    'hidden_field_name' => 'mt_submit_hidden',
    'data_field_name' => 'mt_favorite_color',
    'opt_val' => 'undefined',
  );


  public function admin_menu() {
  	add_options_page( 'Oh Social Links Plugin', 'Oh Social Links', 'manage_options', 'oh-social-uid', array($this, 'admin_form') );
  }

   public function admin_form() {
     if ( !current_user_can( 'manage_options' ) )  {
       wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
     }
     // Read in existing option value from database
     $this->options['opt_val'] = get_option( $this->options['opt_name']);

     /* When the page is loaded, and this section is executed,
         it checks the $_POST array for any information it was given.
         If the $_POST array contains the hidden options field name,
         and that that the hidden field == 'Y', we know that this page was loaded
         because someone clicked 'save', and POSTed a form.
         If that has happened, we update the option in using 'update_option'
         and echos a little 'settings saved' message.
         Without this, clicking save would just refesh the page.
         This could all be done by a separate action (set by the form),
         which would then point back to this page.
      */

     // See if the user has posted us some information
     if( isset($_POST[ $this->options['hidden_field_name'] ]) && $_POST[ $this->options['hidden_field_name'] ] == 'Y' ) {
       // Read their posted value, save it, and display a message
       $this->options['opt_val'] = $_POST[ $this->options['data_field_name'] ];
       update_option( $this->options['opt_name'], $this->options['opt_val'] );
       echo '<div class="updated"><p><strong>' . _e('settings saved.', 'oh-social-tdomain' ) . '</strong></p></div>';
     }

     // Render the Page
     echo '<div class="wrap"><h2>' .  __( 'Plugin Settings - Oh Social Links', 'oh-social-tdomain' ) . '</h2>';
       ?>
       <form name="form1" method="post" action="options.php">
         <input type="hidden" name="<?php echo $this->options['hidden_field_name']; ?>" value="Y">
         <p><?php _e("Favorite Color:", 'oh-social-tdomain' ); ?>
           <input type="text" size="20"
            name="<?php echo $this->options['data_field_name']; ?>"
            value="<?php echo $this->options['opt_val']; ?>" >
         </p><hr />

         <p class="submit">
           <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
         </p>

       </form>
       <?php
     echo '</div>';

   }

   public function shortcode() {

   }
}

$ohPlugin = new ohSocialLinks();
?>
