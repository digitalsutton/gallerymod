// $Id: infiniteCarousel.js,v 1.1.2.3 2010/10/19 14:54:29 manuelgarcia Exp $

/**
 * Plugin written by the great jqueryfordesigners.com
 * http://jqueryfordesigners.com/jquery-infinite-carousel/
 *
 * Slightly addapted for our use case
 */

jQuery.noConflict();

jQuery(document).ready(function($) {
	 
	$.fn.infiniteCarousel = function () {
		$slides = this.parent().find('.gallery-frame ul.gallery-container');
	
		$id = this.parent().attr('id');
		var $config = settings;
		var $slidesdata = $.parseJSON(settings.slides.replace(/&quot;/g, '"'));
	    function repeat(str, num) {
	        return new Array( num + 1 ).join( str );
	    }
	
	    return this.each(function () {
	
	        var $wrapper = $('> div', this).css('overflow', 'hidden'),
	            $slider = $wrapper.find('> ul'),
	            $items = $slider.find('> li'),
	            $single = $items.filter(':first'),
	
	        	singleWidth = $single.outerWidth(),
	            visible = Math.ceil($wrapper.innerWidth() / singleWidth), // note: doesn't include padding or border
	            currentPage = 1,
	            pages = Math.ceil($items.length / visible);
	
			var $thumbs = $items.find('> a');
	
	        // 1. Pad so that 'visible' number will always be seen, otherwise create empty items
	        if (($items.length % visible) != 0) {
	            $slider.append(repeat('<li class="empty" />', visible - ($items.length % visible)));
	            $items = $slider.find('> li');
	        }
	
	        // 2. Top and tail the list with 'visible' number of items, top has the last section, and tail has the first
	        $items.filter(':first').before($items.slice(- visible).clone().addClass('cloned'));
	        $items.filter(':last').after($items.slice(0, visible).clone().addClass('cloned'));
	        $items = $slider.find('> li'); // reselect
	
	        // 3. Set the left position to the first 'real' item
	        $wrapper.scrollLeft(singleWidth * visible);
	
	        // 4. paging function
	        function gotoPage(page) { 
	            var dir = page < currentPage ? -1 : 1,
	                n = Math.abs(currentPage - page),
	                left = singleWidth * dir * visible * n;

	            $wrapper.filter(':not(:animated)').animate({
	                scrollLeft : '+=' + left
	            }, 500, function () {
	                if (page == 0) {
	                    $wrapper.scrollLeft(singleWidth * visible * pages);
	                    page = pages;
	                } else if (page > pages) {
	                    $wrapper.scrollLeft(singleWidth * visible);
	                    // reset back to start position
	                    page = 1;
	                }
					currentPage = page;
					//	Preload Large Images for smooth transitions
					//	low and high index define the range of items to preload; 
					//  -1 allows for preloading last slide of prev. page in event user is using previous button
					$lowIndex = visible * (currentPage - 1) - 1;
					
					//	+visible number allows for preloading of first slide of next page for users scrolling through with next button. +1 offsets for -1 in low index	
					$highIndex = $lowIndex + visible + 1;	
					for($x=$lowIndex; $x<=$highIndex; $x++) {
						//	check against class so it doesn't repeat unnecessarily
						if ($x<$thumbs.length && $x >= 0 && !$slides.find("img#slide-" + $x + "-" + $id).hasClass('preLoaded')) {	
							var srcId = "slide-" + $x + "-" + $id;
							//new img obj
							var img = new Image(); 
							img.src = $slidesdata[srcId].cached_path;
							$slides.find("img#slide-" + $x + "-" + $id).attr('src',$slidesdata[srcId].cached_path).addClass('preLoaded');
						}
					}
	            });
	            return false;
	        }
	
	        $wrapper.after('<a class="arrow back" title="'+ 'Previous page' +'">&lt;</a><a class="arrow forward" title="'+ 'Next page' +'">&gt;</a>');
	
	        // 5. Bind to the forward and back buttons
	        $('a.back', this).click(function () {
	            return gotoPage(currentPage - 1);
	        });
	
	        $('a.forward', this).click(function () {
	            return gotoPage(currentPage + 1);
	        });
	
	        // create a public interface to move to a specific page
	        $(this).bind('goto', function (event, page) {
	            gotoPage(page);
	        });
	
	        //custom events to trigger next and prev pages
	        $(this).bind('next', function () {
	          gotoPage(currentPage + 1);
	          if (typeof _gaq == 'object' || typeof _gaq == 'function') {
				_gaq.push(['_setAccount', settings.ga_account]);
	    	    _gaq.push(['_trackEvent','ImageGallery','click','Next Thumbs']);
				_gaq.push(['_setAccount', settings.ga_default_account]);
	          }
	        });
	        $(this).bind('prev', function () {
	          gotoPage(currentPage - 1);
	          if (typeof _gaq == 'object' || typeof _gaq == 'function') {
				_gaq.push(['_setAccount', settings.ga_account]);
	    	    _gaq.push(['_trackEvent','ImageGallery','click','Prev Thumbs']);
				_gaq.push(['_setAccount', settings.ga_default_account]);
	          }
	        });
	    });
	};

});