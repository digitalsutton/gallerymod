Futureus NextGen Gallery -- a better gallery for Wordpress.

REQUIEMENTS:

- WP 3.2.1 or higher
- jquery
- NextGen 1.8.4 or higher

INSTALLATION:

- Back up everything. This process will rebuild every image in your gallery and change your database. Just be careful.

- Upload the "nextgen-futureus-gallery" plugin into your WP plugins directory. 

- Before you Activate the plugin, you may want to tweak some settings. They are located in nextgen-futureus-gallery/includes/config.php. An example of that file is pasted below.

- If you are enabling the MPU refresh behavior, you may need to make some minor tweaks to your themes "sidebar" template. If the ad is not positioning itself near the gallery correctly, you may need to add an additional class to SOME of the sidebar div elements. Add the class "block" to any div in the main area of the main sidebar. See included "sidebar.php" file. This shows the sidebar blocks used on the Revolver site. If using the same theme, you may be able to replace as is (but maybe don't do that on a live site).

- Go ahead and activate the Plugin - but BEFORE YOU DO, be aware that the activation will replace all of your current NGGallery settings. 

- If you view a gallery at this time, you will not see pleasing results. The final step is to generate new thumbnails and run a resize:

- Go to Manage Gallery, select as many galleries as you can

- (OPTIONAL)- I recommending doing a "Backup to original" first. If you run this as a bulk operation, you will likely get a failure notice. This is because any image uploaded before enabling this setting probably isn't backed up. No big deal. But it's worth running this first as it will reset any images it DOES know about to their original, large size. 

- Run an operation to "resize images" on all galleries. Leave the width/height settings as is.

- Run an operation to "generate thumbnails" on all galleries. Leave the size settings as they are.

- clear page caches, clear browser cache, then take a look. 

* Before running this on ALL galleries, you might test a gallery or two to make sure the sizes are working for you. You don't want to process them all THEN have to change them all again.



Settings you will find in includes/config.php (YOU MUST CHANGE THAT FILE FOR THEM TO WORK):

	//GA Account
	'google_analytics_id' => 'UA-8316105-1', 
	
	//Choose an existing shortcode to replace.
	'replace_shortcode' => 'imagebrowser', 
	
	//enable link to full image
	'link_to_full' => 1, 
	
	//fixed width of the whole gallery box. Probably don't want to change this.
	'full_gallery_width' => 620, 

	//enable ad refresh
	'refresh_mpu' => 1, 
	
	//Selector id of the ad we are replacing with a refreshing ad
	'mpuReplace' => '.gallery #MPU', 
	
	//class applied to all 'div' elements in the main sidebar. Change here OR add '.block' class to blocks in your theme
	'sidebarElement' => '#sidebar ul .block', 
	
	//ad iframe template. Don't change
	'ad_iframe_template' => '/wp-content/plugins/nextgen-futureus-gallery/ad_iframe.php', 
	
	//The dart tag used for the refreshable ad. Keywords are auto inserted if the article is tagged.
	'dart_tags' => 'fut.us.revolver/article;dcopt=ist;tile=1;sz=300x600;', 


----OTHER POTENTIAL ISSUES

If you have other galleries installed from other plugins and/or themes, you might run into javascript conflicts. You will have to disable the other galleries for Futureus NGG to work. Typically, you can just remove or comment out javascript from the theme file or disable the conflicting plugin. 

Here is an example. If using the Magzimus Theme, Comment out the following lines (starting from around line 53):


//	$(".gallery a").attr('rel', 'gallery');
//	$("a[rel^='gallery']").prettyPhoto({
//				animationSpeed: 'normal', 
//				opacity: 0.75, 
//				showTitle: false, 
//				allowresize: true, 
//				counter_separator_label: '/', 
//				theme: 'dark_rounded', 
//				hideflash: false, 
//				modal: false, 
//				changepicturecallback: function(){}, 
//				callback: function(){} 
//			});	