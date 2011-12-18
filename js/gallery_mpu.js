jQuery(document).ready(function($){
	settings.adHeight = $(settings.mpuReplace).innerHeight();
	$(settings.mpuReplace).hide();	
	/**
	 * Insert an MPU adjacent to the gallery in the righthand sidebar
	 */
	settings.galleryInsertMPU = function() {
	  // loop through all the righthand sidebar blocks
	  $(settings.sidebarElement).each( 
	    function(index) {
	      // get the position of the top of the gallery
	      var galleryOff = $('#contentleft').offset().top + $('.galleryformatter-view-full').offset().top;
	      // get the position of the top of the current block
	      var blockOff = $(this).offset().top + $('#sidebar').offset().top;
	      var difference = Math.round(galleryOff - blockOff);
		  var galleryDiff = (difference  - $(this).outerHeight());
		  // force gallery and mpu into place when gallery position is above bottom of first block. 
		  var buffer = 0;
	      // see if the bottom of the current block is above the top of the gallery
	      if (galleryDiff < buffer) {
	        if ((index - 1) > 0) {
	          // add bottom margin to the block above the current one to make it line up with the gallery
	          var mb = $($('#sidebar ul .block')[index - 1]).css('margin-bottom');
	          $($(settings.sidebarElement)[index - 1]).css('margin-bottom', parseFloat(mb) + difference);
	        } else if ((index - 1) == 0) {
	          // this is the top block so add margin to the top of this block to make it line up 
	          $(settings.sidebarElement).css('padding-top', difference);
	        } 
	        // insert a new gallery mpu in the sidebar before the current block
	        $(this).after('<div id="dart-tag-gallery-mpu" class="block clearfix"><iframe id="adframe" src="' + settings.ad_iframe + '?' + settings.dart_keywords + '&tagpath=' + settings.tagpath + '" width="300" height="' + settings.adHeight + '" frameBorder="0" scrolling="no"></iframe></div>');
		
	        return false;     
	      } 
	    }
	  );
	}
	/**
	 * Refresh MPU when slide is advanced
	 */
	settings.galleryRefreshMPU = function() {	
		$('#dart-tag-gallery-mpu').replaceWith('<div id="dart-tag-gallery-mpu" class="block clearfix"><iframe id="adframe" src="' + settings.ad_iframe + '?' + settings.dart_keywords + '&tagpath=' + settings.tagpath + '" width="300" height="' + settings.adHeight + '" frameBorder="0" scrolling="no"></iframe></div>');
		$('#dart-tag-gallery-mpu').css({
			'height' : $('#adframe').contents().find('body').innerHeight()
		});
	}
});