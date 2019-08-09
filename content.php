<?php
/**
 * The default template for displaying content
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
			<li class="entry-postformat"><a href="<?php the_permalink(); ?>" class="standard icon-file"><span><?php _e('Standard', 'kerikeri') ?></span></a></li>
		</ul>
	</aside>

	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'kerikeri' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	</header><!--end .entry-header -->

	<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- end .entry-summary -->

	<?php else : ?>
			
	<div class="entry-content clearfix">
		<?php if ( has_post_thumbnail() ): ?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		<?php endif; ?>
		<?php the_content( __( 'Read more &rarr;', 'kerikeri' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'kerikeri' ), 'after' => '</div>' ) ); ?>
	</div><!-- end .entry-content -->

	<?php endif; ?>

	<footer class="entry-meta">
		<ul>
			<?php // Include Share-Btns
				$options = get_option('kerikeri_theme_options');
				if( $options['share-posts'] ) : ?>
				<?php get_template_part( 'share'); ?>
			<?php endif; ?>
			
			<li class="entry-cats"><span><?php _e('Category', 'kerikeri') ?></span> <?php the_category( ' ' ); ?></li>
		</ul>
	</footer><!-- end .entry-meta -->

</article><!-- end post -<?php the_ID(); ?> -->