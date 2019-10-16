<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package lmpizza
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function lmpizza_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'lmpizza_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function lmpizza_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'lmpizza_pingback_header' );

function lmpizza_login_logo() { 
	?>
		<style type="text/css">
			#login h1 a, .login h1 a {
				background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo-round.png);
				background-size: contain;
				height:200px;
				width:300px;
				background-repeat: no-repeat;
				padding-bottom: 10px;
			}

			.login p.message{
				border-left: 4px solid #83253C;
			}

			.login p.submit input,
			#wp-submit.button.button-primary.button-large {
				background: #83253C;
				border-color: #621c2e;
				color: #FEE06E;
				text-shadow: none;
			}

			input#user_login.input,
			input#user_pass.input {
				border-color: #621c2e;
			}

		</style>
	<?php 
	}
add_action( 'login_enqueue_scripts', 'lmpizza_login_logo' );

function lmpizza_login_logo_url() {
	return home_url();
} 
add_filter( 'login_headerurl', 'lmpizza_login_logo_url'	);
	
function lmpizza_login_logo_url_title() {
	return 'La Migliore Pizzeria';
} 
add_filter( 'login_headertitle', 'lmpizza_login_logo_url_title' );