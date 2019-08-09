<?php
/**
 * The additional widget area.
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */
?>

<?php if ( is_active_sidebar( 'widget-area-additional' ) ) : ?>
	<div id="widget-area-additional">
		<?php dynamic_sidebar( 'widget-area-additional' ); ?>
	</div><!-- end #widget-area-additional -->
<?php endif; ?>