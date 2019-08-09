<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */

get_header(); ?>

	<div id="content">

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>

		<nav id="nav-below" class="clearfix">
			<div class="nav-previous"><?php next_post_link( '%link', __( '<i class="icon-chevron-left"></i><span>Next Post &raquo;</span>', 'kerikeri' ) ); ?></div>
			<div class="nav-next"><?php previous_post_link( '%link', __( '<i class="icon-chevron-right"></i><span>&laquo; Previous Post</span>', 'kerikeri' ) ); ?></div>
		</nav><!-- #nav-below -->

<?php get_sidebar('about'); ?>
<?php get_sidebar('tags'); ?>
<?php get_sidebar('additional'); ?>
<?php get_footer(); ?>