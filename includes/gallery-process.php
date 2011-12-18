<?php

class FUTUREUS_NGG_JQuery_Slider extends WP_Widget {
	
	function FUTUREUS_NGG_JQuery_Slider() {
		$widget_ops = array('classname' => 'galleryformatter', 'description' => "Allows you to pick a gallery from the 'NextGen Gallery' plugin to use as a 'FutureUS Custom Gallery'.");
		$this->WP_Widget('galleryformatter', 'FutureUS Gallery Widget', $widget_ops);
	}
	
	function widget($args, $instance) {
		global $wpdb;
		extract($args);

		//Load the images from the NGG gallery. 	
		$gallery = nggdb::find_gallery( $instance['id'] );
		$picturelist = array_values(nggdb::get_gallery($instance['id'], $ngg_options['galSort'], $ngg_options['galSortDir']));
		
		//get and set global to trigger our primary function
		global $add_my_script;
		$add_my_script = true;
		
		//todo: bring this into the class.
		
		gallery_template($gallery, $picturelist);
	}

	function update($new_instance, $old_instance) {
		$new_instance['title'] = esc_attr($new_instance['title']);
		return $new_instance;
	}
}

	function galleryformatter_getimage_dimensions($ngg_image, $view = 'full') {
		switch ($view) {
			case 'full':
				$image = array(
					'height' => $ngg_image->meta_data['height'],
					'width' => $ngg_image->meta_data['width'],
				);
				break;
			case 'thumb':
				$image = array(
					'height' => $ngg_image->meta_data['thumbnail']['height'],
					'width' => $ngg_image->meta_data['thumbnail']['width'],
				);
				break;
			default:
				break;
		}
		return $image;
	}


	//inspired by theme.inc from galleryformatter module in Drupal
	function gallery_template($gallery, $picturelist) {
		global $ngg;
		$num_of_images = count($picturelist);
				
		foreach ($picturelist as $id => $item) {
			
			$title = rawurlencode(check_plain($item->alttext));
			$description = rawurlencode(check_plain($item->description));
			$filename = $item->filename;
			$filepath = $item->imageURL;
			// Check if alt attribute is already set, if not use the filename as alt attribute
			$alt = (isset($title) && !empty($title)) ? $title : $filename;
			
			// prepare the unique hash id per image
			$slideset_id = 'gallery-' . $item->galleryid;
			$hash_id = 'slide-' . $id  . '-' . $slideset_id;
			$thumb_id = 'slide-' . $id;
			
			$image_size = galleryformatter_getimage_dimensions($item, 'full');
			
			$transp = FUTUREUS_SLIDER_PLUGIN_DIR . '/css/images/bg-trans.png';
			
			// prepare slides without links to colorbox popup (we add those in below if they exist)
			$slides[$hash_id]['image'] = "
					<div class='galwrap' id='"  . $hash_id . "-galwrap'>
					<img src='" . $item->imageURL . "' id='" . $hash_id . "' title='" . $title . "' width='" . $image_size['width'] . "' height='" . $image_size['height'] . "'></div>
				";
								
			$slides[$hash_id]['image_nopath'] =  "
					<div class='galwrap' id='"  . $hash_id . "-galwrap'>
					<img src='" . $item->imageURL . "' id='" . $hash_id . "' title='" . $title . "' width='" . $image_size['width'] . "' height='" . $image_size['height'] . "'></div>
				";
			
			//Retreive title desc and alt and 	
			if(!empty($title)) {
				$slides[$hash_id]['title'] = addslashes($title);
			}
			if(!empty($description)) {
				$slides[$hash_id]['description'] = addslashes($description);
			}
			if(!empty($alt)) {
				$slides[$hash_id]['alt'] = addslashes($alt);
			}
			
			$slides[$hash_id]['filepath'] = $filepath;
			$slides[$hash_id]['hash_id'] = $hash_id;
			$slides[$hash_id]['cached_path'] = $filepath;
			$slides[$hash_id]['filename'] = $filename;
			
			$gallery_style = 'galleryformatter-view-full '; 
	
			//Check for large originial image and display a link to view in colorbox if it exists.
			if( file_exists($gallery->abspath . '/orig/' . $item->filename) ) {
				$large_image_path = get_bloginfo('url') . '/' . $item->path . '/orig/' . $item->filename;
				chmod($large_image_path ,0777);
				$large_size = getimagesize($large_image_path);
				
				$slides[$hash_id]['image'] = "
						<div class='galwrap' id='"  . $hash_id . "-galwrap'><a href='" . $large_image_path . "' class='galimage'><span class='view-full' title='View the full image'>View the full image</span></a>
						<img src='" . $item->imageURL . "' id='" . $hash_id . "' title='" . $title . "' width='" . $image_size['width'] . "' height='" . $image_size['height'] . "'></div>
					";

				$slides[$hash_id]['image_nopath'] = "
						<div class='galwrap' id='"  . $hash_id . "-galwrap'><a href='" . $large_image_path . "' class='galimage'><span class='view-full' title='View the full image'>View the full image</span></a>
						<img src='" . $item->imageURL . "' id='" . $hash_id . "' title='" . $title . "' width='" . $image_size['width'] . "' height='" . $image_size['height'] . "'></div>
					";
						
			} 

			// setup thumbnail images
			if($num_of_images > 1) {
				$thumb_size = galleryformatter_getimage_dimensions($item, 'thumb');
				$thumbs[$id]['image'] = "<img src='" . $item->thumbURL . "' width='" . $thumb_size['width'] . "' height='" . $thumb_size['height'] . "'>";
				$thumbs[$id]['hash_id'] = $thumb_id;
			}
		}
	
		// insert into the variables for the template file
		$gallery_thumbs = $thumbs;
		$gallery_slides = $slides;
		
		$gallery_slide_height = $ngg->options['imgHeight'];
		$gallery_slide_width = $ngg->options['imgWidth'];
		
		if($num_of_images > 1) {
			$gallery_thumb_height = $thumb_size['height'];
			$gallery_thumb_width = $thumb_size['width'];
		}
		$gallery_style .= 'galleryformatter-futureus-gallery';
		
		//include config file
		include FUTUREUS_SLIDER_PLUGIN_DIR . '/config.php';
		
		//Prepare params array for jquery
		$slides_json = json_encode($slides);
		$params = array(
				'slides' => check_plain($slides_json),
				'gallery_title' =>  $slideset_id,
				'gallery_display_title' => check_plain($gallery->title),
				'link_to_full' => $link_to_full,
				'future_imagegallery_rotate_mpu' => $futureus_settings['refresh_mpu'],
				'dart_keywords' => futureus_tags_for_mpu(),
				'ad_iframe' => $futureus_settings['ad_iframe_template'],
				'ga_account' => $futureus_settings['google_analytics_id'],
				'ga_default_account' => $futureus_settings['google_analytics_id'],
				'fullGalleryWidth' => $futureus_settings['full_gallery_width'],
				'mpuReplace' => $futureus_settings['mpuReplace'],
				'tagpath' => $futureus_settings['dart_tags'],
				'sidebarElement' => $futureus_settings['sidebarElement'],
				'wpaudioFix' => $futureus_settings['wpaudio_fix'],
		);
		
		//Really Poormans Drupal 'template'.
		require_once FUTUREUS_SLIDER_PLUGIN_DIR . '/includes/gallery-template.php';
		
		//localize scripts with param values
		wp_localize_script( 'futureus-gallery', 'settings', $params );
		wp_localize_script( 'jquery-infinite-carousel', 'settings', $params );		
	}
	

	