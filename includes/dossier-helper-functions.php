<?php


/**
// * Rijkshuisstijl (Digitale Overheid) - dossier-helper-functions.php
// * ----------------------------------------------------------------------------------
// * functies voor de header boven content in een dossier
// * ----------------------------------------------------------------------------------
// *
// * @author  Paul van Buuren
// * @license GPL-2.0+
// * @package wp-rijkshuisstijl
// * @version 1.2.9
// * @desc.   Modernizr voor live-site. Bugfix voor dossier. List-item CSS aangepast.
// * @link    https://github.com/ICTU/digitale-overheid-wordpress-theme-rijkshuisstijl
 */

$tellertje = 0;

//========================================================================================================

function rhswp_dossier_title_checker3( ) {

  global $post;
  global $wp_query;
  global $tellertje;

  if ( ! is_object( $post ) ) {
    // bail early if no post object available (s.a. 404)
    return;
  }
  
  $currentID = 0;
  
  if ( is_posts_page() || is_search() ) {
    return;
  }
  
  if ( taxonomy_exists( RHSWP_CT_DOSSIER ) ) {

  
    $subpaginas               = '';
    $shownalready             = '';
    $dossier_overzichtpagina  = '';
    $parentID                 = '';
    $standaardpaginanaam      = '';
  
    $args = array(
      'dossier_overzichtpagina' => '',
      'menu_voor_dossier' => '',
      'markerforclickableactivepage' => '',
      'currentpageid' => '',
      'preferedtitle' => '',
      'maxlength'     => 50,
    );


    // checken of dit een post is en is_single() en of in de URL de juiste dossier-contetxt is meegegeven.
    
    $posttype = get_post_type();
    $loop     = rhswp_get_context_info();
    $term     = '';
    $tellertje = 1;

  }

}

//========================================================================================================

