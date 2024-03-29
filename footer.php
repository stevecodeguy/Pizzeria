<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package lmpizza
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<a href="<?php echo esc_url(__('https://wordpress.org/', 'lmpizza')); ?>">
				<?php
/* translators: %s: CMS name, i.e. WordPress. */
// printf( esc_html__( 'Proudly powered by %s', 'lmpizza' ), 'WordPress' );
?>
			</a>
			<span class="sep">  </span>


<!-- Social Media Links -->

<nav id="social-navigation" class="social-navigation">
<?php
wp_nav_menu(array(
    'theme_location' => 'social',
    'menu_id' => 'social-menu',
));

echo '<p class="copyright-text">Copyright © 2019, All Rights Reserved</p>';
?>
</nav><!-- #site-navigation -->

				<?php

/* translators: 1: Theme name, 2: Theme author. */
// printf( esc_html__( 'Theme: %1$s by %2$s.', 'lmpizza' ), 'lmpizza', '<a href="http://underscores.me/">Underscores.me</a>' );
?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer();?>

</body>
</html>
