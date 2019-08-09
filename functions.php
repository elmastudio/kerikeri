<?php
/**
 * Kerikeri functions and definitions
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Set the content width based on the theme's design and stylesheet.
/*-----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) )
	$content_width = 612; /* pixels */

/*-----------------------------------------------------------------------------------*/
/* Tell WordPress to run kerikeri() when the 'after_setup_theme' hook is run.
/*-----------------------------------------------------------------------------------*/

add_action( 'after_setup_theme', 'kerikeri' );

if ( ! function_exists( 'kerikeri' ) ):

/*-----------------------------------------------------------------------------------*/
/* Custom Kerikeri Theme Options
/*-----------------------------------------------------------------------------------*/

require( get_template_directory() . '/includes/theme-options.php' );

/*-----------------------------------------------------------------------------------*/
/* Call JavaScript Scripts for Kerikeri (Fitvids for elasic videos, Custom and Placeholder)
/*-----------------------------------------------------------------------------------*/

add_action('wp_enqueue_scripts','kerikeri_scripts_function');
	function kerikeri_scripts_function() {
		wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', false, '1.1');
		wp_enqueue_script( 'placeholder', get_template_directory_uri() . '/js/jquery.placeholder.min.js', false, '1.0');
		wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', false, '1.0');
}

/*-----------------------------------------------------------------------------------*/
/* Sets up theme defaults and registers support for WordPress features.
/*-----------------------------------------------------------------------------------*/

function kerikeri() {

	// Make Hawea available for translation. Translations can be added to the /languages/ directory.
	load_theme_textdomain( 'kerikeri', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'editor-style.css' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'kerikeri' ),
	) );

	// Add support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'status', 'link', 'quote', 'image', 'gallery', 'video', 'audio','chat' ) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'kerikeri_custom_background_args', array(
		'default-color' => 'e5e5e5',
	) ) );

}
endif;

/*-----------------------------------------------------------------------------------*/
/* Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
/*-----------------------------------------------------------------------------------*/

function kerikeri_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'kerikeri_page_menu_args' );

/*-----------------------------------------------------------------------------------*/
/* Sets the post excerpt length to 40 characters.
/*-----------------------------------------------------------------------------------*/

function kerikeri_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'kerikeri_excerpt_length' );

/*-----------------------------------------------------------------------------------*/
/* Returns a "Continue Reading" link for excerpts
/*-----------------------------------------------------------------------------------*/

function kerikeri_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Read more &rarr;', 'kerikeri' ) . '</a>';
}

/*-----------------------------------------------------------------------------------*/
/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and kerikeri_continue_reading_link().
/*
/* To override this in a child theme, remove the filter and add your own
/* function tied to the excerpt_more filter hook.
/*-----------------------------------------------------------------------------------*/

function kerikeri_auto_excerpt_more( $more ) {
	return ' &hellip;' . kerikeri_continue_reading_link();
}
add_filter( 'excerpt_more', 'kerikeri_auto_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Adds a pretty "Continue Reading" link to custom post excerpts.
/*
/* To override this link in a child theme, remove the filter and add your own
/* function tied to the get_the_excerpt filter hook.
/*-----------------------------------------------------------------------------------*/

function kerikeri_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= kerikeri_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'kerikeri_custom_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Remove inline styles printed when the gallery shortcode is used.
/*-----------------------------------------------------------------------------------*/

function kerikeri_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'kerikeri_remove_gallery_css' );


if ( ! function_exists( 'kerikeri_comment' ) ) :
/*-----------------------------------------------------------------------------------*/
/* Comments template kerikeri_comment
/*-----------------------------------------------------------------------------------*/

