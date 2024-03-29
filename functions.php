<?php
/**
 * lmpizza functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package lmpizza
 */

if (!function_exists('lmpizza_setup')):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function lmpizza_setup()
{
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on lmpizza, use a find and replace
         * to change 'lmpizza' to the name of your theme in all the template files.
         */
        load_theme_textdomain('lmpizza', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'lmpizza'),
            'menu-2' => esc_html__('secondary', 'lmpizza'),
            'social' => esc_html__('Social Menu Location', 'lmpizza'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('lmpizza_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        ));
    }
endif;
add_action('after_setup_theme', 'lmpizza_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lmpizza_content_width()
{
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('lmpizza_content_width', 640);
}
add_action('after_setup_theme', 'lmpizza_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
// function lmpizza_widgets_init()
// {
//     register_sidebar(array(
//         'name' => esc_html__('Sidebar', 'lmpizza'),
//         'id' => 'sidebar-1',
//         'description' => esc_html__('Add widgets here.', 'lmpizza'),
//         'before_widget' => '<section id="%1$s" class="widget %2$s">',
//         'after_widget' => '</section>',
//         'before_title' => '<h2 class="widget-title">',
//         'after_title' => '</h2>',
//     ));
// }
// add_action('widgets_init', 'lmpizza_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function lmpizza_scripts()
{
    wp_enqueue_style('lmpizza-font', 'https://fonts.googleapis.com/css?family=Great+Vibes|Raleway:300,400,500,600,700|Roboto:300,400,500,700,900&display=swap');

    wp_enqueue_style('lmpizza-style', get_stylesheet_uri());

    wp_enqueue_script('lmpizza-map', get_template_directory_uri() . '/js/map.js', array('jquery'), '20190923', true);

    wp_enqueue_script('google-map', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAp6PoLDNvrN3WlJh9qsKwGJyrsPuTPhZo');

    wp_enqueue_script('lmpizza-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);

    wp_enqueue_script('lmpizza-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

    //Slick Slider only for the Home page
    if (is_front_page()) {

        wp_enqueue_script(
            'mindset-slickslider',
            get_template_directory_uri() . '/js/slick.min.js',
            array('jquery'),
            '20190827',
            true
        );

        wp_enqueue_script(
            'mindset-slickslider-settings',
            get_template_directory_uri() . '/js/slick-settings.js',
            array('jquery', 'mindset-slickslider'),
            '20190827',
            true
        );

        wp_enqueue_style(
            'mindset-slicktheme',
            get_template_directory_uri() . '/css/slick-theme.css'
        );

        wp_enqueue_style(
            'mindset-slick',
            get_template_directory_uri() . '/css/slick.css'
        );
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'lmpizza_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Register CPTs and Taxonomies
 */
require get_template_directory() . '/inc/register-cpt-tax.php';

function my_remove_lightbox()
{
    remove_theme_support('wc-product-gallery-zoom');
}
add_action('init', 'my_remove_lightbox');


if( function_exists('acf_add_options_page') ) {
	function my_acf_init()
    {
        acf_update_setting('google_api_key', 'AIzaSyAp6PoLDNvrN3WlJh9qsKwGJyrsPuTPhZo');
    }
    add_action('acf/init', 'my_acf_init');
        
    acf_add_options_page();

    function register_acf_options_pages() {

        // register options page.
        $option_page = acf_add_options_page(array(
            'page_title'    => __('Theme General Settings'),
            'menu_title'    => __('Theme Settings'),
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }
    
    // Hook into acf initialization.
    add_action('acf/init', 'register_acf_options_pages');
}

