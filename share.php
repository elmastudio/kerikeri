<?php
/**
 * Social share buttons for posts and pages

 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */
?>

<li class="share">
	<ul>
		<li class="gplus"><g:plusone size="medium" href="<?php the_permalink(); ?>"></g:plusone></li>
		<li class="twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-lang="<?php bloginfo('language'); ?>"><?php _e('Tweet', 'kerikeri') ?></a></li>
		<li class="fb"><div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="true" data-layout="button_count" data-width="120" data-show-faces="false"></div></li>
	</ul>
</li><!-- end .share -->
<a href="#" class="share-btn icon-share"><span><?php _e( 'Share', 'kerikeri' ); ?></span></a>
