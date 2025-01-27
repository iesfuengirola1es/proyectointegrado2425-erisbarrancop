<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body>
    <?php wp_body_open(); ?>

    <header class="site-header" style="background-color: var(--light-bg); color: var(--input-bg);">
        <div class="header-container container d-flex align-items-center justify-content-between">
            <!-- Site Logo -->
            <div class="site-logo">
                <?php
                // Check if a custom logo exists and display it
                if (has_custom_logo()) {
                    the_custom_logo(); // Display custom logo if available
                } else {
                    // Fallback image with proper alt text
                    echo '<a href="' . esc_url(home_url('/')) . '">';
                    echo '<img src="' . esc_url(get_stylesheet_directory_uri() . '/images/together_logo515x190.png') . '" alt="' . esc_attr(get_bloginfo('name')) . ' Logo" style="max-width: 200px; height: auto;" />';
                    echo '</a>';
                }
                ?>
            </div>

            <!-- Site Navigation -->
            <nav class="site-navigation" aria-label="Main Navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'nav-list d-flex gap-3',
                    'fallback_cb' => function () {
                        // Query all public post types, including default ones
                        $post_types = get_post_types(array(
                            'public' => true, // Include public post types
                        ), 'objects');

                        echo '<ul class="nav-list">';

                        // Get the current URL
                        $current_url = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                        // Add a default Home link with active class logic on the <a>
                        $home_url = home_url('/');
                        $home_class = ($home_url === $current_url) ? 'current-menu-item' : '';

                        echo '<li>';
                        echo '<a href="' . esc_url($home_url) . '" class="' . esc_attr($home_class) . '">Home</a>';
                        echo '</li>';

                        // Loop through each post type and add to the menu
                        foreach ($post_types as $post_type) {
                            if ($post_type->has_archive) {
                                $archive_url = get_post_type_archive_link($post_type->name);
                                $archive_class = ($archive_url === $current_url || is_singular($post_type->name)) ? 'current-menu-item' : '';

                                echo '<li>';
                                echo '<a href="' . esc_url($archive_url) . '" class="' . esc_attr($archive_class) . '">' . esc_html($post_type->labels->name) . '</a>';
                                echo '</li>';
                            }
                        }

                        echo '</ul>';
                    },
                    
                ));
                
                ?>
                
            </nav>
        </div>
    </header>