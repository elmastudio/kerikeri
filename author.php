<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */

get_header(); ?>

	<div id="content">
		<?php the_post(); ?>

		<header class="page-header">
			<h1 class="page-title author"><?php	printf( __( 'Author Archives: <span class="vcard">%s</span>', 'kerikeri' ), get_the_author() ); ?></h1>
		</header><!-- end .page-header -->

		<?php rewind_posts(); ?>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

		<?php endwhile; // end of the loop. ?>
			
		<?php kerikeri_content_nav( 'nav-below' ); ?>

<?php get_sidebar('about'); ?>
<?php get_sidebar('tags'); ?>
<?php get_sidebar('additional'); ?>
<?php get_footer(); ?>