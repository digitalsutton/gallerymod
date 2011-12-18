<?php

/**
 * Setup the default option array for the gallery
 */

function futureusngg_default_options() {
	
	global $blog_id, $ngg;

	$ngg_options['gallerypath']			= 'wp-content/gallery/';  		// set default path to the gallery
	$ngg_options['deleteImg']			= true;							// delete Images
	$ngg_options['swfUpload']			= true;							// activate the batch upload
	$ngg_options['usePermalinks']		= false;						// use permalinks for parameters
    $ngg_options['permalinkSlug']		= 'nggallery';                  // the default slug for permalinks
    $ngg_options['graphicLibrary']		= 'gd';							// default graphic library
	$ngg_options['imageMagickDir']		= '/usr/local/bin/';			// default path to ImageMagick
	$ngg_options['useMediaRSS']			= false;						// activate the global Media RSS file
	$ngg_options['usePicLens']			= false;						// activate the PicLens Link for galleries
	
	// Tags / categories
	$ngg_options['activateTags']		= false;						// append related images
	$ngg_options['appendType']			= 'tags';						// look for category or tags
	$ngg_options['maxImages']			= 7;  							// number of images toshow
	
	// Thumbnail Settings
	$ngg_options['thumbwidth']			= 128;  						// Thumb Width
	$ngg_options['thumbheight']			= 72;  							// Thumb height
	$ngg_options['thumbfix']			= true;							// Fix the dimension
	$ngg_options['thumbquality']		= 100;  						// Thumb Quality
		
	// Image Settings
	$ngg_options['imgWidth']			= 580;  						// Image Width
	$ngg_options['imgHeight']			= 420;  						// Image height
	$ngg_options['imgQuality']			= 100;							// Image Quality
	$ngg_options['imgBackup']			= true;							// Create a backup
	$ngg_options['imgAutoResize']		= true;						// Resize after upload
	
	// Gallery Settings
	$ngg_options['galImages']			= '0';		  					// Number of images per page
	$ngg_options['galPagedGalleries']	= 0;		  					// Number of galleries per page (in a album)
	$ngg_options['galColumns']			= 0;							// Number of columns for the gallery
	$ngg_options['galShowSlide']		= false;							// Show slideshow
	$ngg_options['galTextSlide']		= __('[Show as slideshow]','nggallery'); // Text for slideshow
	$ngg_options['galTextGallery']		= __('[Show picture list]','nggallery'); // Text for gallery
	$ngg_options['galShowOrder']		= 'gallery';					// Show order
	$ngg_options['galSort']				= 'sortorder';					// Sort order
	$ngg_options['galSortDir']			= 'ASC';						// Sort direction
	$ngg_options['galNoPages']   		= true;							// use no subpages for gallery
	$ngg_options['galImgBrowser']   	= false;						// Show ImageBrowser, instead effect
	$ngg_options['galHiddenImg']   		= true;						// For paged galleries we can hide image
	$ngg_options['galAjaxNav']   		= false;						// AJAX Navigation for Shutter effect

	// Thumbnail Effect
	$ngg_options['thumbEffect']			= 'none';  					// select effect
	$ngg_options['thumbCode']			= ''; 

	// CSS Style
	$ngg_options['activateCSS']			= false;							// activate the CSS file


	
	update_option('ngg_options', $ngg_options);

}




//Actual NGG Defaults. Resets to this when this modules is deactivated


