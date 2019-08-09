<?php
/**
 * The Tags Widget Area.
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */
?>

<?php if ( is_active_sidebar( 'widget-area-tags' ) ) : ?>
	<div id="widget-area-tags">
		<?php dynamic_sidebar( 'widget-area-tags' ); ?>
	</div><!-- end #widget-area-tags -->
<?php endif; ?>