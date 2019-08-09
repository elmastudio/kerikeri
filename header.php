<?php
/**
 * The themes header file.
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */
?><!DOCTYPE html>
<!--[if lte IE 8]>
<html class="ie" <?php language_attributes(); ?>>
<![endif]-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.css">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	$options = get_option('kerikeri_theme_options');
	if( $options['custom_favicon'] != '' ) : ?>
<link rel="shortcut icon" type="image/ico" href="<?php echo $options['custom_favicon']; ?>" />
<?php endif  ?>
<?php
	$options = get_option('kerikeri_theme_options');
	if( $options['custom_apple_icon'] != '' ) : ?>
<link rel="apple-touch-icon" href="<?php echo $options['custom_apple_icon']; ?>" />
<?php endif  ?>

<!-- HTML5 enabling script for IE7+8 -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php
	wp_enqueue_script('jquery');
	if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );
	wp_head();
?>

</head>

<body <?php body_class(); ?>>

	<div id="wrap" class="clearfix">
		<header id="header">

		<div id="site-nav-wrap">
			<div id="site-nav">
				<ul class="site-menu">
						<li class="site-menu-item-home"><a href="<?php echo home_url( '/' ); ?>" class="site-nav-btn icon-home"><span><?php _e('Home', 'kerikeri') ?></span></a></li>
					<?php if ( is_active_sidebar( 'widget-area-about' ) ) : ?>
						<li class="site-menu-item-about"><a href="#widget-area-about" class="site-nav-btn icon-user"><span><?php _e('About', 'kerikeri') ?></span></a></li>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'widget-area-tags' ) ) : ?>
						<li class="site-menu-item-tags"><a href="#widget-area-tags" class="site-nav-btn icon-tags"><span><?php _e('Tags', 'kerikeri') ?></span></a></li>
					<?php endif; ?>
						<li class="site-menu-item-top"><a href="#header" class="site-nav-btn icon-arrow-up"><span><?php _e('Top', 'kerikeri') ?></span></a></li>
				</ul>
				<a href="#" class="search-nav-btn icon-search"><span><?php _e('Search', 'kerikeri') ?></span></a>
						<div class="site-search">
							<?php get_search_form(); ?>
						</div><!-- end .site-search -->
			</div><!-- end #site-nav -->
		</div><!-- end #site-nav-wrap -->

			<div id="branding">
				<div id="site-title">
					<?php $options = get_option('kerikeri_theme_options');
						if( $options['custom_logo'] != '' ) : ?>
						<a href="<?php echo home_url( '/' ); ?>" class="logo"><img src="<?php echo $options['custom_logo']; ?>" alt="<?php bloginfo('name'); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
					<?php else: ?>
						<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
					<?php endif  ?>
				</div><!-- end #site-title -->

			</div><!-- end #branding -->

		</header><!-- end #header -->
