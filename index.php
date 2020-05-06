<?php 
/*
Plugin Name: ALT Lab Global Surgery custom site stuff
Plugin URI:  https://github.com/
Description: Making the Global Surgery site better
Version:     1.82
Author:      ALT Lab (Matt Roberts)
Author URI:  http://altlab.vcu.edu
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset

*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


add_action('wp_enqueue_scripts', 'global_surg_load_scripts');

function global_surg_load_scripts() {                           
    $deps = array('jquery');
    $version= '1.82'; 
    $in_footer = true;    
    wp_enqueue_script('global-surg-main-js', plugin_dir_url( __FILE__) . 'js/global-surg-main.js', $deps, $version, $in_footer); 
    wp_enqueue_style( 'global-surg-main-css', plugin_dir_url( __FILE__) . 'css/global-surg-main.css');
}

//Disable the check for an email already being used by a registered user
add_filter( 'gform_user_registration_check_email_pre_signup_activation', '__return_false' );

add_filter( 'gform_user_registration_validation', 'ignore_already_registered_error', 10, 3 );

add_action("gform_user_registration_validation", "ignore_already_registered_error", 10, 3);
function ignore_already_registered_error($form, $config, $pagenum){
 
    // Make sure we only run this code on the specified form ID
    if($form['id'] != 10) {
        return $form;
    }
 
    // Get the ID of the email field from the User Registration config
    $email_id = $config['meta']['email'];
 
    // Loop through the current form fields
    foreach($form['fields'] as &$field) {
 
    // confirm that we are on the current field ID and that it has failed validation because the email already exists
    if($field->id == $email_id && $field->validation_message == 'Sorry, that email address is already used!')
        $field->failed_validation = false;
    }
 
    return $form;
 
}


//LOGGER -- like frogger but more useful

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

  //print("<pre>".print_r($a,true)."</pre>");
