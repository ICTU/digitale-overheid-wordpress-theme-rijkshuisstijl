<?php

/**
 * Rijkshuisstijl (Digitale Overheid) - contact-form7-validation.php
 * ----------------------------------------------------------------------------------
 * For validation of CF7 forms
 * ----------------------------------------------------------------------------------
 * @author  Paul van Buuren
 * @license GPL-2.0+
 * @package wp-rijkshuisstijl
 * @version 0.8.34
 * @desc.   Archive for newsletters, contactform7 validation
 * @link    http://wbvb.nl/themes/wp-rijkshuisstijl/
 */

//========================================================================================================

/**
 * Remove Contact Form 7 scripts + styles unless we're on the contact page
 * 
 */
add_action( 'wp_enqueue_scripts', 'rhswp_remove_external_styles' );

function rhswp_remove_external_styles() {
//		wp_deregister_style( 'contact-form-7' );
//		wp_deregister_script( 'contact-form-7' );
} 

//========================================================================================================
// == load extra scripts
//add_action( 'wp_print_scripts', 'fn_od_wbvb_get_menu_scripts'); // now just run the function
function fn_od_wbvb_get_menu_scripts() {

  if ( !is_admin() ) { // don't add to any admin pages
    wp_enqueue_script( 'cf7_custom', get_stylesheet_directory_uri() . '/js/min/contactform-7-validation-min.js', array( 'jquery' ) );
  }

}

//========================================================================================================

add_filter( 'wpcf7_validate_text', 'rhswp_cf7_validation_check_naam_veld', 10, 2);
add_filter( 'wpcf7_validate_text*', 'rhswp_cf7_validation_check_naam_veld', 10, 2);

add_filter( 'wpcf7_validate_textarea', 'rhswp_cf7_validation_check_message_veld', 9, 2);
add_filter( 'wpcf7_validate_textarea*', 'rhswp_cf7_validation_check_message_veld', 9, 2);

add_filter( 'wpcf7_validate_email', 'rhswp_cf7_validation_check_email_veld', 9, 2);
add_filter( 'wpcf7_validate_email*', 'rhswp_cf7_validation_check_email_veld', 9, 2);

//========================================================================================================

function rhswp_cf7_validation_check_naam_veld($result, $tag) {
	$type = $tag['type'];
	$name = $tag['name'];


	if ('your-name' == $name) {

    	$foutboodschap	= ( get_field('lege_naam', 'option') ) ? get_field('lege_naam', 'option') : _x('We willen graag uw naam weten.', 'Foutboodschap contactformulier', 'wp-rijkshuisstijl');

	    $the_value = rhswp_filter_input_string($_POST[$name]);
	    $myresult = trim($the_value);
	    if ($myresult == "") {
	        $result->invalidate($tag, $foutboodschap );
	    }
	}
//	elseif ('input-organisatie' == $name) {
//  	
//    	$foutboodschap	= ( get_field('lege_organisatie', 'option') ) ? get_field('lege_organisatie', 'option') : _x( 'Voer alstublieft een organisatienaam in.', 'Foutboodschap contactformulier', 'wp-rijkshuisstijl');

//	    $the_value = rhswp_filter_input_string($_POST[$name]);
//	    $myresult = trim($the_value);
//	    if ($myresult == "") {
//	        $result->invalidate($tag, $foutboodschap );
//	    }
//	}

	

	return $result;
}

//========================================================================================================

function rhswp_cf7_validation_check_message_veld($result, $tag) {

  $type = $tag['type'];
  $name = $tag['name'];
  
  $the_value  = rhswp_filter_input_string($_POST[$name]);
  $myresult   = trim($the_value);
  
  $foutboodschap	= ( get_field('lege_suggestie', 'option') ) ? get_field('lege_suggestie', 'option') : _x('U hebt geen vraag of suggestie ingevuld.', 'Foutboodschap contactformulier', 'wp-rijkshuisstijl');
  
  if ($myresult == "") {
    $result->invalidate($tag, $foutboodschap );
  }
  
  return $result;

}

//========================================================================================================

function rhswp_cf7_validation_add_custom_class($error) {
  $error=str_replace('class=\"','value="fout" class=\"', $error);
  return $error;
}
add_filter('wpcf7_validation_error', 'rhswp_cf7_validation_add_custom_class');

//========================================================================================================

function rhswp_cf7_validation_check_email_veld($result, $tag) {
  $type = $tag['type'];
  $name = $tag['name'];
  
  $the_value 		= $_POST[$name];
  $foutboodschap	= ( get_field('leeg_mailadres', 'option') ) ? get_field('leeg_mailadres', 'option') : _x('We hebben uw mailadres nodig om te antwoorden.', 'Foutboodschap contactformulier', 'wp-rijkshuisstijl');
  
  if ($the_value == "") {
    $result->invalidate($tag, $foutboodschap );
  }
  
  return $result;
}

//========================================================================================================

function rhswp_cf7_validation_check_send_additional_mail($cf7) {
    //get CF7's mail and posted_data objects

    $submission = WPCF7_Submission::get_instance();
    if ( $submission ) {
      $posted_data = $submission->get_posted_data();
    }
    $mail = $cf7->prop( 'mail' );

    if ( $posted_data['sendcopy'][0] ) { //if Checkbox checked
      // do nothing
      // send the mail 2 as instructed
    }
    else {
      // user does not want mail to
      // make mail 2 empty
      $cf7->set_properties( array( 'mail_2' => array() ) );
    }
  
  return $cf7;
}
add_action('wpcf7_before_send_mail','rhswp_cf7_validation_check_send_additional_mail');

//========================================================================================================
