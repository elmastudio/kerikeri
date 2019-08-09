 <?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Kerikeri
 * @since Kerikeri 1.0
 */
?>

	<footer id="footer">

		<nav id="page-nav">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'depth' => 1 ) ); ?>
		</nav><!-- end #page-nav -->

		<div id="site-generator" class="clearfix">
			<?php
				$options = get_option('kerikeri_theme_options');
				if($options['custom_footertext'] != '' ){
					echo stripslashes($options['custom_footertext']);
			} else { ?>

			<ul class="credit">
				<li>&copy; <?php echo date('Y'); ?> <?php bloginfo(); ?></li>
				<li><?php _e('<span class="slash"> //</span> Proudly powered by', 'kerikeri') ?> <a href="https://wordpress.org/" ><?php _e('WordPress', 'kerikeri') ?></a></li>
				<li><?php printf( __( '<span class="slash"> //</span> Theme: %1$s by %2$s', 'kerikeri' ), 'Kerikeri', '<a href="https://www.elmastudio.de/en/">Elmastudio</a>' ); ?></li>
				<?php } ?>
			</ul>
		</div><!-- end #site-generator -->

		<a href="#header" class="top icon-chevron-up"><span><?php _e('Back to Top', 'kerikeri') ?></span></a>

	</footer><!-- end #footer -->
	</div><!-- end #content -->
</div><!-- end #wrap -->

<?php // Includes Twitter, Facebook and Google+ button code if the share post option is active.
	$options = get_option('kerikeri_theme_options');
	if($options['share-singleposts'] or $options['share-posts'] or $options['share-pages']) : ?>
	<script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
	<script type="text/javascript">
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
	</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/<?php _e('en_US', 'kerikeri') ?>/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
