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
        'capability_type' => array('single', 'singles'),
        'capabilities' => array(
            'edit_post'   => 'edit_single',
            'edit_posts'  => 'edit_singles',
            'publish_posts' => 'publish_singles',
            'delete_post' => 'delete_single',
        ),
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
        'capability_type' => array('album', 'albums'),
        'capabilities' => array(
            'edit_post'   => 'edit_album',
            'edit_posts'  => 'edit_albums',
            'publish_posts' => 'publish_albums',
            'delete_post' => 'delete_album',
        ),
        'menu_icon' => 'dashicons-album', 
    ));

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
        'capability_type' => array('artist', 'artists'),
        'capabilities' => array(
            'edit_post'   => 'edit_artist',
            'edit_posts'  => 'edit_artists',
            'publish_posts' => 'publish_artists',
            'delete_post' => 'delete_artist',
        ),
        'menu_icon' => 'dashicons-star-filled', 
    ));
}

add_action('init', 'music_store_custom_post_types');

function grant_admin_custom_post_caps() {
    $admin = get_role('administrator');
    
    if ($admin) {
        // Allow admin to manage Singles
        $admin->add_cap('edit_single');
        $admin->add_cap('edit_singles');
        $admin->add_cap('publish_singles');
        $admin->add_cap('delete_single');
        $admin->add_cap('edit_others_singles');
        $admin->add_cap('delete_others_singles');

        // Allow admin to manage Albums
        $admin->add_cap('edit_album');
        $admin->add_cap('edit_albums');
        $admin->add_cap('publish_albums');
        $admin->add_cap('delete_album');
        $admin->add_cap('edit_others_albums');
        $admin->add_cap('delete_others_albums');

        // Allow admin to manage Artists
        $admin->add_cap('edit_artist');
        $admin->add_cap('edit_artists');
        $admin->add_cap('publish_artists');
        $admin->add_cap('delete_artist');
        $admin->add_cap('edit_others_artists');
        $admin->add_cap('delete_others_artists');
    }
}
add_action('admin_init', 'grant_admin_custom_post_caps');



function add_artist_role() {
    add_role('artist', __('Artist'), array(
        'read' => true,
        'edit_posts' => false, // Prevent general post editing
        'delete_posts' => false,
        'publish_posts' => false,
        'upload_files' => true,
    ));

    $role = get_role('artist');

    if ($role) {
        // Allow artists to manage their own albums and singles
        $role->add_cap('edit_album');
        $role->add_cap('edit_albums');
        $role->add_cap('publish_albums');
        $role->add_cap('delete_album');
        $role->add_cap('edit_single');
        $role->add_cap('edit_singles');
        $role->add_cap('publish_singles');
        $role->add_cap('delete_single');

        // Allow editing only their own artist page
        $role->add_cap('publish_artist');
        $role->add_cap('publish_artists');
        $role->add_cap('edit_artist');
        $role->add_cap('edit_own_artist');
        $role->add_cap('edit_published_artists');
        $role->add_cap('delete_artist');
    }
}
add_action('init', 'add_artist_role');

function handle_artist_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artist_name'], $_POST['artist_genre'], $_POST['location'])) {
        $current_user = wp_get_current_user();

        // Ensure the user is a subscriber before proceeding
        if (in_array('subscriber' || 'artist', $current_user->roles)) {
            $artist_name = sanitize_text_field($_POST['artist_name']);

            // Create the new Artist post
            $artist_post = [
                'post_title'   => $artist_name,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_author'  => $current_user->ID,
                'post_type'    => 'artist',
            ];
            $post_id = wp_insert_post($artist_post);

            if ($post_id) {
                // Update ACF fields
                update_field('artist_genre', sanitize_text_field($_POST['artist_genre']), $post_id);
                update_field('location', sanitize_text_field($_POST['location']), $post_id);
                update_field('artist_user', $current_user->ID, $post_id);

                // Handle featured image upload
                if (!empty($_FILES['artist_image']['name'])) {
                    require_once ABSPATH . 'wp-admin/includes/image.php';
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';

                    $attachment_id = media_handle_upload('artist_image', $post_id);
                    if (!is_wp_error($attachment_id)) {
                        set_post_thumbnail($post_id, $attachment_id); // Set featured image
                    }
                }

                // Change user role to Artist
                $current_user->remove_role('subscriber');
                $current_user->add_role('artist');

                // Redirect to the new artist profile
                wp_redirect(get_permalink($post_id));
                exit;
            }
        }
    }
}
add_action('init', 'handle_artist_form_submission');

function handle_single_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['single_title'], $_POST['single_genre'], $_POST['single_duration'])) {
        $current_user = wp_get_current_user();

        // Ensure the user has the 'artist' role before proceeding
        if (array_intersect(['artist', 'administrator'], $current_user->roles)) {
            $single_title = sanitize_text_field($_POST['single_title']);
            $single_genre = sanitize_text_field($_POST['single_genre']);
            $single_duration = sanitize_text_field($_POST['single_duration']);
            $artist_paypal_email = sanitize_email($_POST['artist_paypal_email']);
            $artist_id = intval($_POST['artist_id']);

            // Create the new Single post
            $single_post = [
                'post_title'   => $single_title,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_author'  => $current_user->ID,
                'post_type'    => 'single',
            ];
            $post_id = wp_insert_post($single_post);

            if ($post_id) {
                // Update ACF fields
                update_field('genre', $single_genre, $post_id);
                update_field('duration', $single_duration, $post_id);
                update_field('related_artist', $artist_id, $post_id);
                update_field('artist_paypal_email', $artist_id, $post_id);

                // Handle featured image upload
                if (!empty($_FILES['single_image']['name'])) {
                    require_once ABSPATH . 'wp-admin/includes/image.php';
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';

                    $attachment_id = media_handle_upload('single_image', $post_id);
                    if (!is_wp_error($attachment_id)) {
                        set_post_thumbnail($post_id, $attachment_id);
                    }
                }

                // Handle audio file upload
                if (!empty($_FILES['single_audio']['name'])) {
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';

                    $audio_id = media_handle_upload('single_audio', $post_id);
                    if (!is_wp_error($audio_id)) {
                        update_field('track', $audio_id, $post_id);
                    }
                }

                // Redirect to the new single post
                wp_redirect(get_permalink($post_id));
                exit;
            }
        }
    }
}
add_action('init', 'handle_single_form_submission');

