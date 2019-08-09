<?php
/**
 * The about widget area.
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */
?>

<?php if ( is_active_sidebar( 'widget-area-about' ) ) : ?>
	<div id="widget-area-about">
		<?php dynamic_sidebar( 'widget-area-about' ); ?>
	</div><!-- end #widget-area-about -->
<?php endif; ?>