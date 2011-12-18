<?php

function FUTUREUS_SLIDER_plugin_url( $path = '' ) {
  return plugins_url( $path, FUTUREUS_SLIDER_PLUGIN_BASENAME );
}

function FUTUREUS_SLIDER_enqueue_scripts() {
  if( !is_admin() ) {
    wp_enqueue_script( 'jquery' );
    wp_dequeue_script( 'wpaudio' );    
  }
} 

function FUTUREUS_SLIDER_register_scripts() {
  if( !is_admin() ) {

	//Fix stupid conflict with wpaudio plugin.
	global $wpa_version;
	if ( !empty($wpa_version) ) {
		if ( WP_DEBUG === false ) {
			wp_deregister_script( 'wpaudio', WPAUDIO_URL . '/wpaudio.min.js', Array('jquery'), $wpa_version, true );
			wp_register_script( 'wpaudio', FUTUREUS_SLIDER_plugin_url( 'wpaudio-fix/wpaudio.js' ), $wpa_version, true  ); 
		}
		else {
			wp_deregister_script( 'wpaudio', WPAUDIO_URL . '/wpaudio.js', Array('jquery'), $wpa_version, true);
			 wp_register_script( 'wpaudio', FUTUREUS_SLIDER_plugin_url( 'wpaudio-fix/wpaudio.js' ), $wpa_version, true  ); 
		}
	}

   //THEME OVERRIDE DIRECTORY
   $custom_theme = 'revolver';
   wp_register_style( 'futureus-theme', FUTUREUS_SLIDER_plugin_url( 'themes/' . $custom_theme . '/gallery.css' ), array(), '', 'all' );

   wp_register_style( 'futureus-scrollpane', FUTUREUS_SLIDER_plugin_url( 'css/jquery.jscrollpane.css' ), array(), '', 'all' );
   wp_register_style( 'futureus-colorbox', FUTUREUS_SLIDER_plugin_url( 'css/colorbox.css' ), array(), '', 'all' );
   
   wp_register_script( 'jquery-colorbox', FUTUREUS_SLIDER_plugin_url( 'js/jquery.colorbox.js' ), array('jquery'), '', false ); 
   wp_register_script( 'jquery-mousewheel', FUTUREUS_SLIDER_plugin_url( 'js/jquery.mousewheel.js' ), array('jquery'), '', false ); 
   wp_register_script( 'jquery-jscrollpane', FUTUREUS_SLIDER_plugin_url( 'js/jquery.jscrollpane.min.js' ), array('jquery'), '', false ); 
   
   wp_register_script( 'jquery-infinite-carousel', FUTUREUS_SLIDER_plugin_url( 'js/infiniteCarousel.js' ), array('jquery'), '', false ); 
   wp_register_script( 'futureus-gallery', FUTUREUS_SLIDER_plugin_url( 'js/futureus.js' ), array('jquery'), '', false );
   wp_register_script( 'gallery-mpu', FUTUREUS_SLIDER_plugin_url( 'js/gallery_mpu.js' ), array('jquery'), '', false ); 

  }
}

function FUTUREUS_SLIDER_print_scripts() {
	global $wpa_version;
	global $add_my_script;
	if ( ! $add_my_script ) {
		return;
	}
	wp_print_styles('futureus-scrollpane');
	wp_print_styles('futureus-colorbox');
	
	wp_print_styles('futureus-theme');
	
	if ( !empty($wpa_version) ) {
		wp_print_scripts('wpaudio');
	}
	
	wp_print_scripts('jquery-colorbox');
	wp_print_scripts('jquery-mousewheel');
	wp_print_scripts('jquery-jscrollpane');
	wp_print_scripts('jquery-infinite-carousel');
	wp_print_scripts('gallery-mpu');
	wp_print_scripts('futureus-gallery');
}

function FUTUREUS_SLIDER_enqueue_styles() {
  if( !is_admin() ) {  
    wp_enqueue_style( 'futureus-gallery-style', FUTUREUS_SLIDER_plugin_url( 'css/futureus-gallery.css' ), array(), '', 'all' );
  }
}


function futureus_tags_for_mpu() {
	$tags = get_the_tags();
	$keywords = array();
	
	if(!empty($tags)) {
		foreach ($tags as $tag) {
			$keywords[] = $tag->name;
		}
	}
	
	$keywords_str = implode(',', $keywords);
	if (!is_array($keywords_str) && !empty($keywords_str)) {
		$kw = 'kw=' . str_replace(',', ';kw=', htmlspecialchars($keywords_str, ENT_QUOTES, 'UTF-8')) . ';';
		return $kw;
	}
}


function FUTUREUS_SLIDER_use_default($instance, $key) {
  return !array_key_exists($key, $instance) || trim($instance[$key]) == '';
}


function futureusgallery_remove_nextgen_gallery_styles() {
	wp_deregister_style('shutter');
	wp_deregister_style('NextGEN');	
}

function convert_imagebrowser_shortcode($content, $oldcode = '') {
	if( empty($oldcode) ) {
		require_once FUTUREUS_SLIDER_PLUGIN_DIR . '/config.php';
		$oldcode = $futureus_settings['replace_shortcode'];
	}
	$shortcode = '[' . $oldcode;
	if ( stristr( $content, $shortcode )) {
		$content = str_replace($shortcode, '[futureusgallery', $content);
	}
	return $content;
}

function futureusgallery_shortcode_handler($atts) {      
  $instance = array();
  foreach($atts as $att => $val) {
    $instance[$att] = $val;
  }
  if(FUTUREUS_SLIDER_use_default($instance, 'id')) { 
  	$instance['id'] = $atts['id']; 
  } 

  ob_start();
  the_widget("FUTUREUS_NGG_JQuery_Slider", $instance, array());
  $output = ob_get_contents();
  ob_end_clean();
  
  return $output;    
}

?>