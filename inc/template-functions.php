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


//Remove menus in back end
function lmpizza_edit_admin_menus() {
	remove_menu_page('edit.php'); // Remove Posts
	remove_menu_page('edit-comments.php'); // Remove Comments
    remove_submenu_page('themes.php','theme-editor.php');
}
add_action( 'admin_menu', 'lmpizza_edit_admin_menus' );

//RESTRICTED FOR specific USERS

function lmpizza_remove_menus()
{
    global $menu;
    global $current_user;
    get_currentuserinfo();
 
    if($current_user->roles == 'contributor')
    {
        $restricted = array(__('Media'),
                            __('Links'),
                            __('Pages'),
                            __('Comments'),
                            __('Appearance'),
                            __('Plugins'),
                            __('Users'),
                            __('Tools'),
                            __('Settings')
        );
        end ($menu);
        while (prev($menu)){
            $value = explode(' ',$menu[key($menu)][0]);
            if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
        }// end while
 
    }// end if
}
add_action('admin_menu', 'lmpizza_remove_menus');

/**
 * custom dashboard widget added
 */
function lmpizza_custom_dashboard_widget() {
	echo "<p>Welcome to the back end of La Migliore. Please find instructions below on how to use this site:</p> <p><a href='https://pizzeria.bcitwebdeveloper.ca/wp-content/uploads/2019/10/La-Migliore-Pizza-Tutorial-Guide.docx'>Click Here!</a></p>";
}

function lmpizza_add_custom_dashboard_widget() {
	wp_add_dashboard_widget('lmpizza_custom_dashboard_widget', 'How to Use - Instructional', 'lmpizza_custom_dashboard_widget');
}
add_action('wp_dashboard_setup', 'lmpizza_add_custom_dashboard_widget');


// disable default dashboard widgets
function lmpizza_disable_default_dashboard_widgets() {
 
	//remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	remove_meta_box('dashboard_activity', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');
 
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}
add_action('admin_menu', 'lmpizza_disable_default_dashboard_widgets');

function lmpizza_remove_metabox() {
	remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', 'lmpizza_remove_metabox' );

//Change greeting
function lmpizza_replace_wordpress_howdy( $wp_admin_bar ) {
	$my_account = $wp_admin_bar->get_node('my-account');
	$newtext = str_replace( 'Howdy,', 'Greetings Pizza Hero, ',  $my_account->title );
	$wp_admin_bar->add_node( array(
		'id' => 'my-account',
		'title' => $newtext,
	) );
}
add_filter( 'admin_bar_menu', 'lmpizza_replace_wordpress_howdy', 25 );