function handle_album_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['album_title'], $_POST['album_genre'], $_POST['artist_id'])) {
        $current_user = wp_get_current_user();

        // Ensure only artists and administrators can submit
        if (array_intersect(['artist', 'administrator'], $current_user->roles)) {
            $album_title = sanitize_text_field($_POST['album_title']);
            $album_genre = sanitize_text_field($_POST['album_genre']);
            $album_duration = sanitize_text_field($_POST['album_duration']);
            $album_tracklist = sanitize_textarea_field($_POST['album_tracklist']);
            $artist_paypal_email = sanitize_email($_POST['artist_paypal_email']);
            $artist_id = intval($_POST['artist_id']);

            // Create the new Album post
            $album_post = [
                'post_title'   => $album_title,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_author'  => $current_user->ID,
                'post_type'    => 'album',
            ];
            $post_id = wp_insert_post($album_post);

            if ($post_id) {
                // Update ACF fields
                update_field('genre', $album_genre, $post_id);
                update_field('duration', $album_duration, $post_id);
                update_field('album_tracklist', $album_tracklist, $post_id);
                update_field('artist_paypal_email', $artist_paypal_email, $post_id);
                update_field('related_artist', $artist_id, $post_id);

                // Handle featured image upload
                if (!empty($_FILES['album_cover']['name'])) {
                    require_once ABSPATH . 'wp-admin/includes/image.php';
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';

                    $attachment_id = media_handle_upload('album_cover', $post_id);
                    if (!is_wp_error($attachment_id)) {
                        set_post_thumbnail($post_id, $attachment_id);
                    }
                }

                // Handle multiple track uploads
                if (!empty($_FILES['album_audio']['name'][0])) {
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';

                    $track_ids = [];
                    foreach ($_FILES['album_audio']['name'] as $key => $value) {
                        if (!empty($_FILES['album_audio']['name'][$key])) {
                            $file = [
                                'name'     => $_FILES['album_audio']['name'][$key],
                                'type'     => $_FILES['album_audio']['type'][$key],
                                'tmp_name' => $_FILES['album_audio']['tmp_name'][$key],
                                'error'    => $_FILES['album_audio']['error'][$key],
                                'size'     => $_FILES['album_audio']['size'][$key],
                            ];

                            $_FILES['single_track'] = $file; // Trick WordPress into processing a single file
                            $track_id = media_handle_upload('single_track', $post_id);

                            if (!is_wp_error($track_id)) {
                                $track_ids[] = $track_id;
                            }
                        }
                    }

                    if (!empty($track_ids)) {
                        update_field('tracks', $track_ids, $post_id);
                    }
                }

                // Redirect to the new album post
                wp_redirect(get_permalink($post_id));
                exit;
            }
        }
    }
}
add_action('init', 'handle_album_form_submission');



// Hook into the 'init' action



add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     return $classes;
}

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );


function my_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );


function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/login-style.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

function custom_login_redirect($redirect_to, $request, $user) {

    if (isset($user->roles) && is_array($user->roles)) {
        return home_url('/'); 
    }
    return $redirect_to; 
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);

function enqueue_paypal_checkout_script() {
    wp_enqueue_script('paypal-checkout', get_stylesheet_directory_uri() . '/js/paypal-checkout.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_paypal_checkout_script');

function my_theme_enqueue_scripts() {
    // Enqueue the floating player script on every page
    wp_enqueue_script( 'floating-player', get_stylesheet_directory_uri() . '/js/floating-player.js', array('jquery'), '1.0', true );

    // Get track data for the CURRENT page (if any)
    global $post;
    $track_url = '';
    $track_title = '';
    $track_image = ''; // New: Track image variable

    if ( is_singular( 'single' ) && $post ) { // Check if it's a single post AND we have a $post object
        $tracks = get_field('track', $post->ID);
        $track_image = get_the_post_thumbnail_url($post->ID); // Fetch the track image URL

        if ($tracks) {
            if (is_array($tracks) && isset($tracks['url'])) {
                $track_url = $tracks['url'];
            } else {
                $track_url = $tracks;
            }
            $track_title = get_the_title($post->ID);
        }

        // Ensure track image is valid, else provide a fallback
        if (!$track_image) {
            $track_image = get_stylesheet_directory_uri() . '/images/default-track.jpg'; // Fallback image
        }
    }

    // Pass data to JavaScript
    wp_localize_script( 'floating-player', 'playerData', array(
        'currentTrack' => esc_url($track_url),
        'currentTitle' => esc_js($track_title),
        'currentImageUrl' => esc_url($track_image) 
    ));
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );







