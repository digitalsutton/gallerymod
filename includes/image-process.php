<?php

/*function that hooks on to ngg's ngg_added_new_image hook, gets the $image array and uses it to resize the image dynamically*/
function futureusuploadsngg($image) {
 	global $wpdb, $ngg;
 	$futureus_nggallery = $wpdb->prefix . 'ngg_gallery';
 	$query = "select * from $futureus_nggallery where gid='".$image['galleryID']."'" ;
 	$results = $wpdb->get_results($query);
	$originals = ABSPATH.$results[0]->path . "/orig";
	if( !is_dir($originals) ) {
		mkdir($originals);
		chmod($originals ,0777);
		
	}
	$file = file_get_contents(ABSPATH.$results[0]->path . "/" . $image['filename']);
	file_put_contents($originals . "/". $image['filename'], $file);
	chmod($originals . "/". $image['filename'] ,0777);
	if ( ($ngg->options['imgBackup'] == true) && (!file_exists($image->imagePath . '_backup')) )
		@copy ($image->imagePath, $image->imagePath . '_backup');
	
 }
 
 
function futureusresizengg(&$image, $width = 0, $height = 0) {
  	global $wpdb, $ngg;
  	
  	chmod(ABSPATH.$image->path ,0777);
  	
  	if ( ($ngg->options['imgBackup'] == true) && (!file_exists($image->imagePath . '_backup')) )
  		@copy ($image->imagePath, $image->imagePath . '_backup');
  	
  	
  	
  	// if no parameter is set, take global settings
  	$width  = ($width  == 0) ? $ngg->options['imgWidth']  : $width;
  	$height = ($height == 0) ? $ngg->options['imgHeight'] : $height;
  	
 	$originals = ABSPATH.$image->path . "/orig";

	if( !is_dir($originals) ) {
		mkdir($originals);
		chmod($originals ,0777);
	}
	$file = file_get_contents($image->imagePath);
	file_put_contents($originals . "/". $image->filename, $file);
	chmod($originals . "/". $image->filename ,0777);
	
	$imageres = new SimpleImage();				
	$imageres->load(ABSPATH.$image->path."/".$image->filename);
	
	if( $imageres->getWidth() < $imageres->getHeight() ) {
		$imageres->resizeToHeight($height);
		$proportion = 'portrait';
	} elseif ( $imageres->getWidth() > $imageres->getHeight() ) {
		$imageres->resizeToWidth($width);
		$proportion = 'landscape';
	}
	
	$imageres->save(ABSPATH.$image->path."/".$image->filename);
	
	
	futureus_image_resize($image->imagePath, $image->imagePath, $width, $height, $proportion);		
	
	chmod(ABSPATH.$image->path."/".$image->filename, 0777);
	
	$size = @getimagesize ( $image->imagePath );
	// add them to the database
	nggdb::update_image_meta($image->pid, array( 'width' => $size[0], 'height' => $size[1] ) );
	if($image->imagePath) {
		return '1';
	}
	die(0);		
			
  }

  



  function futureus_image_resize($src, $dst, $width, $height, $proportion = 'landscape'){
  
  
    if(!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";
  
    $bg = "#000000";     // hex representation of the color (i.e. #ffffff for white)
    $im_X = $width;
    $im_Y = $height;
    
    $img = imagecreatefromstring( file_get_contents($src) );

    $backgroundimage = imagecreatetruecolor($im_X, $im_Y);
    
	$src_width = imageSX($img); 
	$src_height = imageSY($img); 
	$background_width = imageSX($backgroundimage); 
	$background_height = imageSY($backgroundimage); 
    
    $dst_x = ( $background_width / 2 ) - ( $src_width / 2 ); 
   	if($proportion == 'landscape') {
   		$dst_y = ( $background_height / 2 ) - ( $src_height / 2 );
    } else {
    	$dst_y = 0;
    }
    // get the desired backgroundcolor:
    $code = colordecode($bg);
    $backgroundcolor = ImageColorAllocate($backgroundimage, $code[r], $code[g], $code[b]);

    ImageFilledRectangle($backgroundimage, 0, 0, $im_X, $im_Y, $backgroundcolor);
    
  	//ImageAlphaBlending($backgroundimage, true);
    imagecopy($backgroundimage, $img, $dst_x, $dst_y, 0, 0, $im_X, $im_Y);
    
    $type = strtolower(substr(strrchr($src,"."),1));
    switch($type){
        case 'bmp': imagewbmp($backgroundimage, $dst); break;
        case 'gif': imagegif($backgroundimage, $dst); break;
        case 'jpg': imagejpeg($backgroundimage, $dst); break;
        case 'png': imagepng($backgroundimage, $dst); break;
	}
 
    // destroy the memory
    ImageDestroy($backgroundimage);
 	ImageDestroy($img);
  
  	chmod($dst ,0777);
  
    return true;
  }
  
  
  function colordecode($hex){  
     $code[r] = hexdec(substr($hex, 0 ,2));
     $code[g] = hexdec(substr($hex, 2 ,2));
     $code[b] = hexdec(substr($hex, 4 ,2));
     return $code;
  }



/**
 * Copy and override of ngg_ajax_operation
 */
function futureus_ajax_operation() {
	global $wpdb;

	// if nonce is not correct it returns -1
	check_ajax_referer( "ngg-ajax" );
	
	// check for correct capability
	if ( !is_user_logged_in() )
		die('-1');

	// check for correct NextGEN capability
	if ( !current_user_can('NextGEN Upload images') && !current_user_can('NextGEN Manage gallery') ) 
		die('-1');	
	
	// include the ngg function (copied into this plugin dir)
	include_once (dirname (__FILE__) . '/ngg-admin-class.php');

	// Get the image id
	if ( isset($_POST['image'])) {
		$id = (int) $_POST['image'];
		// let's get the image data
		$picture = nggdb::find_image( $id );
		// what do you want to do ?		
		switch ( $_POST['operation'] ) {
			case 'create_thumbnail' :
				$result = nggAdmin::create_thumbnail($picture);
			break;
			case 'resize_image' :
				$result = futureusresizengg($picture);
			break;
			case 'rotate_cw' :
				$result = nggAdmin::rotate_image($picture, 'CW');
				nggAdmin::create_thumbnail($picture);
			break;
			case 'rotate_ccw' :
				$result = nggAdmin::rotate_image($picture, 'CCW');
				nggAdmin::create_thumbnail($picture);
			break;			
			case 'set_watermark' :
				$result = nggAdmin::set_watermark($picture);
			break;
			case 'recover_image' :
				$result = nggAdmin::recover_image($picture);
			break;			
			case 'import_metadata' :
				$result = nggAdmin::import_MetaData( $id );
			break;
			case 'get_image_ids' :
				$result = nggAdmin::get_image_ids( $id );
			break;
			default :
				do_action( 'ngg_ajax_' . $_POST['operation'] );
				die('-1');	
			break;		
		}
		// A success should return a '1'
		die ($result);
	}
	// The script should never stop here
	die('0');
}





  
  