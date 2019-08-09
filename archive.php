<?php
/**
 * The template for displaying Archive pages.
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */

get_header(); ?>

	<div id="content">
		<?php the_post(); ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php if ( is_day() ) : ?>
						<?php printf( __( 'Day: <span>%s</span>', 'kerikeri' ), get_the_date() ); ?>
					<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Month: <span>%s</span>', 'kerikeri' ), get_the_date( 'F Y' ) ); ?>
					<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Year: <span>%s</span>', 'kerikeri' ), get_the_date( 'Y' ) ); ?>
					<?php else : ?>
						<?php _e( 'Blog Archives', 'kerikeri' ); ?>
					<?php endif; ?>
				</h1>
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