function rhswp_dossier_title_checker( ) {

  global $post;
  global $wp_query;
  global $tellertje;
  global $wp;

  $current_url = home_url( add_query_arg( array(), $wp->request ) );

  if ( ! is_object( $post ) ) {
    // bail early if no post object available (like a 404 page);
    return;
  }
  
  $currentID = 0;
  
  if ( is_posts_page() || is_search() ) {
    return;
  }
  
  if ( taxonomy_exists( RHSWP_CT_DOSSIER ) ) {

  
    $subpaginas               = '';
    $shownalready             = '';
    $dossier_overzichtpagina  = '';
    $parentID                 = '';
    $standaardpaginanaam      = '';
  
    $args = array(
      'dossier_overzichtpagina' => '',
      'menu_voor_dossier' => '',
      'markerforclickableactivepage' => '',
      'currentpageid' => '',
      'preferedtitle' => '',
      'maxlength'     => 50,
    );


    // checken of dit een post is en is_single() en of in de URL de juiste dossier-contetxt is meegegeven.
    
    $posttype = get_post_type();
    $loop     = rhswp_get_context_info();
    $term     = '';
    $tellertje = 1;

    if ( 'single' == $loop && get_query_var( RHSWP_CT_DOSSIER ) ) {

      if ( get_query_var( RHSWP_DOSSIERPOSTCONTEXT ) ) {
        $url            = get_query_var( RHSWP_DOSSIERPOSTCONTEXT );
        $contextpageID  = url_to_postid( $url );
        $terms          = get_the_terms( $contextpageID , RHSWP_CT_DOSSIER );
  
        $args['markerforclickableactivepage'] = $contextpageID;
  
        if ($terms && ! is_wp_error( $terms ) ) { 
          $term                 = array_pop($terms);
          $standaardpaginanaam  = $term->name;       
        }
  
      }
      elseif ( get_query_var( RHSWP_CT_DOSSIER ) ) {
        $term                 = get_term_by( 'slug', get_query_var( RHSWP_CT_DOSSIER ), RHSWP_CT_DOSSIER );
        $standaardpaginanaam  = $term->name;       
      }
      
    }
    elseif ( 'page' == $loop && get_query_var( RHSWP_CT_DOSSIER ) ) {

      if ( 
        ( RHSWP_DOSSIERCONTEXTPOSTOVERVIEW == get_query_var( 'pagename' ) ) ||
        ( RHSWP_DOSSIERCONTEXTEVENTOVERVIEW == get_query_var( 'pagename' ) ) ||
        ( RHSWP_DOSSIERCONTEXTDOCUMENTOVERVIEW == get_query_var( 'pagename' ) ) 
        ) {
          $term                 = get_term_by( 'slug', get_query_var( RHSWP_CT_DOSSIER ), RHSWP_CT_DOSSIER );
          $standaardpaginanaam  = $term->name;       
      }
      
    }
    elseif ( RHSWP_CPT_EVENT == $posttype && 'single' == $loop ) {
      return;
      
    }
    elseif ( 'category' == $loop ) {
      return;
      
    }
    elseif ( 'tag' == $loop ) {
      return;
      
    }
    elseif ( 'tax' == $loop ) {

      if ( is_tax( RHSWP_CT_DOSSIER ) ) {
        $currentID    = get_queried_object()->term_id;
        $term         = get_term( $currentID, RHSWP_CT_DOSSIER );
        $standaardpaginanaam =  $term->name;       
      }

    }
    else {

      if ( is_singular( 'page' ) || ( is_singular( 'post' ) && ( isset($wp_query->query_vars['category_name'] ) ) && ( get_query_var( RHSWP_CT_DOSSIER ) ) ) ) {
        
        // get the dossier for pages OR for posts for which a context was provided
        
        $currentID    = $post->ID;
        $terms        = get_the_terms( $currentID , RHSWP_CT_DOSSIER );
        $parentID     = wp_get_post_parent_id( $post->ID );
        $parent       = get_post( $parentID );
        
        if ($terms && ! is_wp_error( $terms ) ) { 
          $term             = array_pop($terms);
          $standaardpaginanaam =  $term->name;       
        }
        
        if ( is_single() && 'post' == $posttype ) {
          dodebug('ja, is single en post');
        }
      }
      else {
        dodebug('ja, is single en post maar geen cat noch dossier');
      }
    }    



    // dossiercontext tonen als
    // er een taxonomie bekend is en het geen archief is
    if ( $term && ( 'archive' !== $loop ) ) { 
      $dossierinhoudpagina = '';

      $args['theterm'] = $term->term_id;
  
      echo '<div class="dossier-overview"><div class="wrap">'; 

      if ( function_exists( 'get_field' ) ) {

        $dossier_overzichtpagina  = get_field('dossier_overzichtpagina', $term );
        $menu_voor_dossier        = get_field('menu_pages', $term );

        $itemsinmenu   = [];

        if ( is_object( $dossier_overzichtpagina ) ) {
          $itemsinmenu[] = $dossier_overzichtpagina->ID;
        }

        // als een menu is ingevoerd, sorteer de pagina's
        if ( $menu_voor_dossier ) {

          if ( is_array( $menu_voor_dossier ) ) {
            if ( 'string' == gettype( $menu_voor_dossier[0] ) ) {
              // a string, so we best unserialize it.
              $menu_voor_dossier = maybe_unserialize( $menu_voor_dossier[0] ); // serialize
              foreach( $menu_voor_dossier as $menuitem ): 
                $itemsinmenu[] = intval( $menuitem );
              endforeach; 
            }
            else {
              foreach( $menu_voor_dossier as $menuitem ): 
                // this is an object
                $itemsinmenu[] = intval( $menuitem->ID );
              endforeach; 
            }
          }

          $args['menu_voor_dossier'] = $itemsinmenu;

        }

        $titletag_start           = '<p class="taxonomy-title">';
        $titletag_end             = '</p>';

        if ( $dossier_overzichtpagina ) {
          // de overzichtspagina is bekend

          // check of we deze pagina wel of niet nu al moeten tonen
          $tonen  = get_field('toon_overzichtspagina_in_het_menu', $term );

          $parentID     = is_object( $dossier_overzichtpagina ) ? $dossier_overzichtpagina->ID : 0;

          if ( $tonen !== 'nee' ) {
            // we mogen de inhoudspagina tonen

            $shownalready = is_object( $dossier_overzichtpagina ) ? $dossier_overzichtpagina->ID : 0;
            $parentID     = is_object( $dossier_overzichtpagina ) ? $dossier_overzichtpagina->ID : 0;
            $args['dossier_overzichtpagina'] = is_object( $dossier_overzichtpagina ) ? $dossier_overzichtpagina->ID : 0;

            if ( is_tax( RHSWP_CT_DOSSIER ) ) {
              $args['currentpageid'] = $term->term_id;
            }
            else {
            }            

            $args['preferedtitle'] = _x( 'Inhoud', 'Standaardlabel voor het 2de item in het dossiermenu', 'wp-rijkshuisstijl' );
            $subpaginas .= rhswp_dossier_get_pagelink( $dossier_overzichtpagina, $args );

          }
          
        }

        // reset the page title
        $args['preferedtitle'] = '';
        
        if ( is_tax( RHSWP_CT_DOSSIER ) ) {
          // dit is de pagina met informatie over het dossier

          $args['currentpageid'] = $term->term_id;

          $dossierinhoudpagina = '<li class="selected case1"><span>' .  _x( 'Overzicht', 'Standaardlabel voor het menu in de dossiers', 'wp-rijkshuisstijl' ) . '</span></li>';

        }        
        else {
          // dit is een andere pagina, 
          $args['currentpageid'] = get_the_id();

          $dossierinhoudpagina = '<li><a href="' . get_term_link( $term ) . '">' . _x( 'Overzicht', 'Standaardlabel voor het menu in de dossiers', 'wp-rijkshuisstijl' ) . '</a></li>';

        }

    		$headline        =  wp_strip_all_tags( get_term_meta( $term->term_id, 'headline', true ) );

        // Use term name if empty
        if( empty( $headline ) ) {
        	$term = get_term_by( 'term_taxonomy_id', $term->term_id );
        	$headline = $term->name;
        }
        else {
          if ( is_array( $headline ) ) {
            if ( 'string' == gettype( $headline[0] ) ) {
              $headline = $term->name . ' - ' . $headline[0];
            }
            else {
              $headline = $standaardpaginanaam;
            }
          }
          else {
            if ( 'Array' !== $headline ) {
              $headline = $term->name . ' - ' . $headline;
            }
            else {
              $headline = $term->name;
            }
          }
        }

        if ( is_tax( RHSWP_CT_DOSSIER ) ) {
          $titletag_start           = '<h1 class="taxonomy-title">';
          $titletag_end             = '</h1>';
        }        
        
        echo $titletag_start . $headline . $titletag_end; 


        // alle pagina's in dit dossier ophalen
        
        $paginas = '';
        
        $args = array(
          'post_type' => 'page',
          'tax_query' => array(
            array(
              'taxonomy' => RHSWP_CT_DOSSIER,
              'field'    => 'term_id',
              'terms'    => $term->term_id,
            ),
          ),
        );
        
        $pages_for_dossier = new WP_query();
        $pages_for_dossier->query($args);
        
        if ( $pages_for_dossier->have_posts() ) {

          while ($pages_for_dossier->have_posts()) : $pages_for_dossier->the_post();
            $paginas .= '<li><a href="' . get_permalink( ) . '">' . get_the_title( ) . '</a></li>';
          endwhile;

        }

        
        if ( $menu_voor_dossier ) {

          foreach( $menu_voor_dossier as $menuitem ): 
            if ( is_object( $menuitem ) ) {
                if ( ( $parentID !== $menuitem->ID ) && ( $shownalready !== $menuitem->ID ) )  {
                  $subpaginas .= rhswp_dossier_get_pagelink( $menuitem, $args );
                }
            }
          endforeach; 
          
//          $subpaginas .= $paginas;
            
        }
        else {

          if ( $parentID ) {

            $user = wp_get_current_user();
            if ( in_array( 'manage_categories', (array) $user->allcaps ) ) {
              echo '<p style="padding: .2em .5em; background: red; color: white;"><strong>Er is nog geen menu ingevoerd voor dit dossier.</strong><br>Dit menu toont nu de directe pagina\'s onder de pagina "<a href="' . get_permalink( $parentID ) . '" style="color: white;">' . get_the_title( $parentID ) . '</a>"</p>';
            }  

            $argspages = array( 
              'child_of'      => $parentID, 
              'parent'        => $parentID,
              'hierarchical'  => 1,
              'sort_column'   => 'menu_order', 
              'sort_order'    => 'asc'
            );
            $pages = get_pages($argspages); 
            
            if ( $pages ) {
              foreach ( $pages as $page ) {
                if ( ( $parentID !== $page->ID ) && ( $shownalready !== $page->ID ) )  {
                  $subpaginas .= rhswp_dossier_get_pagelink( $page, $args );
                }
              }
            }
          }
          else {
            dodebug( "Geen menu bekend en ook geen parent ID. Haal alle pagina's op uit dit dossier" );

            $subpaginas .= $paginas;
            
          }
        }

        // check for posts -------------------------------------------------------------------------------
        $args = array(
            'post_type'       => 'post',
            'post_status'     => 'publish',
            'posts_per_page'  => -1,
            'tax_query'       => array(
              'relation'      => 'AND',
              array(
                'taxonomy'    => RHSWP_CT_DOSSIER,
                'field'       => 'term_id',
                'terms'       => $term->term_id
              ),
            )
          );

        $wp_queryposts = new WP_Query( $args );

        if ( $wp_queryposts->post_count > 0 ) {

          // er zijn niet meer dan 10 berichten
          $berichten  = sprintf( _n( 'Er is %s bericht', 'Er zijn %s berichten', $wp_queryposts->post_count, 'wp-rijkshuisstijl' ), $wp_queryposts->post_count );      
          $titel      = sprintf( __( '%s voor het dossier %s.', 'wp-rijkshuisstijl' ), $berichten, $term->name );      
          $threshold  = get_field('dossier_post_overview_categor_threshold', 'option');

          // zijn er meer dan XX berichten in dit dossier? Dan checken of we aparte categorieen moeten tonen
          if ( intval( $wp_queryposts->post_count ) >= intval( $threshold ) ) {

            $categories = get_field('dossier_post_overview_categories', 'option' );
            
            if ( $categories ) {

              dodebug('We gaan de loop in.');
                // er zijn categorieen ingesteld, dus deze categorieen aflopen en een link maken
              foreach ( $categories as $category ) {
      
                $theterm = get_term( $category, 'category' );

                $args = array(
                    'post_type'       => 'post',
                    'post_status'     => 'publish',
                    'posts_per_page'  => -1,
                    'tax_query'       => array(
                      'relation'      => 'AND',
                      array(
                        'taxonomy'    => RHSWP_CT_DOSSIER,
                        'field'       => 'term_id',
                        'terms'       => $term->term_id
                      ),
                      array(
                        'taxonomy'  => 'category',
                        'field'     => 'slug',
                        'terms'     => $theterm->slug,
                      ),
        
                    )
                  );
                $wp_queryposts = new WP_Query( $args );

                if ( $wp_queryposts->post_count > 0 ) {
  
                  $berichten  = sprintf( _n( 'Er is %s bericht', 'Er zijn %s berichten', $wp_queryposts->post_count, 'wp-rijkshuisstijl' ), $wp_queryposts->post_count );      
                  $titel      = sprintf( __( '%s voor het dossier %s en categorie %s.', 'wp-rijkshuisstijl' ), $berichten, $term->name, $theterm->name );      
                  $isselected = '';
                  
                  if ( trailingslashit( $current_url ) === trailingslashit( get_term_link( $term->term_id, RHSWP_CT_DOSSIER ) . RHSWP_DOSSIERCONTEXTPOSTOVERVIEW . '/' . RHSWP_DOSSIERCONTEXTCATEGORYPOSTOVERVIEW . '/' . $theterm->slug ) ) {
                    $isselected = ' class="selected"';
                  }
        
                  $subpaginas .= '<li' . $isselected . '><a href="' . get_term_link( $term->term_id, RHSWP_CT_DOSSIER ) . RHSWP_DOSSIERCONTEXTPOSTOVERVIEW . '/' . RHSWP_DOSSIERCONTEXTCATEGORYPOSTOVERVIEW . '/' . $theterm->slug . '/" title="' . $titel . '">' . $theterm->name  . '</a></li>';
        
              
              
                } 
                
              } 
            
            } 
            else {
              // er zijn geen categorieen ingesteld

              $isselected = '';
              if ( trailingslashit( $current_url ) === trailingslashit( get_term_link( $term->term_id, RHSWP_CT_DOSSIER ) . RHSWP_DOSSIERCONTEXTPOSTOVERVIEW ) ) {
                $isselected = ' class="selected"';
              }
    
              $subpaginas .= '<li' . $isselected . '><a href="' . get_term_link( $term->term_id, RHSWP_CT_DOSSIER ) . RHSWP_DOSSIERCONTEXTPOSTOVERVIEW . '/" title="' . $titel . '">' . _x( 'Berichten', 'Linktekst in dossiermenu', 'wp-rijkshuisstijl' )  . '</a></li>';
              
              
            }           
          }
          else {

            // te weinig berichten om ze op te delen in aparte categorieen
            $isselected = '';
            if ( trailingslashit( $current_url ) === trailingslashit( get_term_link( $term->term_id, RHSWP_CT_DOSSIER ) . RHSWP_DOSSIERCONTEXTPOSTOVERVIEW ) ) {
              $isselected = ' class="selected"';
            }
  
            $subpaginas .= '<li' . $isselected . '><a href="' . get_term_link( $term->term_id, RHSWP_CT_DOSSIER ) . RHSWP_DOSSIERCONTEXTPOSTOVERVIEW . '/" title="' . $titel . '">' . _x( 'Berichten', 'Linktekst in dossiermenu', 'wp-rijkshuisstijl' )  . '</a></li>';
            
            

          }

        }


        // check for documents ---------------------------------------------------------------------------
        $args = array(
          'post_type'       => RHSWP_CPT_DOCUMENT,
          'post_status'     => 'publish',
          'posts_per_page'  => -1,
          'tax_query'       => array(
            'relation'      => 'AND',
            array(
              'taxonomy'    => RHSWP_CT_DOSSIER,
              'field'       => 'term_id',
              'terms'       => $term->term_id
            )
          )
        );
    
            
        $wp_queryposts = new WP_Query( $args );
      
        if ( $wp_queryposts->post_count > 0 ) {

          $berichten  = sprintf( _n( 'Er is %s document', 'Er zijn %s documenten', $wp_queryposts->post_count, 'wp-rijkshuisstijl' ), $wp_queryposts->post_count );      
          $titel      = sprintf( __( '%s voor het dossier %s.', 'wp-rijkshuisstijl' ), $berichten, $term->name );      

          $isselected = '';
          if ( trailingslashit( $current_url ) === trailingslashit( get_term_link( $term->term_id, RHSWP_CT_DOSSIER ) . RHSWP_DOSSIERCONTEXTDOCUMENTOVERVIEW ) ) {
            $isselected = ' class="selected"';
          }

          $subpaginas .= '<li' . $isselected . '><a href="' . get_term_link( $term->term_id, RHSWP_CT_DOSSIER ) . RHSWP_DOSSIERCONTEXTDOCUMENTOVERVIEW . '/">' . _x( 'Documenten', 'Linktekst in dossiermenu', 'wp-rijkshuisstijl' )  . '</a></li>';

        }
        

        // check for events ------------------------------------------------------------------------------
        if (class_exists('EM_Events')) {

          $eventargs        = array( RHSWP_CT_DOSSIER => $term->slug, 'scope'=>'future' );
          $eventlist        = EM_Events::output( $eventargs );
          $listitemcounter  = substr_count( $eventlist, '<li'); // 2

          if ( ( intval( $listitemcounter ) < 1 )
          
            || $eventlist == get_option ( 'dbem_no_events_message' )
            || $eventlist == get_option ( 'dbem_location_no_events_message' )
            || $eventlist == get_option ( 'dbem_category_no_events_message' )
            || $eventlist == get_option ( 'dbem_tag_no_events_message' ) ) {
              
            // no events
            
          }
          else {
            // some events
            $isselected = '';
            if ( trailingslashit( $current_url ) === trailingslashit( get_term_link( $term->term_id, RHSWP_CT_DOSSIER ) . RHSWP_DOSSIERCONTEXTEVENTOVERVIEW ) ) {
              $isselected = ' class="selected"';
            }

            $subpaginas .= '<li' . $isselected . '><a href="' . get_term_link( $term->term_id, RHSWP_CT_DOSSIER ) . RHSWP_DOSSIERCONTEXTEVENTOVERVIEW . '/">' . _x( 'Evenementen', 'Linktekst in dossiermenu', 'wp-rijkshuisstijl' )  . '</a></li>';

          }
          
        }

      } // get_field() exists


      if ( $dossierinhoudpagina || $subpaginas ) {
        if ( $tellertje > 1 ) {
          echo '<p class="screen-reader-text">';
          echo sprintf( __( 'Dit dossier bevat %s items.', 'wp-rijkshuisstijl' ), $tellertje );
          echo '</p>';
        }

//        echo '<nav class="collapsible"><ul class="tabs">' . $dossierinhoudpagina  .  $subpaginas . '</ul></nav>';     
        echo '<nav><ul>' . $dossierinhoudpagina  .  $subpaginas . '</ul></nav>';    
      }
  
      echo '</div>';
      echo '</div>';
    }
  }

}

