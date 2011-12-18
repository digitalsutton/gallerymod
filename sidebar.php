<?php global $options; foreach ($options as $value) { if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } } ?>

		<div id="contentright">

			<div id="sidebar" class="clearfix">

				<ul>

					<?php if ( $wp_clear_ad300 == yes ) { ?>
					<li id="banner300-top-right">
						<div class="textwidget"><?php echo stripslashes($wp_clear_ad300_code); ?></div>
					</li>
					<?php } ?>


<div id="newsbox" class="block"><h2><a href="http://www.revolvermag.com/news">See All News &#187;</a></h2>
<?php query_posts('category_name=news&showposts=7'); ?>
<?php while (have_posts()) : the_post(); ?>
        <li><a href="<?php the_permalink(); ?>">
           <?php the_title(); ?>
          </a> <span style="font-size:9px;"><?php the_time('g:i a') ?></span> </li>
        <?php endwhile; ?>
</div>
<br>

<div id="albumreviews" class="block"><h2><a href="http://www.revolvermag.com/reviews">See All Reviews &#187;</a></h2><div id="allreviews">
<?php query_posts('category_name=reviews&showposts=3'); ?>
<?php while (have_posts()) : the_post(); ?>
        <div class="singlereview"><a href="<?php the_permalink(); ?>"><?php include (TEMPLATEPATH . '/post-thumb.php'); ?></a>



<a href="<?php the_permalink(); ?>"><h3><?php $key="[band]"; echo get_post_meta($post->ID, $key, true); ?></h3><?php $key="[albumtitle]"; echo get_post_meta($post->ID, $key, true); ?>
        </a></div>
        <?php endwhile; ?></div>
</div><img src="http://revolvermag.com/beta/wp-content/themes/wp-clear-prem/images/dottedline2.png">    

<div id="MPU" class="block">
<?php if (is_home()) {?>

<script language="JavaScript" type="text/javascript">
	AD_TILE++;
		document.write('<script language="JavaScript" src="http://ad.doubleclick.net/adj/fut.us.revolver/homepage;dcopt=ist;tile='+AD_TILE+';sz=300x600;ord='+ord+'?type="text/javascript"><\/script>');
	</script>
	<noscript>
	</noscript><center>Advertisement</center>
<?php }?>
<?php if (!is_home()) {?>
<script language="JavaScript" type="text/javascript">
	AD_TILE++;
		document.write('<script language="JavaScript" src="http://ad.doubleclick.net/adj/fut.us.revolver/article;dcopt=ist;tile='+AD_TILE+';sz=300x600;ord='+ord+'?type="text/javascript"><\/script>');
	</script>
	<noscript>
	</noscript>
<?php }?>
</div>				

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Sidebar - Top') ) : ?>
<?php endif; ?>	

				</ul>

			</div>


<div id="MPU">

<?php include (TEMPLATEPATH . '/lowermpu.php'); ?>  
</div>


			<div id="sidebar-bottom-left">



				<ul>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Sidebar - Bottom Left') ) : ?>
<?php endif; ?>	

				</ul>

			</div>


			<div id="sidebar-bottom-right">

				<ul>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Sidebar - Bottom Right') ) : ?>
<?php endif; ?>	

				</ul>

			</div>



		</div>