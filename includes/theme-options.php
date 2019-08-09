<?php
/**
 * Pohutukawa Theme Options
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Properly enqueue styles and scripts for our theme options page.
/*
/* This function is attached to the admin_enqueue_scripts action hook.
/*
/* @param string $hook_suffix The action passes the current page to the function.
/* We don't do anything if we're not on our theme options page.
/*-----------------------------------------------------------------------------------*/

function kerikeri_admin_enqueue_scripts( $hook_suffix ) {
	if ( $hook_suffix != 'appearance_page_theme_options' )
		return;

	wp_enqueue_style( 'kerikeri-theme-options', get_template_directory_uri() . '/includes/theme-options.css', false, '2011-04-28' );
	wp_enqueue_script( 'kerikeri-theme-options', get_template_directory_uri() . '/includes/theme-options.js', array( 'farbtastic' ), '2011-04-28' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_enqueue_scripts', 'kerikeri_admin_enqueue_scripts' );

/*-----------------------------------------------------------------------------------*/
/* Register the form setting for our kerikeri_options array.
/*
/* This function is attached to the admin_init action hook.
/*
/* This call to register_setting() registers a validation callback, kerikeri_theme_options_validate(),
/* which is used when the option is saved, to ensure that our option values are complete, properly
/* formatted, and safe.
/*
/* We also use this function to add our theme option if it doesn't already exist.
/*-----------------------------------------------------------------------------------*/

function kerikeri_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === kerikeri_get_theme_options() )
		add_option( 'kerikeri_theme_options', kerikeri_get_default_theme_options() );

	register_setting(
		'kerikeri_options',       // Options group, see settings_fields() call in theme_options_render_page()
		'kerikeri_theme_options', // Database option, see kerikeri_get_theme_options()
		'kerikeri_theme_options_validate' // The sanitization callback, see kerikeri_theme_options_validate()
	);
}
add_action( 'admin_init', 'kerikeri_theme_options_init' );

/*-----------------------------------------------------------------------------------*/
/* Add our theme options page to the admin menu.
/*
/* This function is attached to the admin_menu action hook.
/*-----------------------------------------------------------------------------------*/

function kerikeri_theme_options_add_page() {
	add_theme_page(
		__( 'Theme Options', 'kerikeri' ), // Name of page
		__( 'Theme Options', 'kerikeri' ), // Label in menu
		'edit_theme_options',                  // Capability required
		'theme_options',                       // Menu slug, used to uniquely identify the page
		'theme_options_render_page'            // Function that renders the options page
	);
}
add_action( 'admin_menu', 'kerikeri_theme_options_add_page' );

/*-----------------------------------------------------------------------------------*/
/* Returns the default options for Kerikeri
/*-----------------------------------------------------------------------------------*/

