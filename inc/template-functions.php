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




// add_action( 'after_setup_theme', 'relaunch_content_width', 0 );
//has to be under action hook
//ReNAME dashboard Menu ITEMS

function edit_admin_menus() {
    global $menu;
    global $submenu;
    
    // $menu[5][0] = 'Recipes'; // Change Posts to Recipes
    // $submenu['edit.php'][5][0] = 'All Recipes';
    // $submenu['edit.php'][10][0] = 'Add a Recipe';
    // $submenu['edit.php'][15][0] = 'Meal Types'; // Rename categories to meal types
	// $submenu['edit.php'][16][0] = 'Ingredients'; // Rename tags to ingredients

	//Removing
	// remove_menu_page('edit.php?post_type=acf-field-group'); // Remove the plugin acf 
	remove_menu_page('edit.php'); // Remove Posts
	remove_menu_page('edit-comments.php'); // Remove Comments
    remove_submenu_page('themes.php','theme-editor.php');
}
add_action( 'admin_menu', 'edit_admin_menus' );

//Activate Custom menu order & The order of the menus is top to bottom!
// function custom_menu_order($menu_ord) {
// 	if (!$menu_ord) return true;
// 	return array(
// 		'index.php', // Dashboard
// 		'edit.php', // Posts
// 		'upload.php', // Media
// 		'link-manager.php', // Links
// 		'edit.php?post_type=page', // Pages
// 		'edit-comments.php', // Comments
// 		'themes.php', // Appearance
// 		'plugins.php', // Plugins
// 		'users.php', // Users
// 		'tools.php', // Tools
// 		'options-general.php', // Settings
		
// 	);
// }
// add_filter('custom_menu_order', 'custom_menu_order');
// add_filter('menu_order', 'custom_menu_order');

//RESTRICTED FOR specific USERS

function remove_menus()
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
add_action('admin_menu', 'remove_menus');