function original_ngg_default_options() {
	
	global $blog_id, $ngg;

	$ngg_options['gallerypath']			= 'wp-content/gallery/';  		// set default path to the gallery
	$ngg_options['deleteImg']			= true;							// delete Images
	$ngg_options['swfUpload']			= true;							// activate the batch upload
	$ngg_options['usePermalinks']		= false;						// use permalinks for parameters
    $ngg_options['permalinkSlug']		= 'nggallery';                  // the default slug for permalinks
    $ngg_options['graphicLibrary']		= 'gd';							// default graphic library
	$ngg_options['imageMagickDir']		= '/usr/local/bin/';			// default path to ImageMagick
	$ngg_options['useMediaRSS']			= false;						// activate the global Media RSS file
	$ngg_options['usePicLens']			= false;						// activate the PicLens Link for galleries
	
	// Tags / categories
	$ngg_options['activateTags']		= false;						// append related images
	$ngg_options['appendType']			= 'tags';						// look for category or tags
	$ngg_options['maxImages']			= 7;  							// number of images toshow
	
	// Thumbnail Settings
	$ngg_options['thumbwidth']			= 100;  						// Thumb Width
	$ngg_options['thumbheight']			= 75;  							// Thumb height
	$ngg_options['thumbfix']			= true;							// Fix the dimension
	$ngg_options['thumbquality']		= 100;  						// Thumb Quality
		
	// Image Settings
	$ngg_options['imgWidth']			= 800;  						// Image Width
	$ngg_options['imgHeight']			= 600;  						// Image height
	$ngg_options['imgQuality']			= 85;							// Image Quality
	$ngg_options['imgBackup']			= true;							// Create a backup
	$ngg_options['imgAutoResize']		= false;						// Resize after upload
	
	// Gallery Settings
	$ngg_options['galImages']			= '20';		  					// Number of images per page
	$ngg_options['galPagedGalleries']	= 0;		  					// Number of galleries per page (in a album)
	$ngg_options['galColumns']			= 0;							// Number of columns for the gallery
	$ngg_options['galShowSlide']		= true;							// Show slideshow
	$ngg_options['galTextSlide']		= __('[Show as slideshow]','nggallery'); // Text for slideshow
	$ngg_options['galTextGallery']		= __('[Show picture list]','nggallery'); // Text for gallery
	$ngg_options['galShowOrder']		= 'gallery';					// Show order
	$ngg_options['galSort']				= 'sortorder';					// Sort order
	$ngg_options['galSortDir']			= 'ASC';						// Sort direction
	$ngg_options['galNoPages']   		= true;							// use no subpages for gallery
	$ngg_options['galImgBrowser']   	= false;						// Show ImageBrowser, instead effect
	$ngg_options['galHiddenImg']   		= false;						// For paged galleries we can hide image
	$ngg_options['galAjaxNav']   		= false;						// AJAX Navigation for Shutter effect

	// Thumbnail Effect
	$ngg_options['thumbEffect']			= 'shutter';  					// select effect
	$ngg_options['thumbCode']			= 'class="shutterset_%GALLERY_NAME%"'; 

	// Watermark settings
	$ngg_options['wmPos']				= 'botRight';					// Postion
	$ngg_options['wmXpos']				= 5;  							// X Pos
	$ngg_options['wmYpos']				= 5;  							// Y Pos
	$ngg_options['wmType']				= 'text';  						// Type : 'image' / 'text'
	$ngg_options['wmPath']				= '';  							// Path to image
	$ngg_options['wmFont']				= 'arial.ttf';  				// Font type
	$ngg_options['wmSize']				= 10;  							// Font Size
	$ngg_options['wmText']				= get_option('blogname');		// Text
	$ngg_options['wmColor']				= '000000';  					// Font Color
	$ngg_options['wmOpaque']			= '100';  						// Font Opaque

	// Image Rotator settings 
	$ngg_options['enableIR']		    = false;
    $ngg_options['slideFx']		        = 'fade';
    $ngg_options['irURL']				= '';
	$ngg_options['irXHTMLvalid']		= false;
	$ngg_options['irAudio']				= '';
	$ngg_options['irWidth']				= 320; 
	$ngg_options['irHeight']			= 240;
 	$ngg_options['irShuffle']			= true;
 	$ngg_options['irLinkfromdisplay']	= true;
	$ngg_options['irShownavigation']	= false;
	$ngg_options['irShowicons']			= false;
	$ngg_options['irWatermark']			= false;
	$ngg_options['irOverstretch']		= 'true';
	$ngg_options['irRotatetime']		= 10;
	$ngg_options['irTransition']		= 'random';
	$ngg_options['irKenburns']			= false;
	$ngg_options['irBackcolor']			= '000000';
	$ngg_options['irFrontcolor']		= 'FFFFFF';
	$ngg_options['irLightcolor']		= 'CC0000';
	$ngg_options['irScreencolor']		= '000000';		

	// CSS Style
	$ngg_options['activateCSS']			= true;							// activate the CSS file
	$ngg_options['CSSfile']				= 'nggallery.css';  			// set default css filename
	
	// special overrides for WPMU	
	if (is_multisite()) {
		// get the site options
		$ngg_wpmu_options = get_site_option('ngg_options');
		
		// get the default value during first installation
		if (!is_array($ngg_wpmu_options)) {
			$ngg_wpmu_options['gallerypath'] = 'wp-content/blogs.dir/%BLOG_ID%/files/';
			$ngg_wpmu_options['wpmuCSSfile'] = 'nggallery.css';
			update_site_option('ngg_options', $ngg_wpmu_options);
		}
		
		$ngg_options['gallerypath']  		= str_replace("%BLOG_ID%", $blog_id , $ngg_wpmu_options['gallerypath']);
		$ngg_options['CSSfile']				= $ngg_wpmu_options['wpmuCSSfile'];
	} 
	
	update_option('ngg_options', $ngg_options);

}