function kerikeri_get_default_theme_options() {
	$default_theme_options = array(
		'link_color'   => '#74C3D6',
		'hover_color'   => '#3594B3',
		'custom_logo' => '',
		'widgetbackground_color'   => '#74C3D6',
		'topborder_color'   => '#666666',
		'custom_footertext' => '',
		'custom_favicon' => '',
		'custom_apple_icon' => '',
		'share-posts' => '',
		'share-singleposts' => '',
		'share-pages' => '',
	);

	return apply_filters( 'kerikeri_default_theme_options', $default_theme_options );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for Kerikeri
/*-----------------------------------------------------------------------------------*/

function kerikeri_get_theme_options() {
	return get_option( 'kerikeri_theme_options' );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for Kerikeri
/*-----------------------------------------------------------------------------------*/

function theme_options_render_page() {
	?>
	<div class="wrap">
		<h2><?php printf( __( '%s Theme Options', 'kerikeri' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'kerikeri_options' );
				$options = kerikeri_get_theme_options();
				$default_options = kerikeri_get_default_theme_options();
			?>

			<table class="form-table">

				<tr valign="top"><th scope="row"><?php _e( 'Custom Link Color', 'kerikeri' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Link Color', 'kerikeri' ); ?></span></legend>
							 <input type="text" name="kerikeri_theme_options[link_color]" value="<?php echo esc_attr( $options['link_color'] ); ?>" id="link-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker1"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose a custom main link color (default Link Color: %s). Do not forget to include the # before the color value.', 'kerikeri' ), $default_options['link_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Link Hover Color', 'kerikeri' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Link Hover Color', 'kerikeri' ); ?></span></legend>
							 <input type="text" name="kerikeri_theme_options[hover_color]" value="<?php echo esc_attr( $options['hover_color'] ); ?>" id="hover-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker3"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose your own custom main link hover color (default Link Hover Color: %s).', 'kerikeri' ), $default_options['hover_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Logo', 'kerikeri' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Logo image', 'kerikeri' ); ?></span></legend>
							<input class="regular-text" type="text" name="kerikeri_theme_options[custom_logo]" value="<?php esc_attr_e( $options['custom_logo'] ); ?>" />
						<br/><label class="description" for="kerikeri_theme_options[custom_logo]"><?php _e('Upload your own logo image using the ', 'kerikeri'); ?><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('WordPress Media Uploader', 'kerikeri'); ?></a><?php _e('. Then copy your logo image file URL and insert the URL here.', 'kerikeri'); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Top Border Color', 'kerikeri' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Top Border Color', 'kerikeri' ); ?></span></legend>
						<input type="text" name="kerikeri_theme_options[topborder_color]" value="<?php echo esc_attr( $options['topborder_color'] ); ?>" id="topborder-color" />
						<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker4"></div>
						<br />
						<small class="description"><?php printf( __( 'Customize the top border background color (default Topborder Color: %s).', 'kerikeri' ), $default_options['topborder_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Widget Background Color', 'kerikeri' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Widget Background Color', 'kerikeri' ); ?></span></legend>
						<input type="text" name="kerikeri_theme_options[widgetbackground_color]" value="<?php echo esc_attr( $options['widgetbackground_color'] ); ?>" id="widgetbackground-color" />
						<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker2"></div>
						<br />
						<small class="description"><?php printf( __( 'Customize the widget background color (default Widget Background Color: %s).', 'kerikeri' ), $default_options['widgetbackground_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Favicon', 'kerikeri' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Favicon', 'kerikeri' ); ?></span></legend>
							<input class="regular-text" type="text" name="kerikeri_theme_options[custom_favicon]" value="<?php esc_attr_e( $options['custom_favicon'] ); ?>" />
						<br/><label class="description" for="kerikeri_theme_options[custom_favicon]"><?php _e( 'Create a <strong>16x16px</strong> image and generate a .ico favicon using a favicon online generator. Now upload your favicon to your themes folder (via FTP) and enter your Favicon URL here (the URL path should be similar to: yourdomain.com/wp-content/themes/kerikeri/favicon.ico).', 'kerikeri' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Apple Touch Icon', 'kerikeri' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Apple Touch Icon', 'kerikeri' ); ?></span></legend>
							<input class="regular-text" type="text" name="kerikeri_theme_options[custom_apple_icon]" value="<?php esc_attr_e( $options['custom_apple_icon'] ); ?>" />
						<br/><label class="description" for="kerikeri_theme_options[custom_apple_icon]"><?php _e('Create a <strong>128x128px png</strong> image for your webclip icon. Upload your image using the ', 'kerikeri'); ?><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('WordPress Media Uploader', 'kerikeri'); ?></a><?php _e('. Now copy the image file URL and insert the URL here.', 'kerikeri'); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Footer Credit Text', 'kerikeri' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Footer text', 'kerikeri' ); ?></span></legend>
							<textarea id="kerikeri_theme_options[custom_footertext]" class="small-text" cols="120" rows="3" name="kerikeri_theme_options[custom_footertext]"><?php echo esc_textarea( $options['custom_footertext'] ); ?></textarea>
						<br/><label class="description" for="kerikeri_theme_options[custom_footertext]"><?php _e( 'Customize the footer credit text. Standard HTML is allowed.', 'kerikeri' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for posts', 'kerikeri' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for posts', 'kerikeri' ); ?></span></legend>
							<input id="kerikeri_theme_options[share-posts]" name="kerikeri_theme_options[share-posts]" type="checkbox" value="1" <?php checked( '1', $options['share-posts'] ); ?> />
							<label class="description" for="kerikeri_theme_options[share-posts]"><?php _e( 'Check this box to include a Twitter, Facebook and Google+ button to your blogs front page and on single post pages.', 'kerikeri' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for single post pages only', 'kerikeri' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for single post pages only', 'kerikeri' ); ?></span></legend>
							<input id="kerikeri_theme_options[share-singleposts]" name="kerikeri_theme_options[share-singleposts]" type="checkbox" value="1" <?php checked( '1', $options['share-singleposts'] ); ?> />
							<label class="description" for="kerikeri_theme_options[share-singleposts]"><?php _e( 'Check this box to include the share post buttons <strong>only</strong> on single post pages (below the post content).', 'kerikeri' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for pages', 'kerikeri' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for pages', 'kerikeri' ); ?></span></legend>
							<input id="kerikeri_theme_options[share-pages]" name="kerikeri_theme_options[share-pages]" type="checkbox" value="1" <?php checked( '1', $options['share-pages'] ); ?> />
							<label class="description" for="kerikeri_theme_options[share-pages]"><?php _e( 'Check this box to also include the share buttons on pages.', 'kerikeri' ); ?></label>
						</fieldset>
					</td>
				</tr>

			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Sanitize and validate form input. Accepts an array, return a sanitized array.
/*-----------------------------------------------------------------------------------*/

function kerikeri_theme_options_validate( $input ) {
	global $layout_options, $font_options;

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
			$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	// Link hover color must be 3 or 6 hexadecimal characters
	if ( isset( $input['hover_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['hover_color'] ) )
			$output['hover_color'] = '#' . strtolower( ltrim( $input['hover_color'], '#' ) );

	//  Widget background color must be 3 or 6 hexadecimal characters
	if ( isset( $input['widgetbackground_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['widgetbackground_color'] ) )
			$output['widgetbackground_color'] = '#' . strtolower( ltrim( $input['widgetbackground_color'], '#' ) );

	//  Top border color must be 3 or 6 hexadecimal characters
	if ( isset( $input['topborder_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['topborder_color'] ) )
			$output['topborder_color'] = '#' . strtolower( ltrim( $input['topborder_color'], '#' ) );

	// Text options must be safe text with no HTML tags
	$input['custom_logo'] = wp_filter_nohtml_kses( $input['custom_logo'] );
	$input['custom_favicon'] = wp_filter_nohtml_kses( $input['custom_favicon'] );
	$input['custom_apple_icon'] = wp_filter_nohtml_kses( $input['custom_apple_icon'] );

	// checkbox values are either 0 or 1
	if ( ! isset( $input['share-posts'] ) )
		$input['share-posts'] = null;
	$input['share-posts'] = ( $input['share-posts'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-singleposts'] ) )
		$input['share-singleposts'] = null;
	$input['share-singleposts'] = ( $input['share-singleposts'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-pages'] ) )
		$input['share-pages'] = null;
	$input['share-pages'] = ( $input['share-pages'] == 1 ? 1 : 0 );

	return $input;
}


/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current link color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function kerikeri_print_link_color_style() {
	$options = kerikeri_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = kerikeri_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
<style type="text/css">
/* Custom Link Color */
a, #content h2.entry-title a:hover, #content .entry-meta ul li.entry-cats a, #content .entry-meta ul li.entry-tags a {color:<?php echo $link_color; ?>;}
.entry-details ul li.entry-postformat a, input#submit, input.wpcf7-submit, #content .format-link .entry-content a.link, #content #comment-nav .nav-previous a, #content #comment-nav .nav-next a, #content #nav-below a:hover, #content .next-image a:hover, #content .previous-image a:hover, #footer a.top:hover {background:<?php echo $link_color; ?>;}
#content .format-quote blockquote {border-left:5px solid <?php echo $link_color; ?>;}
</style>
<?php
}
add_action( 'wp_head', 'kerikeri_print_link_color_style' );


/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current Link Hover color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function kerikeri_print_hover_color_style() {
	$options = kerikeri_get_theme_options();
	$hover_color = $options['hover_color'];

	$default_options = kerikeri_get_default_theme_options();

	// Don't do anything if the current  footer widget background color is the default.
	if ( $default_options['hover_color'] == $hover_color )
		return;
?>
<style type="text/css">
/* Custom Hover Link Color */
a:hover, #content .entry-meta ul li.entry-cats a:hover, #content .entry-meta ul li.entry-tags a:hover, #content .widget .textwidget a:hover, #content .widget_about p.abouttext a:hover, #content .widget ul li a:hover, .widget_tag_cloud a:hover, #content .flickr_badge_wrapper .flickr-bottom a:hover  {color:<?php echo $hover_color; ?>;}
.entry-details ul li.entry-postformat a:hover, input#submit:hover, input.wpcf7-submit:hover, #content .format-link .entry-content a.link:hover, #content .widget ul li a, .widget_tag_cloud a, #content .flickr_badge_wrapper .flickr-bottom a { background:<?php echo $hover_color; ?>;}
</style>
<?php
}
add_action( 'wp_head', 'kerikeri_print_hover_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current Widget background color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function kerikeri_print_widgetbackground_color_style() {
	$options = kerikeri_get_theme_options();
	$widgetbackground_color = $options['widgetbackground_color'];

	$default_options = kerikeri_get_default_theme_options();

	// Don't do anything if the current widget background color is the default.
	if ( $default_options['widgetbackground_color'] == $widgetbackground_color )
		return;
?>
<style type="text/css">
/* Custom Widget Background Color */
.widget { background:<?php echo $widgetbackground_color; ?>;}
.widget_about:before, .widget_tag_cloud:before {color:<?php echo $widgetbackground_color; ?>;}
</style>
<?php
}
add_action( 'wp_head', 'kerikeri_print_widgetbackground_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current Top border background color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function kerikeri_print_topborder_color_style() {
	$options = kerikeri_get_theme_options();
	$topborder_color = $options['topborder_color'];

	$default_options = kerikeri_get_default_theme_options();

	// Don't do anything if the current widget background color is the default.
	if ( $default_options['topborder_color'] == $topborder_color )
		return;
?>
<style type="text/css">
/* Custom Topboder Color */
#header #site-nav-wrap { background:<?php echo $topborder_color; ?>;}
</style>
<?php
}
add_action( 'wp_head', 'kerikeri_print_topborder_color_style' );
