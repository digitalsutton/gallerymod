<?php

$futureus_settings = array(

	//GA Account
	'google_analytics_id' => 'UA-8645132-1', 
	
	//Choose an existing shortcode to replace.
	'replace_shortcode' => 'imagebrowser', 
	
	//enable link to full image
	'link_to_full' => 1, 
	
	//fixed width of the whole gallery box. Probably don't want to change this.
	'full_gallery_width' => 580, 
	
	//theme directory
	'theme' => 'ga',

	//enable ad refresh
	'refresh_mpu' => 1,
	
	//Selector id of the ad we are replacing with a refreshing ad
	'mpuReplace' => '.gallery #mpu', 
	
	//The main div ID of the main content area - usually something like "content".
	'contentElement' => '#content',

	//class applied to all 'div' elements in the main sidebar. Change here OR add '.block' class to blocks in your theme
	'sidebarElement' => '#sidebar .block', 
	
	//The ad is placed dynamically. If the ad is falling too far down, set to before. If too high, try setting to abstract 
	'beforeOrAfter' => 'before',
	
	//ad iframe template. Don't change
	'ad_iframe_template' => '/wp-content/plugins/nextgen-futureus-gallery/ad_iframe.php', 
	
	//The dart tag used for the refreshable ad. Keywords are auto inserted if the article is tagged.
	'dart_tags' => 'fut.us.guitaraficionado/homepage;dcopt=ist;tile=1;sz=300x600', 
	
);

