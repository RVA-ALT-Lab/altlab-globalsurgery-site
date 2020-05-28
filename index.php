<?php 
/*
Plugin Name: ALT Lab Global Surgery custom site stuff
Plugin URI:  https://github.com/
Description: Global Surgery Registation fixes (JS), Read-only GF Registration fields (JS), Quiz Completion Checker, Units Bar Creator, etc.
Version:     1.85
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
    $version= '1.85'; 
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

// Quiz Competion Checker
function quiz_spitter() {
    $form_id = 0; //Look through all quizzes (can be more targeted)
    $current_user = wp_get_current_user(); //Gets current logged in user
    $search_criteria = array(
        //Looking for quizzes passed by the current logged in user
        'field_filters' => array(
           'mode' => 'all',
           array(
                 'key'   => 'gquiz_is_pass',
                 'value' => '1'
           ),
           array(
              'key' => 'created_by',
              'value' => $current_user->ID
           ),
        )
     );
    $entries = GFAPI::get_entries($form_id, $search_criteria, $sorting, $paging, $total_count);
  
    $form_ids = array_column($entries, 'form_id');
  
    echo '<div id="units-bar"><ul class="unit-list">';
  
    if (in_array('2', $form_ids)) {
     echo '<li class="unit-item-done" id="unit-1">&#x2713; Unit 1</li>';
     } else {
        echo '<a href="https://rampages.us/vcuglobalsurgery/unit-1-global-burden-of-surgical-conditions-and-disease-injuries/"><button class="units-bar-button"><li class="unit-item" id="unit-1">Unit 1</li></button></a>';
        }
    if (in_array('3', $form_ids)) {
     echo '<li class="unit-item-done" id="unit-2">&#x2713; Unit 2</li>';
     } else {
        echo '<a href="https://rampages.us/vcuglobalsurgery/unit-2-globalization-of-health-and-health-care/"><button class="units-bar-button"><li class="unit-item" id="unit-2">Unit 2</li></button></a>';
        }
    if (in_array('4', $form_ids)) {
     echo '<li class="unit-item-done" id="unit-3">&#x2713; Unit 3</li>';
     } else {
        echo '<a href="https://rampages.us/vcuglobalsurgery/unit-3-social-and-environmental-determinants-of-heath/"><button class="units-bar-button"><li class="unit-item" id="unit-3">Unit 3</li></button></a>';
        }
    if (in_array('5', $form_ids)) {
     echo '<li class="unit-item-done" id="unit-4">&#x2713; Unit 4</li>';
     } else {
        echo '<a href="https://rampages.us/vcuglobalsurgery/unit-4-capacity-strengthening/"><button class="units-bar-button"><li class="unit-item" id="unit-4">Unit 4</li></button></a>';
        }
    if (in_array('6', $form_ids)) {
     echo '<li class="unit-item-done" id="unit-5">&#x2713; Unit 5</li>';
     } else {
        echo '<a href="https://rampages.us/vcuglobalsurgery/unit-5-collaboration-partnering-and-communication/"><button class="units-bar-button"><li class="unit-item" id="unit-5">Unit 5</li></button></a>';
        }
    if (in_array('7', $form_ids)) {
     echo '<li class="unit-item-done" id="unit-6">&#x2713; Unit 6</li>';
     } else {
        echo '<a href="https://rampages.us/vcuglobalsurgery/unit-6-ethics/"><button class="units-bar-button"><li class="unit-item" id="unit-6">Unit 6</li></button></a>';
        }
    if (in_array('8', $form_ids)) {
     echo '<li class="unit-item-done" id="unit-7">&#x2713; Unit 7</li>';
     } else {
        echo '<a href="https://rampages.us/vcuglobalsurgery/unit-7-professional-practice/"><button class="units-bar-button"><li class="unit-item" id="unit-7">Unit 7</li></button></a>';
        }
    if (in_array('9', $form_ids)) {
     echo '<li class="unit-item-done" id="unit-8">&#x2713; Unit 8</li>';
     } else {
        echo '<a href="https://rampages.us/vcuglobalsurgery/unit-8-health-equity-and-social-justice/"><button class="units-bar-button"><li class="unit-item" id="unit-8">Unit 8</li></button></a>';
        }
  
    echo '</ul><div id="complete-mess"><p>&#x2713; = passed unit quiz</p></div></div>';
  
  //   print("<pre>".print_r($form_ids, true)."</pre>");
  
  //   var_dump($form_id);
  //   print("<pre>".print_r($entries, true)."</pre>");
  
  }
  
  add_shortcode( 'spit', 'quiz_spitter' );

//Take next quiz checker
//Must put custom field of 'quiz_check' with its value of 'quiz_x' on every quiz
//NOTE: Quiz 1 is form ID 2, Quiz 2 is Form ID 3, etc
//So Quiz 1 would have custom field value of quiz_1
//but its quiz form ID is 2
function take_this_quiz_or_not() {
   $meta_value  = get_post_meta(get_the_ID(),'quiz_check',true);
   echo ($meta_value);
   $form_id = 0; //Look through all quizzes (can be more targeted)
   $current_user = wp_get_current_user(); //Gets current logged in user
   $search_criteria = array(
      //Looking for quizzes passed by the current logged in user
      'field_filters' => array(
         'mode' => 'all',
         array(
               'key'   => 'gquiz_is_pass',
               'value' => '1'
         ),
         array(
            'key' => 'created_by',
            'value' => $current_user->ID
         ),
      )
   );
   $entries = GFAPI::get_entries($form_id, $search_criteria, $sorting, $paging, $total_count);

   $form_ids = array_column($entries, 'form_id');

   if (in_array('2', $form_ids)) {
      if ($meta_value == 'quiz_1') {
         echo ('YES you can take the quiz');
         } else {
            echo ('No you cannot');
            }
         }
   print("<pre>".print_r($form_ids,true)."</pre>");
}

add_shortcode('quiz_checker', 'take_this_quiz_or_not');


  
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
