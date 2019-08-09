<?php
/**
 * Template for displaying the search forms
 *
 * @package Baylys
 * @since Baylys 1.0
 */
?>
	<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="input-prepend">
		<span class="add-on"><i class="icon-search"></i></span>
			<input type="text" class="field s" name="s" placeholder="<?php esc_attr_e( 'Search this site', 'kerikeri' ); ?>">
	</div>
		<input type="submit" class="submit searchsubmit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'kerikeri' ); ?>" />
	</form>