//========================================================================================================

function rhswp_dossier_get_pagelink( $theobject, $args ) {


  global $tellertje;
  
  $tellertje++;
  $childpages   = [];

  if ( isset( $args['currentpageid'] ) && $args['currentpageid'] ) {
    $pagerequestedbyuser = $args['currentpageid'];
  }
  else {
    $pagerequestedbyuser = get_the_id();
  }

  // use alternative title? 
  if ( isset( $args['preferedtitle'] ) && $args['preferedtitle'] ) {
    $maxposttitle = $args['preferedtitle'];
  }
  else {
    $maxposttitle = $theobject->post_title;
  }

  if ( isset( $args['maxlength'] ) && $args['maxlength'] ) {
    $maxlength = $args['maxlength'];
  }
  else {
    $maxlength = 50;
  }
  

  if ( strlen( $maxposttitle ) > $maxlength ) {
    $maxposttitle = substr( $maxposttitle, 0, $maxlength) . ' (...)';
  }

  $current_menuitem_id = isset( $theobject->ID  ) ? $theobject->ID : 0;

  $pagetemplateslug = basename( get_page_template_slug( $current_menuitem_id ) );

  $selectposttype = '';
  $checkpostcount = false;
  $addlink        = false;

  // IS GEPUBLICEERD?
  $poststatus = get_post_status( $current_menuitem_id );

  if ( 'page_dossiersingleactueel.php' == $pagetemplateslug ) {
    $selectposttype = 'post';
    $checkpostcount = true;
  }    
  elseif ( 'page_dossier-document-overview.php' == $pagetemplateslug ) {
    $selectposttype = RHSWP_CPT_DOCUMENT;
    $checkpostcount = true;
  }    
  elseif ( 'page_dossier-events-overview.php' == $pagetemplateslug ) {
    $selectposttype = RHSWP_CPT_EVENT;
    $checkpostcount = true;
  }    
  else {
    $selectposttype = '';
    $checkpostcount = false;
    $addlink        = true;    
  }

  if ( $poststatus != 'publish' ) {
    $addlink        = false;    
  }

  if ( $checkpostcount && $selectposttype ) {
    
    if ( $selectposttype == 'pagina-met-onderliggende-paginas' ) {

      $args = array( 
        'child_of'      => $current_menuitem_id, 
        'parent'        => $current_menuitem_id,
        'hierarchical'  => 0,
        'sort_column'   => 'menu_order', 
        'sort_order'    => 'asc'
      );
      $mypages = get_pages( $args );

      if ( count( $mypages ) > 0 ) {
        $addlink = true;

        // we have child pages. Save this for checking if we are displaying any of its parents
        foreach( $mypages as $childpage ): 
          $childpages[] = $childpage->ID;
        endforeach;

      }

    }
    else {

      if ( function_exists( 'get_field' ) ) {
        $filter    = get_field('wil_je_filteren_op_categorie_op_deze_pagina', $current_menuitem_id );
        $filters   = get_field('kies_de_categorie_waarop_je_wilt_filteren', $current_menuitem_id );
      }

      $argsquery = array(
        'post_type' => $selectposttype,
        'tax_query' => array(
          'relation' => 'AND',
          array(
            'taxonomy' => RHSWP_CT_DOSSIER,
            'field' => 'term_id',
            'terms' => $args['theterm']
          )
        )
      );

      if ( RHSWP_CPT_EVENT == $selectposttype ) {
        if (class_exists('EM_Events')) {
          $eventlist =  EM_Events::output(     array( RHSWP_CT_DOSSIER  => $args['theterm'] ) );
          if ( $eventlist == get_option ( 'dbem_no_events_message' ) ) {
            // er zijn dus geen evenementen
            $addlink = false;
          }
          else {
            $addlink = true;
          }
        }
      }    
      else {
    
        if ( $filter !== 'ja' ) {
          // no filtering, no other arguments needed
        }
        else {
          // yes! Do filtering
    
          if ( $filters ) {
          
            $slugs = array();
            
            foreach( $filters as $filter ): 
              $terminfo = get_term_by( 'id', $filter, 'category' );
              $slugs[] = $terminfo->slug;
            endforeach;
    
            $argsquery = array(
              'post_type' => $selectposttype,
              'tax_query' => array(
              'relation'  => 'AND',
                  array(
                    'taxonomy'  => RHSWP_CT_DOSSIER,
                    'field'     => 'term_id',
                    'terms'     => $args['theterm']
                  ),
                  array(
                    'taxonomy'  => 'category',
                    'field'     => 'slug',
                    'terms'     => $slugs,
                  )
                )
              );
          }
        }
  
        $wp_query = new WP_Query( $argsquery );
      
        if( $wp_query->have_posts() ) {
          if ( $wp_query->post_count > 0 ) {
            $addlink = true;
          }
        }
      }
    }
  }
  else {
    // no $checkpostcount, no special page templates
  }


  // haal de ancestors op voor de huidige pagina
  $ancestors = get_post_ancestors( $pagerequestedbyuser );


  // check of the parent niet al ergens in het menu voorkomt  
  $postparent =  wp_get_post_parent_id( $pagerequestedbyuser );

  $komtvoorinderestvanmenu_en_isnietdehuidigepagina = false;

  if ( isset( $args['menu_voor_dossier'] ) && is_array( $args['menu_voor_dossier'] ) ) {
    
    if ( in_array( $pagerequestedbyuser, $args['menu_voor_dossier'] )  ) {
      // de gevraagde pagina komt voor in het menu

      if ( in_array( $postparent, $args['menu_voor_dossier'] )  ) {
        $komtvoorinderestvanmenu_en_isnietdehuidigepagina = true;
      }
    }
  }

  if ( 
    ( RHSWP_DOSSIERCONTEXTPOSTOVERVIEW == get_query_var( 'pagename' ) ) ||
    ( RHSWP_DOSSIERCONTEXTEVENTOVERVIEW == get_query_var( 'pagename' ) ) ||
    ( RHSWP_DOSSIERCONTEXTDOCUMENTOVERVIEW == get_query_var( 'pagename' ) ) 
    ) {
    $komtvoorinderestvanmenu_en_isnietdehuidigepagina = true;
  }

  if ( $pagerequestedbyuser == $current_menuitem_id ) {
    // the user asked for this particular page / post
    return '<li class="selected"><span>' . $maxposttitle . '</span></li>';
  }
  else {
    // this is not the currently active page

    if ( $addlink ) {
      // so we should show the link

      if ( isset( $args['markerforclickableactivepage'] ) && $args['markerforclickableactivepage'] == $current_menuitem_id ) {
        // this is requested page itself
        return '<li class="selected"><a href="' . get_permalink( $current_menuitem_id ) . '">' . $maxposttitle . '</a></li>';
      }

      elseif ( $current_menuitem_id && $args['dossier_overzichtpagina'] && in_array( $current_menuitem_id, $ancestors ) && ( $args['dossier_overzichtpagina'] !=  $current_menuitem_id ) ) {
        // user requested a page that is a child of the current menu item
        return '<li class="selected"><a href="' . get_permalink( $current_menuitem_id ) . '">' . $maxposttitle . '</a></li>';
      }

      elseif ( wp_get_post_parent_id( $pagerequestedbyuser ) ==  $current_menuitem_id && ( ! $komtvoorinderestvanmenu_en_isnietdehuidigepagina ) ) {
        // this is the direct parent of the requested page
        return '<li class="selected"><a href="' . get_permalink( $current_menuitem_id ) . '">' . $maxposttitle . '</a></li>';
      }
      

      elseif ( in_array( $pagerequestedbyuser, $childpages ) ) {
        // this is a child of the current menu item
        return '<li class="selected"><a href="' . get_permalink( $current_menuitem_id ) . '">' . $maxposttitle . '</a></li>';
      }

      else {
        // this menu item should be clickable
        return '<li><a href="' . get_permalink( $current_menuitem_id ) . '">' . $maxposttitle . '</a></li>';
      }  
    }
  }

}

//========================================================================================================
