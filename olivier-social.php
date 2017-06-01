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
?>

<?php
/** Step 2 (from text above). */
add_action( 'admin_menu', 'my_plugin_menu' );

/** Step 1. */
function my_plugin_menu() {
	add_options_page( 'Oh Social Links Plugin', 'Oh Social Links', 'manage_options', 'oh-social-uid', 'oh_social_options' );
}

/** Step 3. */
function oh_social_options() {
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

    // header
    echo "<h2>" . __( 'Plugin Settings - Oh Social Links', 'oh-social-tdomain' ) . "</h2>";

    // settings form
    ?>
    <form name="form1" method="post" action="">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

    <p><?php _e("Favorite Color:", 'oh-social-tdomain' ); ?>
    <input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
    </p><hr />

    <p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
    </p>

    </form>
    </div>
    <?php
}
?>
