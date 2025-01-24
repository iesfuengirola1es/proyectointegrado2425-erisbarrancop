<?php
// Enqueue parent and child theme styles
function twentytwentyfive_child_enqueue_styles() {
    wp_enqueue_style('twentytwentyfive-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('twentytwentyfive-child-style', get_stylesheet_uri(), array('twentytwentyfive-parent-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('google-font-lato', 'https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_enqueue_styles');

// function add_identity_site(){
//     // Add support for site title and tagline
//     add_theme_support('title-tag');
//     add_theme_support('custom-logo');
// }

// add_action( 'after_setup_theme', 'add_identity_site' );

// Register Custom Post Types for Singles, Albums, Vinyls
function music_store_custom_post_types() {

    // Register Singles Post Type
    register_post_type('single', array(
        'labels' => array(
            'name' => __('Singles'),
            'singular_name' => __('Single'),
            'add_new' => __('Add New Single'),
            'add_new_item' => __('Add New Single'),
            'edit_item' => __('Edit Single'),
            'new_item' => __('New Single'),
            'view_item' => __('View Single'),
            'search_items' => __('Search Singles'),
            'not_found' => __('No Singles found'),
            'not_found_in_trash' => __('No Singles found in Trash'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'singles'),
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-format-audio', 
    ));

    // Register Albums Post Type
    register_post_type('album', array(
        'labels' => array(
            'name' => __('Albums'),
            'singular_name' => __('Album'),
            'add_new' => __('Add New Album'),
            'add_new_item' => __('Add New Album'),
            'edit_item' => __('Edit Album'),
            'new_item' => __('New Album'),
            'view_item' => __('View Album'),
            'search_items' => __('Search Albums'),
            'not_found' => __('No Albums found'),
            'not_found_in_trash' => __('No Albums found in Trash'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'albums'),
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-album', 
    ));

    // Register Vinyls Post Type
    register_post_type('vinyl', array(
        'labels' => array(
            'name' => __('Vinyls'),
            'singular_name' => __('Vinyl'),
            'add_new' => __('Add New Vinyl'),
            'add_new_item' => __('Add New Vinyl'),
            'edit_item' => __('Edit Vinyl'),
            'new_item' => __('New Vinyl'),
            'view_item' => __('View Vinyl'),
            'search_items' => __('Search Vinyls'),
            'not_found' => __('No Vinyls found'),
            'not_found_in_trash' => __('No Vinyls found in Trash'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'vinyls'),
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-sos', 
    ));
}

// Register Artists Post Type
register_post_type('artist', array(
    'labels' => array(
        'name' => __('Artists'),
        'singular_name' => __('Artist'),
        'add_new' => __('Add New Artist'),
        'add_new_item' => __('Add New Artist'),
        'edit_item' => __('Edit Artist'),
        'new_item' => __('New Artist'),
        'view_item' => __('View Artist'),
        'search_items' => __('Search Artists'),
        'not_found' => __('No Artists found'),
        'not_found_in_trash' => __('No Artists found in Trash'),
    ),
    'public' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'artists'),
    'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
    'menu_icon' => 'dashicons-star-filled', 
));

// // Add custom user role for Artists
// function add_artist_role() {
//     add_role('artist', __('Artist'), array(
//         'read' => true,
//         'edit_posts' => true,
//         'delete_posts' => false,
//         'publish_posts' => true,
//         'upload_files' => true,
//     ));
// }
// add_action('init', 'add_artist_role');

// Hook into the 'init' action
add_action('init', 'music_store_custom_post_types');

//artists-single.php artists-archive.php
//albums-single.php albums-archive.php
//vinyls-single.php vinyls-archive.php

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     return $classes;
}