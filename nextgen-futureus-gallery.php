<?php

/*
Plugin Name: Futureus NextGen Gallery
Depends: nggallery.php
Description: Customized NextGen Gallery for Futureus
Author: Mark Sutton
Version: 1.0

*/

if ( ! defined( 'FUTUREUS_SLIDER_PLUGIN_BASENAME' ) )
	define( 'FUTUREUS_SLIDER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'FUTUREUS_SLIDER_PLUGIN_NAME' ) )
	define( 'FUTUREUS_SLIDER_PLUGIN_NAME', trim( dirname( FUTUREUS_SLIDER_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'FUTUREUS_SLIDER_PLUGIN_DIR' ) )
	define( 'FUTUREUS_SLIDER_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . FUTUREUS_SLIDER_PLUGIN_NAME );


require_once FUTUREUS_SLIDER_PLUGIN_DIR . '/includes/application.php';