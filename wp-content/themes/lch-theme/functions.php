<?php
// Enqueue parent theme styles
function lch_enqueue_styles() {
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-style' )
    );
}
add_action( 'wp_enqueue_scripts', 'lch_enqueue_styles' );

// Register Custom Post Type: Listings
function lch_register_listings_cpt() {
    $labels = array(
        'name'               => 'Listings',
        'singular_name'      => 'Listing',
        'menu_name'          => 'Listings',
        'add_new'            => 'Add New Listing',
        'add_new_item'       => 'Add New Listing',
        'edit_item'          => 'Edit Listing',
        'new_item'           => 'New Listing',
        'view_item'          => 'View Listing',
        'search_items'       => 'Search Listings',
        'not_found'          => 'No listings found',
        'not_found_in_trash' => 'No listings found in Trash',
    );

    $args = array(
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => array( 'slug' => 'listings' ),
        'supports'     => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon'    => 'dashicons-store',
        'show_in_rest' => true,
    );

    register_post_type( 'listing', $args );
}
add_action( 'init', 'lch_register_listings_cpt' );

// Register Taxonomies
function lch_register_listing_taxonomies() {

    $category_labels = array(
        'name'          => 'Listing Categories',
        'singular_name' => 'Listing Category',
        'search_items'  => 'Search Categories',
        'all_items'     => 'All Categories',
        'edit_item'     => 'Edit Category',
        'add_new_item'  => 'Add New Category',
        'menu_name'     => 'Categories',
    );

    register_taxonomy( 'listing_category', 'listing', array(
        'labels'       => $category_labels,
        'hierarchical' => true,
        'rewrite'      => array( 'slug' => 'listing-category' ),
        'show_in_rest' => true,
    ));

    $tag_labels = array(
        'name'          => 'Listing Tags',
        'singular_name' => 'Listing Tag',
        'search_items'  => 'Search Tags',
        'all_items'     => 'All Tags',
        'edit_item'     => 'Edit Tag',
        'add_new_item'  => 'Add New Tag',
        'menu_name'     => 'Tags',
    );

    register_taxonomy( 'listing_tag', 'listing', array(
        'labels'       => $tag_labels,
        'hierarchical' => false,
        'rewrite'      => array( 'slug' => 'listing-tag' ),
        'show_in_rest' => true,
    ));
}
add_action( 'init', 'lch_register_listing_taxonomies' );

// Load ACF field group definitions
if ( file_exists( get_stylesheet_directory() . '/inc/acf-fields.php' ) ) {
    include_once get_stylesheet_directory() . '/inc/acf-fields.php';
}