function kerikeri_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>

	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">

			<div class="comment-details clearfix">
				<?php echo get_avatar( $comment, 40 ); ?>

				<ul class="comment-meta">
					<li class="comment-author"><?php printf( __( '%s', 'kerikeri' ), sprintf( '%s', get_comment_author_link() ) ); ?></li>
						<li class="comment-time"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s &#64; %2$s', 'kerikeri' ),
						get_comment_date('d.m.y'),
						get_comment_time() );
					?></a></li>
					<li class="comment-edit"><?php edit_comment_link( __( 'Edit &rarr;', 'kerikeri' ), ' ' );?></li>
					<li class="comment-reply"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'kerikeri' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></li>
				</ul>
			</div><!-- end .comment-details -->

			<div class="comment-content">
				<?php comment_text(); ?>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'kerikeri' ); ?></p>
				<?php endif; ?>
			</div><!-- end .comment-content -->
		</article><!-- end .comment -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="pingback">
		<p><?php _e( '<span>Pingback:</span>', 'kerikeri' ); ?> <?php comment_author_link(); ?></p>
		<p><?php edit_comment_link( __('Edit &rarr;', 'kerikeri'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Register widgetized areas
/*-----------------------------------------------------------------------------------*/

function kerikeri_widgets_init() {

	register_sidebar( array (
		'name' => __( 'About Widget Area', 'kerikeri' ),
		'id' => 'widget-area-about',
		'description' => __( 'About widget area', 'kerikeri' ),
		'before_widget' => '<aside id="%2$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => __( 'Tags Widget Area', 'kerikeri' ),
		'id' => 'widget-area-tags',
		'description' => __( 'Tags widget area', 'kerikeri' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => __( 'Additional Widget Area', 'kerikeri' ),
		'id' => 'widget-area-additional',
		'description' => __( 'Additional Widget Area', 'kerikeri' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'init', 'kerikeri_widgets_init' );


if ( ! function_exists( 'kerikeri_content_nav' ) ) :
/*-----------------------------------------------------------------------------------*/
/* Display navigation to next/previous pages when applicable
/*-----------------------------------------------------------------------------------*/

function kerikeri_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>" class="clearfix">
				<div class="nav-previous"><?php next_posts_link( __( '<i class="icon-chevron-left"></i><span>&laquo; Older posts</span>', 'kerikeri' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( '<i class="icon-chevron-right"></i><span>Newer posts &raquo;</span>', 'kerikeri' ) ); ?></div>
			</nav><!-- end #nav-below -->
	<?php endif;
}

endif; // kerikeri_content_nav


 /*-----------------------------------------------------------------------------------*/
 /* Removes the default CSS style from the WP image gallery
 /*-----------------------------------------------------------------------------------*/
add_filter('gallery_style', create_function('$a', 'return "
<div class=\'gallery\'>";'));


/*-----------------------------------------------------------------------------------*/
/* Add One Click Demo Import code.
/*-----------------------------------------------------------------------------------*/
require get_template_directory() . '/includes/demo-installer.php';


/*-----------------------------------------------------------------------------------*/
/* Kerikeri Shortcodes
/*-----------------------------------------------------------------------------------*/

// Enable shortcodes in widget areas
add_filter( 'widget_text', 'do_shortcode' );

// Replace WP autop formatting
if (!function_exists( "kerikeri_remove_wpautop")) {
	function kerikeri_remove_wpautop($content) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content);
		return $content;
	}
}


/*-----------------------------------------------------------------------------------*/
/* Multi Columns Shortcodes
/* Don't forget to add "_last" behind the shortcode if it is the last column.
/*-----------------------------------------------------------------------------------*/

// Two Columns
function kerikeri_shortcode_two_columns_one( $atts, $content = null ) {
	 return '<div class="two-columns-one">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one', 'kerikeri_shortcode_two_columns_one' );

function kerikeri_shortcode_two_columns_one_last( $atts, $content = null ) {
	 return '<div class="two-columns-one last">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one_last', 'kerikeri_shortcode_two_columns_one_last' );

// Three Columns
function kerikeri_shortcode_three_columns_one($atts, $content = null) {
	 return '<div class="three-columns-one">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one', 'kerikeri_shortcode_three_columns_one' );

function kerikeri_shortcode_three_columns_one_last($atts, $content = null) {
	 return '<div class="three-columns-one last">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one_last', 'kerikeri_shortcode_three_columns_one_last' );

function kerikeri_shortcode_three_columns_two($atts, $content = null) {
	 return '<div class="three-columns-two">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two', 'kerikeri_shortcode_three_columns' );

function kerikeri_shortcode_three_columns_two_last($atts, $content = null) {
	 return '<div class="three-columns-two last">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two_last', 'kerikeri_shortcode_three_columns_two_last' );

// Four Columns
function kerikeri_shortcode_four_columns_one($atts, $content = null) {
	 return '<div class="four-columns-one">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one', 'kerikeri_shortcode_four_columns_one' );

function kerikeri_shortcode_four_columns_one_last($atts, $content = null) {
	 return '<div class="four-columns-one last">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one_last', 'kerikeri_shortcode_four_columns_one_last' );

function kerikeri_shortcode_four_columns_two($atts, $content = null) {
	 return '<div class="four-columns-two">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two', 'kerikeri_shortcode_four_columns_two' );

function kerikeri_shortcode_four_columns_two_last($atts, $content = null) {
	 return '<div class="four-columns-two last">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two_last', 'kerikeri_shortcode_four_columns_two_last' );

function kerikeri_shortcode_four_columns_three($atts, $content = null) {
	 return '<div class="four-columns-three">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three', 'kerikeri_shortcode_four_columns_three' );

function kerikeri_shortcode_four_columns_three_last($atts, $content = null) {
	 return '<div class="four-columns-three last">' . kerikeri_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three_last', 'kerikeri_shortcode_four_columns_three_last' );

// Divide Text Shortcode
function kerikeri_shortcode_divider($atts, $content = null) {
	 return '<div class="divider"></div>';
}
add_shortcode( 'divider', 'kerikeri_shortcode_divider' );

/*-----------------------------------------------------------------------------------*/
/* Text Highlight and Info Boxes Shortcodes
/*-----------------------------------------------------------------------------------*/

function kerikeri_shortcode_white_box($atts, $content = null) {
	 return '<div class="white-box">' . do_shortcode( kerikeri_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'white_box', 'kerikeri_shortcode_white_box' );

function kerikeri_shortcode_yellow_box($atts, $content = null) {
	 return '<div class="yellow-box">' . do_shortcode( kerikeri_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'yellow_box', 'kerikeri_shortcode_yellow_box' );

function kerikeri_shortcode_red_box($atts, $content = null) {
	 return '<div class="red-box">' . do_shortcode( kerikeri_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'red_box', 'kerikeri_shortcode_red_box' );

function kerikeri_shortcode_blue_box($atts, $content = null) {
	 return '<div class="blue-box">' . do_shortcode( kerikeri_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'blue_box', 'kerikeri_shortcode_blue_box' );

function kerikeri_shortcode_green_box($atts, $content = null) {
	 return '<div class="green-box">' . do_shortcode( kerikeri_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'green_box', 'kerikeri_shortcode_green_box' );

function kerikeri_shortcode_lightgrey_box($atts, $content = null) {
	 return '<div class="lightgrey-box">' . do_shortcode( kerikeri_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'lightgrey_box', 'kerikeri_shortcode_lightgrey_box' );

function kerikeri_shortcode_grey_box($atts, $content = null) {
	 return '<div class="grey-box">' . do_shortcode( kerikeri_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'grey_box', 'kerikeri_shortcode_grey_box' );

function kerikeri_shortcode_dark_box($atts, $content = null) {
	 return '<div class="dark-box">' . do_shortcode( kerikeri_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'dark_box', 'kerikeri_shortcode_dark_box' );

/*-----------------------------------------------------------------------------------*/
/* General Buttons Shortcodes
/*-----------------------------------------------------------------------------------*/

function kerikeri_button( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'link'	=> '#',
		'target' => '',
		'color'	=> '',
		'size'	=> '',
	 'form'	=> '',
	 'style'	=> '',
		), $atts));

	$color = ($color) ? ' '.$color. '-btn' : '';
	$size = ($size) ? ' '.$size. '-btn' : '';
	$form = ($form) ? ' '.$form. '-btn' : '';
	$target = ($target == 'blank') ? ' target="_blank"' : '';

	$out = '<a' .$target. ' class="standard-btn' .$color.$size.$form. '" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';

		return $out;
}
add_shortcode('button', 'kerikeri_button');

/*-----------------------------------------------------------------------------------*/
/* Link Post Format Button Shortcode
/*-----------------------------------------------------------------------------------*/

function kerikeri_link_format( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'link'	=> '#',
		'target'	=> '',
	 'style'	=> '',
		), $atts));

	$target = ($target == 'blank') ? ' target="_blank"' : '';

	$out = '<a' .$target. ' class="link' .$style. '" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';

		return $out;
}
add_shortcode('link_format', 'kerikeri_link_format');


/*-----------------------------------------------------------------------------------*/
/* Including a custom About Widget
/*-----------------------------------------------------------------------------------*/

 class kerikeri_about extends WP_Widget {

	public function __construct() {
		parent::__construct( 'kerikeri_about', __( 'About Widget', 'kerikeri' ), array(
			'classname'   => 'widget_kerikeri_about',
			'description' => __( 'Add an about me widget with image, about text und social links to your blog.', 'kerikeri' ),
		) );
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$aboutimageurl = $instance['aboutimageurl'];
		$abouttext = $instance['abouttext'];
		$sociallinkstitle = $instance['sociallinkstitle'];
		$twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$googleplus = $instance['googleplus'];
		$flickr = $instance['flickr'];
		$picasa = $instance['picasa'];
		$fivehundredpx = $instance['fivehundredpx'];
		$youtube = $instance['youtube'];
		$vimeo = $instance['vimeo'];
		$dribbble = $instance['dribbble'];
		$ffffound = $instance['ffffound'];
		$pinterest = $instance['pinterest'];
		$zootool = $instance['zootool'];
		$behance = $instance['behance'];
		$deviantart = $instance['deviantart'];
		$squidoo = $instance['squidoo'];
		$slideshare = $instance['slideshare'];
		$lastfm = $instance['lastfm'];
		$grooveshark = $instance['grooveshark'];
		$soundcloud = $instance['soundcloud'];
		$foursquare = $instance['foursquare'];
		$gowalla = $instance['gowalla'];
		$linkedin = $instance['linkedin'];
		$xing = $instance['xing'];
		$wordpress = $instance['wordpress'];
		$tumblr = $instance['tumblr'];
		$rss = $instance['rss'];
		$rsscomments = $instance['rsscomments'];
		$target = $instance['target'];


		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

			<?php if($aboutimageurl != '')
			echo '<img src="'.$aboutimageurl.'" width="250" height="250" class="about-img" />'; ?>

			<?php if($abouttext != '')
			echo '<p class="abouttext">'.$abouttext.'</p>'; ?>

			<?php if($sociallinkstitle != '')
			echo '<h4 class="sociallinkstitle">'.$sociallinkstitle.'</h4>'; ?>

				<ul class="sociallinks">
			<?php
			if($twitter != '' && $target != ''){
				echo '<li><a href="'.$twitter.'" class="twitter" title="Twitter" target="_blank">Twitter</a></li>';
			} elseif($twitter != '') {
				echo '<li><a href="'.$twitter.'" class="twitter" title="Twitter">Twitter</a></li>';
			}
			?>

			<?php
			if($facebook != '' && $target != ''){
				echo '<li><a href="'.$facebook.'" class="facebook" title="Facebook" target="_blank">Facebook</a></li>';
			} elseif($facebook != '') {
				echo '<li><a href="'.$facebook.'" class="facebook" title="Facebook">Facebook</a></li>';
			}
			?>

			<?php
			if($googleplus != '' && $target != ''){
				echo '<li><a href="'.$googleplus.'" class="googleplus" title="Google+" target="_blank">Google+</a></li>';
			} elseif($googleplus != '') {
				echo '<li><a href="'.$googleplus.'" class="googleplus" title="Google+">Google+</a></li>';
			}
			?>

			<?php if($flickr != '' && $target != ''){
				echo '<li><a href="'.$flickr.'" class="flickr" title="Flickr" target="_blank">Flickr</a></li>';
			} elseif($flickr != '') {
				echo '<li><a href="'.$flickr.'" class="flickr" title="Flickr">Flickr</a></li>';
			}
			?>

			<?php if($picasa != '' && $target != ''){
				echo '<li><a href="'.$picasa.'" class="picasa" title="Picasa" target="_blank">Picasa</a></li>';
			} elseif($picasa != '') {
				echo '<li><a href="'.$picasa.'" class="picasa" title="Picasa">Picasa</a></li>';
			}
			?>

			<?php if($fivehundredpx != '' && $target != ''){
				echo '<li><a href="'.$fivehundredpx.'" class="fivehundredpx" title="500px" target="_blank">500px</a></li>';
			} elseif($fivehundredpx != '') {
				echo '<li><a href="'.$fivehundredpx.'" class="fivehundredpx" title="500px">500px</a></li>';
			}
			?>

			<?php if($youtube != '' && $target != ''){
			echo '<li><a href="'.$youtube.'" class="youtube" title="YouTube" target="_blank">YouTube</a></li>';
			} elseif($youtube != '') {
				echo '<li><a href="'.$youtube.'" class="youtube" title="YouTube">YouTube</a></li>';
			}
			?>

			<?php if($vimeo != '' && $target != ''){
			echo '<li><a href="'.$vimeo.'" class="vimeo" title="Vimeo" target="_blank">Vimeo</a></li>';
			} elseif($vimeo != '') {
				echo '<li><a href="'.$vimeo.'" class="vimeo" title="Vimeo">Vimeo</a></li>';
			}
			?>

			<?php if($dribbble != '' && $target != ''){
			echo '<li><a href="'.$dribbble.'" class="dribbble" title="Dribbble" target="_blank">Dribbble</a></li>';
			} elseif($dribbble != '') {
				echo '<li><a href="'.$dribbble.'" class="dribbble" title="Dribbble">Dribbble</a></li>';
			}
			?>

			<?php if($ffffound != '' && $target != ''){
			echo '<li><a href="'.$ffffound.'" class="ffffound" title="Ffffound" target="_blank">Ffffound</a></li>';
			} elseif($ffffound != '') {
				echo '<li><a href="'.$ffffound.'" class="ffffound" title="Ffffound">Ffffound</a></li>';
			}
			?>

			<?php if($pinterest != '' && $target != ''){
			echo '<li><a href="'.$pinterest.'" class="pinterest" title="Pinterest" target="_blank">Pinterest</a></li>';
			} elseif($pinterest != '') {
				echo '<li><a href="'.$pinterest.'" class="pinterest" title="Pinterest">Pinterest</a></li>';
			}
			?>

			<?php if($zootool != '' && $target != ''){
				echo '<li><a href="'.$zootool.'" class="zootool" title="Zootool" target="_blank">Zootool</a></li>';
			} elseif($zootool != '') {
				echo '<li><a href="'.$zootool.'" class="zootool" title="Zootool">Zootool</a></li>';
			}
			?>

			<?php if($behance != '' && $target != ''){
				echo '<li><a href="'.$behance.'" class="behance" title="Behance Network" target="_blank">Behance Network</a></li>';
			} elseif($behance != '') {
				echo '<li><a href="'.$behance.'" class="behance" title="Behance Network">Behance Network</a></li>';
			}
			?>

			<?php if($deviantart != '' && $target != ''){
				echo '<li><a href="'.$deviantart.'" class="deviantart" title="deviantART" target="_blank">deviantART</a></li>';
			} elseif($deviantart != '') {
				echo '<li><a href="'.$deviantart.'" class="deviantart" title="deviantART">deviantART</a></li>';
			}
			?>

			<?php if($squidoo != '' && $target != ''){
				echo '<li><a href="'.$squidoo.'" class="squidoo" title="Squidoo" target="_blank">Squidoo</a></li>';
			} elseif($squidoo != '') {
				echo '<li><a href="'.$squidoo.'" class="squidoo" title="Squidoo">Squidoo</a></li>';
			}
			?>

			<?php if($slideshare != '' && $target != ''){
				echo '<li><a href="'.$slideshare.'" class="slideshare" title="Slideshare" target="_blank">Slideshare</a></li>';
			} elseif($slideshare != '') {
				echo '<li><a href="'.$slideshare.'" class="slideshare" title="Slideshare">Slideshare</a></li>';
			}
			?>

			<?php if($lastfm != '' && $target != ''){
				echo '<li><a href="'.$lastfm.'" class="lastfm" title="Lastfm" target="_blank">Lastfm</a></li>';
			} elseif($lastfm != '') {
				echo '<li><a href="'.$lastfm.'" class="lastfm" title="Lastfm">Lastfm</a></li>';
			}
			?>

			<?php if($grooveshark != '' && $target != ''){
				echo '<li><a href="'.$grooveshark.'" class="grooveshark" title="Grooveshark" target="_blank">Grooveshark</a></li>';
			} elseif($grooveshark != '') {
				echo '<li><a href="'.$grooveshark.'" class="grooveshark" title="Grooveshark">Grooveshark</a></li>';
			}
			?>

			<?php if($soundcloud != '' && $target != ''){
				echo '<li><a href="'.$soundcloud.'" class="soundcloud" title="Soundcloud" target="_blank">Soundcloud</a></li>';
			} elseif($soundcloud != '') {
				echo '<li><a href="'.$soundcloud.'" class="soundcloud" title="Soundcloud">Soundcloud</a></li>';
			}
			?>

			<?php if($foursquare != '' && $target != ''){
				echo '<li><a href="'.$foursquare.'" class="foursquare" title="Foursquare" target="_blank">Foursquare</a></li>';
			} elseif($foursquare != '') {
				echo '<li><a href="'.$foursquare.'" class="foursquare" title="Foursquare">Foursquare</a></li>';
			}
			?>

			<?php if($gowalla != '' && $target != ''){
				echo '<li><a href="'.$gowalla.'" class="gowalla" title="Gowalla" target="_blank">Gowalla</a></li>';
			} elseif($gowalla != '') {
				echo '<li><a href="'.$gowalla.'" class="gowalla" title="Gowalla">Gowalla</a></li>';
			}
			?>

			<?php if($linkedin != '' && $target != ''){
				echo '<li><a href="'.$linkedin.'" class="linkedin" title="LinkedIn" target="_blank">LinkedIn</a></li>';
			} elseif($linkedin != '') {
				echo '<li><a href="'.$linkedin.'" class="linkedin" title="LinkedIn">LinkedIn</a></li>';
			}
			?>

			<?php if($xing != '' && $target != ''){
				echo '<li><a href="'.$xing.'" class="xing" title="Xing" target="_blank">Xing</a></li>';
			} elseif($xing != '') {
				echo '<li><a href="'.$xing.'" class="xing" title="Xing">Xing</a></li>';
			}
			?>

			<?php if($wordpress != '' && $target != ''){
				echo '<li><a href="'.$wordpress.'" class="wordpress" title="WordPress" target="_blank">WordPress</a></li>';
			} elseif($wordpress != '') {
				echo '<li><a href="'.$wordpress.'" class="wordpress" title="WordPress">WordPress</a></li>';
			}
			?>

			<?php if($tumblr != '' && $target != ''){
				echo '<li><a href="'.$tumblr.'" class="tumblr" title="Tumblr" target="_blank">Tumblr</a></li>';
			} elseif($tumblr != '') {
				echo '<li><a href="'.$tumblr.'" class="tumblr" title="Tumblr">Tumblr</a></li>';
			}
			?>

			<?php if($rss != '' && $target != ''){
				echo '<li><a href="'.$rss.'" class="rss" title="RSS Feed" target="_blank">RSS Feed</a></li>';
			} elseif($rss != '') {
				echo '<li><a href="'.$rss.'" class="rss" title="RSS Feed">RSS Feed</a></li>';
			}
			?>

			<?php if($rsscomments != '' && $target != ''){
				echo '<li><a href="'.$rsscomments.'" class="rsscomments" title="RSS Comments" target="_blank">RSS Comments</a></li>';
			} elseif($rsscomments != '') {
				echo '<li><a href="'.$rsscomments.'" class="rsscomments" title="RSS Comments">RSS Comments</a></li>';
			}
			?>

		</ul><!-- end .sociallinks -->

		 <?php
		 echo $after_widget;
	 }

	 function update($new_instance, $old_instance) {
			 return $new_instance;
	 }

	 function form($instance) {
		$title = esc_attr($instance['title']);
		$aboutimageurl = esc_attr($instance['aboutimageurl']);
		$abouttext = esc_attr($instance['abouttext']);
		$sociallinkstitle = esc_attr($instance['sociallinkstitle']);
		$twitter = esc_attr($instance['twitter']);
		$facebook = esc_attr($instance['facebook']);
		$googleplus = esc_attr($instance['googleplus']);
		$flickr = esc_attr($instance['flickr']);
		$picasa = esc_attr($instance['picasa']);
		$fivehundredpx = esc_attr($instance['fivehundredpx']);
		$youtube = esc_attr($instance['youtube']);
		$vimeo = esc_attr($instance['vimeo']);
		$dribbble = esc_attr($instance['dribbble']);
		$ffffound = esc_attr($instance['ffffound']);
		$pinterest = esc_attr($instance['pinterest']);
		$zootool = esc_attr($instance['zootool']);
		$behance = esc_attr($instance['behance']);
		$deviantart = esc_attr($instance['deviantart']);
		$squidoo = esc_attr($instance['squidoo']);
		$slideshare = esc_attr($instance['slideshare']);
		$lastfm = esc_attr($instance['lastfm']);
		$grooveshark = esc_attr($instance['grooveshark']);
		$soundcloud = esc_attr($instance['soundcloud']);
		$foursquare = esc_attr($instance['foursquare']);
		$gowalla = esc_attr($instance['gowalla']);
		$linkedin = esc_attr($instance['linkedin']);
		$xing = esc_attr($instance['xing']);
		$wordpress = esc_attr($instance['wordpress']);
		$tumblr = esc_attr($instance['tumblr']);
		$rss = esc_attr($instance['rss']);
		$rsscomments = esc_attr($instance['rsscomments']);
		$target = esc_attr($instance['target']);

		?>

		 <p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
				</p>

			<p>
						<label for="<?php echo $this->get_field_id('aboutimageurl'); ?>"><?php _e('About Image URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('aboutimageurl'); ?>" value="<?php echo $aboutimageurl; ?>" class="widefat" id="<?php echo $this->get_field_id('aboutimageurl'); ?>" />
				</p>

			<p>
						<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('About Text:','kerikeri'); ?></label>
				<textarea name="<?php echo $this->get_field_name('abouttext'); ?>" class="widefat" rows="10" id="<?php echo $this->get_field_id('abouttext'); ?>"><?php echo( $abouttext ); ?></textarea>
				</p>

			 <p>
						<label for="<?php echo $this->get_field_id('sociallinkstitle'); ?>"><?php _e('Social Links Title:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('sociallinkstitle'); ?>" value="<?php echo $sociallinkstitle; ?>" class="widefat" id="<?php echo $this->get_field_id('sociallinkstitle'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $twitter; ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo $facebook; ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php _e('Google+ URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('googleplus'); ?>" value="<?php echo $googleplus; ?>" class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e('Flickr URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('flickr'); ?>" value="<?php echo $flickr; ?>" class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('picasa'); ?>"><?php _e('Picasa URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('picasa'); ?>" value="<?php echo $picasa; ?>" class="widefat" id="<?php echo $this->get_field_id('picasa'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('fivehundredpx'); ?>"><?php _e('500px URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('fivehundredpx'); ?>" value="<?php echo $fivehundredpx; ?>" class="widefat" id="<?php echo $this->get_field_id('fivehundredpx'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo $youtube; ?>" class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('vimeo'); ?>"><?php _e('Vimeo URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('vimeo'); ?>" value="<?php echo $vimeo; ?>" class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php _e('Dribbble URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('dribbble'); ?>" value="<?php echo $dribbble; ?>" class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('ffffound'); ?>"><?php _e('Ffffound URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('ffffound'); ?>" value="<?php echo $ffffound; ?>" class="widefat" id="<?php echo $this->get_field_id('ffffound'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('pinterest'); ?>" value="<?php echo $pinterest; ?>" class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('zootool'); ?>"><?php _e('Zootool URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('zootool'); ?>" value="<?php echo $zootool; ?>" class="widefat" id="<?php echo $this->get_field_id('zootool'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('behance'); ?>"><?php _e('Behance Network URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('behance'); ?>" value="<?php echo $behance; ?>" class="widefat" id="<?php echo $this->get_field_id('behance'); ?>" />
				</p>

		 <p>
						<label for="<?php echo $this->get_field_id('deviantart'); ?>"><?php _e('deviantART URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('deviantart'); ?>" value="<?php echo $deviantart; ?>" class="widefat" id="<?php echo $this->get_field_id('deviantart'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('squidoo'); ?>"><?php _e('Squidoo URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('squidoo'); ?>" value="<?php echo $squidoo; ?>" class="widefat" id="<?php echo $this->get_field_id('squidoo'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('slideshare'); ?>"><?php _e('Slideshare URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('slideshare'); ?>" value="<?php echo $slideshare; ?>" class="widefat" id="<?php echo $this->get_field_id('slideshare'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('lastfm'); ?>"><?php _e('Last.fm URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('lastfm'); ?>" value="<?php echo $lastfm; ?>" class="widefat" id="<?php echo $this->get_field_id('lastfm'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('grooveshark'); ?>"><?php _e('Grooveshark URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('grooveshark'); ?>" value="<?php echo $grooveshark; ?>" class="widefat" id="<?php echo $this->get_field_id('grooveshark'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('soundcloud'); ?>"><?php _e('Soundcloud URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('soundcloud'); ?>" value="<?php echo $soundcloud; ?>" class="widefat" id="<?php echo $this->get_field_id('soundcloud'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('foursquare'); ?>"><?php _e('Foursquare URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('foursquare'); ?>" value="<?php echo $foursquare; ?>" class="widefat" id="<?php echo $this->get_field_id('foursquare'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('gowalla'); ?>"><?php _e('Gowalla URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('gowalla'); ?>" value="<?php echo $gowalla; ?>" class="widefat" id="<?php echo $this->get_field_id('gowalla'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('linkedin'); ?>" value="<?php echo $linkedin; ?>" class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('xing'); ?>"><?php _e('Xing URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('xing'); ?>" value="<?php echo $xing; ?>" class="widefat" id="<?php echo $this->get_field_id('xing'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('wordpress'); ?>"><?php _e('WordPress URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('wordpress'); ?>" value="<?php echo $wordpress; ?>" class="widefat" id="<?php echo $this->get_field_id('wordpress'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('tumblr'); ?>"><?php _e('Tumblr URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('tumblr'); ?>" value="<?php echo $tumblr; ?>" class="widefat" id="<?php echo $this->get_field_id('tumblr'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS-Feed URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('rss'); ?>" value="<?php echo $rss; ?>" class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('rsscomments'); ?>"><?php _e('RSS for Comments URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('rsscomments'); ?>" value="<?php echo $rsscomments; ?>" class="widefat" id="<?php echo $this->get_field_id('rsscomments'); ?>" />
				</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['target'], true ); ?> id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>" <?php checked( $target, 'on' ); ?>> <?php _e('Open all social links in a new browser tab', 'kerikeri'); ?></input>
		</p>

		<?php
	}
}

register_widget('kerikeri_about');


/*-----------------------------------------------------------------------------------*/
/* Include a custom Flickr Widget
/*-----------------------------------------------------------------------------------*/

class kerikeri_flickr extends WP_Widget {

	public function __construct() {
		parent::__construct( 'kerikeri_flickr', __( 'Flickr Widget', 'kerikeri' ), array(
			'classname'   => 'widget_kerikeri_flickr',
			'description' => __( 'Show some Flickr preview images.', 'kerikeri' ),
		) );
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$id = $instance['id'];
		$linktext = $instance['linktext'];
		$linkurl = $instance['linkurl'];
		$number = $instance['number'];
		$type = $instance['type'];
		$sorting = $instance['sorting'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

				<div class="flickr_badge_wrapper"><script type="text/javascript" src="https://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=<?php echo $sorting; ?>&amp;&amp;source=<?php echo $type; ?>&amp;<?php echo $type; ?>=<?php echo $id; ?>&amp;size=m"></script>
			<div class="clear"></div>
			<?php if($linktext == ''){echo '';} else {echo '<div class="flickr-bottom"><a href="'.$linkurl.'" class="flickr-home" target="_blank">'.$linktext.'</a></div>';}?>
		</div><!-- end .flickr_badge_wrapper -->

		 <?php
		 echo $after_widget;
	 }

	 function update($new_instance, $old_instance) {
			 return $new_instance;
	 }

	 function form($instance) {
		$title = esc_attr($instance['title']);
		$id = esc_attr($instance['id']);
		$linktext = esc_attr($instance['linktext']);
		$linkurl = esc_attr($instance['linkurl']);
		$number = esc_attr($instance['number']);
		$type = esc_attr($instance['type']);
		$sorting = esc_attr($instance['sorting']);
		?>

		 <p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
				</p>

				<p>
						<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Flickr ID:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" />
				</p>

			<p>
						<label for="<?php echo $this->get_field_id('linktext'); ?>"><?php _e('Flickr Profile Link Text:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('linktext'); ?>" value="<?php echo $linktext; ?>" class="widefat" id="<?php echo $this->get_field_id('linktext'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('linkurl'); ?>"><?php _e('Flickr Profile URL:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('linkurl'); ?>" value="<?php echo $linkurl; ?>" class="widefat" id="<?php echo $this->get_field_id('linkurl'); ?>" />
				</p>

				 <p>
						<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photos:','kerikeri'); ?></label>
						<select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
								<?php for ( $i = 1; $i <= 10; $i += 1) { ?>
								<option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
								<?php } ?>
						</select>
				</p>

				<p>
						<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Choose user or group:','kerikeri'); ?></label>
						<select name="<?php echo $this->get_field_name('type'); ?>" class="widefat" id="<?php echo $this->get_field_id('type'); ?>">
								<option value="user" <?php if($type == "user"){ echo "selected='selected'";} ?>><?php _e('User', 'kerikeri'); ?></option>
								<option value="group" <?php if($type == "group"){ echo "selected='selected'";} ?>><?php _e('Group', 'kerikeri'); ?></option>
						</select>
				</p>
				<p>
						<label for="<?php echo $this->get_field_id('sorting'); ?>"><?php _e('Show latest or random pictures:','kerikeri'); ?></label>
						<select name="<?php echo $this->get_field_name('sorting'); ?>" class="widefat" id="<?php echo $this->get_field_id('sorting'); ?>">
								<option value="latest" <?php if($sorting == "latest"){ echo "selected='selected'";} ?>><?php _e('Latest', 'kerikeri'); ?></option>
								<option value="random" <?php if($sorting == "random"){ echo "selected='selected'";} ?>><?php _e('Random', 'kerikeri'); ?></option>
						</select>
				</p>
		<?php
	}
}

register_widget('kerikeri_flickr');

/*-----------------------------------------------------------------------------------*/
/* Include a custom Video Widget
/*-----------------------------------------------------------------------------------*/

class kerikeri_video extends WP_Widget {

	public function __construct() {
		parent::__construct( 'kerikeri_video', __( 'Video Widget', 'kerikeri' ), array(
			'classname'   => 'widget_kerikeri_video',
			'description' => __( 'Show a custom featured video.', 'kerikeri' ),
		) );
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$embedcode = $instance['embedcode'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

				<div class="video_widget">
			<div class="featured-video"><?php echo $embedcode; ?></div>
			</div><!-- end .video_widget -->

		 <?php
		 echo $after_widget;
	 }

	 function update($new_instance, $old_instance) {
			 return $new_instance;
	 }

	 function form($instance) {
		$title = esc_attr($instance['title']);
		$embedcode = esc_attr($instance['embedcode']);
		?>

		 <p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','kerikeri'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
				</p>

				<p>
						<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Video embed code:','kerikeri'); ?></label>
				<textarea name="<?php echo $this->get_field_name('embedcode'); ?>" class="widefat" rows="6" id="<?php echo $this->get_field_id('embedcode'); ?>"><?php echo( $embedcode ); ?></textarea>
				</p>

		<?php
	}
}

register_widget('kerikeri_video');
