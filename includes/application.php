<?php



require_once FUTUREUS_SLIDER_PLUGIN_DIR . '/includes/ngg-defaults.php';

// This code will work.
register_activation_hook(FUTUREUS_SLIDER_PLUGIN_DIR . '/nextgen-futureus-gallery.php', 'futureus_activated');
register_deactivation_hook(FUTUREUS_SLIDER_PLUGIN_DIR . '/nextgen-futureus-gallery.php', 'futureus_deactivated');


function futureus_activated() {
   futureusngg_default_options();
}

function futureus_deactivated() {
  original_ngg_default_options();
}


require_once FUTUREUS_SLIDER_PLUGIN_DIR . '/includes/simpleimage.php';
require_once FUTUREUS_SLIDER_PLUGIN_DIR . '/includes/image-process.php';
require_once FUTUREUS_SLIDER_PLUGIN_DIR . '/includes/hooked-on-drupal.php';
require_once FUTUREUS_SLIDER_PLUGIN_DIR . '/includes/functions.php';
require_once FUTUREUS_SLIDER_PLUGIN_DIR . '/includes/gallery-process.php';



//Override image resize actions
add_action('wp_ajax_ngg_ajax_operation', 'futureus_ajax_operation');

//Find and replace imagegallery codes with futureus.
add_filter('the_content', 'convert_imagebrowser_shortcode');
add_shortcode( 'futureusgallery', 'futureusgallery_shortcode_handler' );
  
if ( !is_admin() ) {

	add_action('wp_print_styles', 'futureusgallery_remove_nextgen_gallery_styles');
	add_action( 'init', 'FUTUREUS_SLIDER_enqueue_styles' );
	add_action( 'init', 'FUTUREUS_SLIDER_enqueue_scripts' );
	add_action( 'init', 'FUTUREUS_SLIDER_register_scripts' );
	add_action( 'wp_footer', 'FUTUREUS_SLIDER_print_scripts' );  
}

add_action('ngg_added_new_image','futureusuploadsngg',99);

add_action( 'widgets_init', create_function('', 'return register_widget("FUTUREUS_NGG_JQuery_Slider");') );



