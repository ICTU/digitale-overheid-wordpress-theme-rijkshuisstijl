<?php

/**
// * Rijkshuisstijl (Digitale Overheid) - page_digibeter-home.php
// * ----------------------------------------------------------------------------------
// * Landingspagina voor het onderdeel met de NL Digibeter agenda
// * ----------------------------------------------------------------------------------
// *
// * @author  Paul van Buuren
// * @license GPL-2.0+
// * @package wp-rijkshuisstijl
// * @version 1.1.10
// * @desc.   Invoeren pullquotes aangepast: nu 2 soorten (simple & met foto).
// * @link    https://github.com/ICTU/digitale-overheid-wordpress-theme-rijkshuisstijl
// *
 */


//* Template Name: digibeter - landingspagina

//========================================================================================================

remove_action( 'genesis_after_header', 'rhswp_check_caroussel_or_featured_img', 24 );


remove_filter( 'genesis_post_title_text', 'genesis_post_title_text_filter', 15 );
//add_filter( 'genesis_post_title_text', 'rhswp_digibeter_filter_page_title', 15 );
add_filter( 'genesis_post_title_output', 'rhswp_digibeter_filter_page_title', 16 );



//* Remove standard header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

add_action( 'genesis_before_content_sidebar_wrap', 'rhswp_digibeter_extra_content', 14 );

add_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_open', 8 );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_post_title', 10 );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_close', 12 );

// Remove the standard pagination, so we don't get two sets
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );


//========================================================================================================

genesis();

//========================================================================================================

function rhswp_digibeter_extra_content() {

  if ( get_field( 'digibeter_content_intro', get_the_ID() ) ) {
    // voorkomen dat pagina's met dit template ook een carroussel laten zien
    // deze pagina heeft dus als template 'page_digibeter-home.php' en heeft iets in digibeter_content_intro
    echo do_shortcode( get_field( 'digibeter_content_intro', get_the_ID() ) );

  }

}

//========================================================================================================

/**
 * Filter this page's H1 post titles to add <span> for styling
 * 
 */	

function rhswp_digibeter_filter_page_title( $title ) {

	if ( is_singular() )
	
  $thetitle = get_the_title();

  
  $pattern      = '/nl digibeter/i';
  $replacement  = '<span class="logo"><strong>NL DIGI</strong>beter</span>';
  $thetitle     = preg_replace( $pattern, $replacement, $thetitle );
  
  $pattern      = 'nl digibeter';
  $replacement  = '';
  $agenda       = str_ireplace( $pattern, $replacement, get_the_title() );
  
  if ( $agenda ) {
    $agenda = '<span class="subtitle">' . $agenda . '</span>';
  }
  else {
    $agenda = '<span class="subtitle">' . __( 'Agenda Digitale Overheid', 'wp-rijkshuisstijl' ) . '</span>';
  }
  
  $title = sprintf( '<h1 class="entry-title">%s %s</h1>', $thetitle, $agenda );

//replace

	return $title;

}
