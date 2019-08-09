<?php
/**
 * The template for displaying posts in the Image Post Format
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<aside class="entry-details">
		<ul class="clearfix">
			<li class="entry-date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
			<li class="entry-comments"><?php comments_popup_link( __( '0 comments', 'kerikeri' ), __( '1 comment', 'kerikeri' ), __( '% comments', 'kerikeri' ), 'comments-link', __( 'comments off', 'kerikeri' ) ); ?></li>
			<li class="entry-edit"><?php edit_post_link(__( 'Edit Post &rarr;', 'kerikeri') ); ?></li>
			<li class="entry-postformat"><a href="<?php the_permalink(); ?>" class="image icon-image"><span><?php _e('Image', 'kerikeri') ?></span></a></li>
		</ul>
	</aside>

	<div class="entry-content">
		<?php the_content( __( 'Read more &rarr;', 'kerikeri' ) ); ?>
	</div><!-- end entry-content -->

	<footer class="entry-meta">
		<ul>
			<?php // Include Share-Btns
				$options = get_option('kerikeri_theme_options');
				if( $options['share-posts'] ) : ?>
				<?php get_template_part( 'share'); ?>
			<?php endif; ?>
			
			<li class="entry-cats"><span><?php _e('Category:', 'kerikeri') ?></span> <?php the_category( ' ' ); ?></li>
		</ul>
	</footer><!-- end .entry-meta -->

</article><!-- end post -<?php the_ID(); ?> -->