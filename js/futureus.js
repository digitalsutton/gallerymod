//$Id: futureus.js
jQuery.noConflict();

jQuery(document).ready(function($){
	
	if (settings.future_imagegallery_rotate_mpu==1) settings.galleryInsertMPU();
	
	galleryformatter();
	
	function galleryformatter() {
		$('.galleryformatter:not(.gallery-processed)').each(function(){
			prepare(this);
		}).addClass('gallery-processed');
	};
	
	//setup next-prev button overlay behaviors 
	$('div.gallery_prevnext').hide();
	$('.group-gallery').hover(
	  function () {
	    $('div.gallery_prevnext').fadeIn('fast');
	  }, 
	  function () {
	    $('div.gallery_prevnext').fadeOut('fast');
	  }
	);
	
	// setting up the main behaviour
	function prepare(el) {
		
	  var $el = $(el);
	  var $slides = $('li.gallery-slide', $el);
	  var $thumbs = $('.gallery-thumbs', $el);
	  var $thumbsLi = $('li', $thumbs);
	  var thumbWidth = $thumbsLi.filter(':first').width() + 'px';
	  var liWidth = $thumbsLi.outerWidth(); // includes padding
	  var $wrapper = $('.wrapper', $el);
	  var visibleWidth = $wrapper.outerWidth();
	  var $id = $el.attr('id');
	  var $config = settings;
	  var $slidesdata = $.parseJSON(settings.slides.replace(/&quot;/g, '"'));
	  var $gallery_name = settings['gallery_title'];
	  var $gallery_display_title = settings['gallery_display_title'];
 
	  // image-view virtual pageview does not trigger on initial image, only use of the gallery.
	  var $send_pageview = false;	
	 
	  /*
	   * Only start the thumbs carousel if needed
	   */
	  if (($thumbsLi.size() * liWidth) > $thumbs.width()) {
	    $('ul', $thumbs).width('99999px');
	    $thumbs.infiniteCarousel();
	    // we need to reselect because infiniteCarousel inserts new empty li elements if necessary
	    $el = $(el);
	    $thumbsLi = $('.gallery-thumbs ul li', $el);
	  }
	
	  $thumbsLi.each(function(){
	    $(this).css({
	        width: thumbWidth
	      });
	  });
	  var $thumbslinks = $('a', $thumbsLi);
	
	  /*
	   * Bind thumbnail images to show slides using showSlide function
	   */
	  $thumbslinks.click(function(e){
	  	showSlide(this.hash);
	  });
	
	  /*
	   *  Startup behaviour (when the page first loads)
	   */
	  $slides.hide(); // hide all slides
	  if (window.location.hash) {
	  	var slideHashSplit = window.location.hash.split("-");	
	  
	  	//	new preloader to fill in images in secondary "pages"
	  	var currThmb = slideHashSplit[1];
	  	var visible = Math.ceil(visibleWidth / liWidth);


	  	if (currThmb < $thumbsLi.not($(".cloned")).size()) {
	  		if (currThmb >= visible) {
				currentPage = Math.floor(currThmb / visible);
		  				  		
		  		//	low and high index define the range of items to preload; -1 allows for preloading last slide of prev. page in event user is using previous button
				$lowIndex = visible * (currentPage - 1) - 1;
				
				//	+visible number allows for preloading of first slide of next page for users scrolling through with next button. +1 offsets for -1 in low index
				$highIndex = $lowIndex + visible + 1;
				$activeLi = $thumbsLi.not($(".cloned"));
				
				for($x=$lowIndex; $x<=$highIndex; $x++) {
				//	check against class so it doesn't repeat unnecessarily
					if ($x >= 0 && !$slides.find("img#slide-" + $x + "-" + $id).hasClass('preLoaded')) {
						var srcId = "slide-" + $x + "-" + $id;
						if (typeof $slidesdata[srcId] != 'undefined') {
							//new placeholder img obj
							var img = new Image(); 
							//img.src = $config.slides[srcId].cached_path; 
							//	Preload image into placeholder image object so it's in the browser cache.
							img.src = $slidesdata[srcId].cached_path;
							//	dump into appropriate slide image.
							$slides.find("img#slide-" + $x + "-" + $id).attr('src',$slidesdata[srcId].cached_path).addClass('preLoaded');	
						}
					}
				}
			}	
			
			//	End Preloader
			showSlide(window.location.hash);
			$send_pageview = true;
		} else {
		  // otherwise the default
			showSlide("#slide-0");
			var currThmb = 0;
			window.location.hash = "slide-0";
			$send_pageview = true;
		}
	  }
	  // otherwise the default
	  else {
	    showSlide("#slide-0");
	    var currThmb = 0;
		$send_pageview = true;
	  }
	
	  /*
	   * Create a public interface to move to the next and previous images
	   */
	  prevThumbNum = currThmb - 1;
	  if (prevThumbNum <= 0) prevThumbNum = $thumbsLi.not($(".cloned")).length - 1;
	
	  nextThumbNum = parseInt(currThmb) + 1;
	  if (nextThumbNum >= $thumbsLi.not($(".cloned")).length) nextThumbNum = 0;
	
	   // Setup buttons for next/prev slide
	  var previd = '#' + $el.attr('id') + '-shell a.prev-slide';
	  var nextid = '#' + $el.attr('id') + '-shell a.next-slide';
	
	//  $('a.prev-slide', $el).click(function(){
	  $(previd)
	  	.attr('href', "#slide-" + prevThumbNum)  	
	  	.click(function(e){
			var currentScroll = $wrapper.get(0).scrollLeft;
			var $prevThumbLi = $thumbsLi.filter('.active').prevAll().not('.empty, .cloned').filter(':first');

			// if no results we are on the first element
			if(!$prevThumbLi.size()) {
			  // select the last one
			  $prevThumbLi = $thumbsLi.not('.empty, .cloned').filter(':last');
			}
			var $slideToClick = $('a', $prevThumbLi).attr('href');
	
			var $prevIsVisible = (($prevThumbLi.get(0).offsetLeft >= currentScroll) && ($prevThumbLi.get(0).offsetLeft <= (visibleWidth + currentScroll)));
			
			if($prevIsVisible) {
			  showSlide($slideToClick);
			}
			else {
			  $thumbs.trigger('prev');
			  showSlide($slideToClick);
			}
			e.preventDefault();
			window.location.hash = $slideToClick;
		});
	
	  $(nextid)
	  	.attr('href', "#slide-" + nextThumbNum)  	
	    .click(function(e){
			var currentScroll = $wrapper.get(0).scrollLeft;
			var $nextThumbLi = $thumbsLi.filter('.active').nextAll().not('.empty, .cloned').filter(':first');
			// if no results we are on the last element
			
			if(!$nextThumbLi.size()) {
			  // select the first one
			  $nextThumbLi = $thumbsLi.not('.empty, .cloned').filter(':first');
			}
			var $slideToClick = $('a', $nextThumbLi).attr('href');
			var $nextIsVisible = (($nextThumbLi.get(0).offsetLeft >= currentScroll) && ($nextThumbLi.get(0).offsetLeft <= (visibleWidth + currentScroll)));
			if($nextIsVisible) {
			  showSlide($slideToClick);
			}
			else {
			  $thumbs.trigger('next');
			  showSlide($slideToClick);
			}
			e.preventDefault();
	 		window.location.hash = $slideToClick;
	   });
	

	  /*
	   *  Function to load slides
	   */
	  function showSlide(hash_id){
	     
	      var $hash = $(hash_id + "-" + $id + "-wrapper");
	      var $slidehash = hash_id.replace("#","") + "-" + $id;
	      
	      if(!$hash.is(':visible')){
	        $thumbsLi.removeClass('active');
	        
	        // activate that thumbnail 
	        $thumbsLi.not($(".cloned")).find("a[href="+hash_id+"]").parent().addClass('active'); 
	    
	        $slides.filter(':visible').fadeOut('slow');
	        $hash.fadeIn('slow');

	        $(".galleryformatter-futureus-gallery .gallery-slides .panel-overlay").scrollTop();
	        $(".galleryformatter-futureus-gallery .gallery-slides .panel-overlay").jScrollPane();
	        
	        var $panelheight = $(".galleryformatter-futureus-gallery .gallery-slides .panel-overlay").innerHeight();
	        $(".gallery-slides").css({
	        	'display': 'block',
	        	'width' : settings.fullGalleryWidth,
	        	'height' : $(hash_id + "-" + $id).height() + $panelheight
	        });
	        
	        $(".galwrap").css({
	        	'height' :$(hash_id + "-" + $id).height() - $panelheight
	        });
	        
	        
	        //Colorbox overlay
			$(hash_id + "-" + $id + "-wrapper a.galimage").colorbox({
				rel:"nofollow",
				//title: slideTitle($slidesdata[$slidehash].title + "<br>" + $slidesdata[$slidehash].description),
				title: slideTitle($slidesdata[$slidehash].description),
				scalePhotos: false
			});
	        $(document).bind('cbox_complete', function(){
	            $(".cboxPhoto").css({'margin-top' : 0});
	            $("#cboxClose").css({
	            	'float' : 'none',
	            	'background' : 'black'
	            });
	            
	            $.colorbox.resize({
	            	innerHeight: $("#cboxLoadedContent .cboxPhoto").height() + $("#cboxTitle").innerHeight()
	            });

	        });

			


	        $(".galleryformatter-futureus-gallery .gallery-slides .panel-overlay").css({
				'top': '15px'
			});

			var slideHashSplit = hash_id.split("-");	//	Update # of ## 
			var slideno = parseInt(slideHashSplit[1]) + 1;
			$('#' + $id + "-shell span.slidenumber").html(slideno);
			
			//	Parse data for prev/next urls, tied to deep linking
			var prevThumbNum = parseInt(slideHashSplit[1]) - 1;
			if (prevThumbNum < 0) prevThumbNum = $thumbsLi.not($(".cloned")).length - 1;
			
			var nextThumbNum = parseInt(slideHashSplit[1]) + 1;
			if (nextThumbNum >= $thumbsLi.not($(".cloned")).length) nextThumbNum = 0;
	
			$(previd).attr('href', "#slide-" + prevThumbNum);
			$(nextid).attr('href', "#slide-" + nextThumbNum);
	
			//	Setup GA Info
			if($send_pageview) {	
				if (typeof _gaq == 'object' || typeof _gaq == 'function') {
					_gaq.push(['_trackPageview', '/gallery/' + $gallery_display_title + '/' + hash_id]);				
				}
				//	change ad space
				if(settings.future_imagegallery_rotate_mpu==1) settings.galleryRefreshMPU();	
			}
	      } 
	  }
	};
		
	function slideTitle(description) {
		var title = stripslashes(decodeURIComponent(description));
		if (title.toLowerCase().indexOf("undefined") > 0) {		
			return title;
		}
		return false;
	}
	
	function stripslashes (str) {
	    return (str + '').replace(/\\(.?)/g, function (s, n1) {
	        switch (n1) {
	        case '\\':
	            return '\\';
	        case '0':
	            return '\u0000';
	        case '':
	            return '';
	        default:
	            return n1;
	        }
	    });
	}
	
	
	
});