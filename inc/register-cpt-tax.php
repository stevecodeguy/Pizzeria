<?php
function ms_register_custom_post_types()
{
    // Registers Testimonial CPT
    $labels = array(
        'name' => _x('Testimonials', 'post type general name'),
        'singular_name' => _x('Testimonial', 'post type singular name'),
        'menu_name' => _x('Testimonials', 'admin menu'),
        'name_admin_bar' => _x('Testimonial', 'add new on admin bar'),
        'add_new' => _x('Add New', 'testimonial'),
        'add_new_item' => __('Add New Testimonial'),
        'new_item' => __('New Testimonial'),
        'edit_item' => __('Edit Testimonial'),
        'view_item' => __('View Testimonial'),
        'all_items' => __('All Testimonials'),
        'search_items' => __('Search Testimonials'),
        'parent_item_colon' => __('Parent Testimonials:'),
        'not_found' => __('No testimonials found.'),
        'not_found_in_trash' => __('No testimonials found in Trash.'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'testimonials'),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-heart',
        'supports' => array('title', 'editor'),
        'template' => array(array('core/quote')),
        'template_lock' => 'all',
    );

    register_post_type('ms-testimonial', $args);




// Registers Deals CPT

$labels = array(
    'name'               => _x( 'Deals', 'post type general name' ),
    'singular_name'      => _x( 'Deal', 'post type singular name'),
    'menu_name'          => _x( 'Deals', 'admin menu' ),
    'name_admin_bar'     => _x( 'Deal', 'add new on admin bar' ),
    'add_new'            => _x( 'Add New', 'deal' ),
    'add_new_item'       => __( 'Add New Deal' ),
    'new_item'           => __( 'New Deal' ),
    'edit_item'          => __( 'Edit Seal' ),
    'view_item'          => __( 'View deal' ),
    'all_items'          => __( 'All Deals' ),
    'search_items'       => __( 'Search Deals' ),
    'parent_item_colon'  => __( 'Parent Deals:' ),
    'not_found'          => __( 'No deals found.' ),
    'not_found_in_trash' => __( 'No deals found in Trash.' ),
    'archives'           => __( 'Deal Archives'),
    'insert_into_item'   => __( 'Insert into deal'),
    'uploaded_to_this_item' => __( 'Uploaded to this deal'),
    'filter_item_list'   => __( 'Filter deals list'),
    'items_list_navigation' => __( 'Deals list navigation'),
    'items_list'         => __( 'Deals list'),
    'featured_image'     => __( 'Deal feature image'),
    'set_featured_image' => __( 'Set deal feature image'),
    'remove_featured_image' => __( 'Remove deal feature image'),
    'use_featured_image' => __( 'Use as feature image'),
);

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'show_in_nav_menus'  => true,
    'show_in_admin_bar'  => true,
    'show_in_rest'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'deal' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 5,
    'menu_icon'          => 'dashicons-archive',
    'supports'           => array( 'title', 'thumbnail', 'editor' ),
);

    register_post_type('ms-deals', $args);

}
add_action('init', 'ms_register_custom_post_types');

function ms_rewrite_flush()
{
    ms_register_custom_post_types();
    ms_register_taxonomies();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'ms_rewrite_flush');
