<script>
	jQuery(document).ready(function($){
		$('html').addClass('gallery');
	});
</script>

<div class="group-gallery" id="<?php print $slideset_id; ?>-shell">

	<?php
	$thumb_count = floor($gallery_slide_width/$gallery_thumb_width);
	$count = 0; //	Initialize main count
	?>
	
	<div class="gallery_prevnext">
		<a href="#" class="prev-slide"></a>
		<a href="#" class="next-slide"></a>
	</div>
	<!--<span class="slidenumber"></span>-->
	<?php if (count($gallery_slides) > 0): ?>
	<div class="galleryformatter galleryview <?php print $gallery_style ?>" id="<?php echo $slideset_id ?>">
	  <div class="gallery-slides">
	    <div class="gallery-frame">
	      <ul class='gallery-container'>
	      <?php foreach ($gallery_slides as $id => $data): ?>
	        <li class="gallery-slide" id="<?php print $data['hash_id']; ?>-wrapper">
	          <?php echo ($count <= $thumb_count || $count == count($gallery_slides) - 1) ? $data['image'] : $data['image_nopath']; ?>
	            <div class="panel-overlay">      	
	                <?php if (!empty($data['title'])): ?><p><?php print stripslashes(rawurldecode($data['title'])); ?></p><?php endif; ?>
	                <?php if (!empty($data['description'])): ?><p><?php print stripslashes(rawurldecode($data['description'])); ?></p><?php endif; ?>
	            </div>
	        </li>
	      <?php 
	      		$count++;
	      		endforeach; ?>
	      </ul>
	    </div>
	  </div>
	  <?php if($gallery_thumbs): ?>
	  <div class="gallery-thumbs" style="width: <?php print $gallery_slide_width; ?>px;">
	    <div class="wrapper">
	      <ul>
	        <?php foreach ($gallery_thumbs as $id => $data): ?>
	          <li class="slide-<?php print $id; ?>" style="width: <?php print $gallery_thumb_width; ?>px;"><a href="#<?php print $data['hash_id']; ?>"><?php print $data['image']; ?></a></li>
	        <?php endforeach; ?>
	      </ul>
	    </div>
	  </div>
	  <?php endif; ?>
	</div>
	<?php endif; ?>
</div>