<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */

get_header(); ?>

	<div id="content" class="clearfix">

		<header class="page-header">
			<h1 class="page-title"><?php printf( __( 'Tag: %s', 'kerikeri' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
		</header><!--end .page-header-->

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