<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" as="image" href="images/login_bg.jpg">
    <?php wp_head(); ?>
</head>

<body>
    <div id="page-transition"></div>
    <?php wp_body_open(); ?>

    <header class="site-header" style="background-color: var(--light-bg); color: var(--input-bg);">
        <div class="header-container container d-flex align-items-center justify-content-between">
            <!-- Site Logo -->
            <div class="site-logo">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<a href="' . esc_url(home_url('/')) . '">';
                    echo '<img src="' . esc_url(get_stylesheet_directory_uri() . '/images/together_logo515x190.png') . '" alt="' . esc_attr(get_bloginfo('name')) . ' Logo" style="max-width: 200px; height: auto;" />';
                    echo '</a>';
                }
                ?>
            </div>

            <!-- Site Navigation -->
            <nav class="site-navigation d-flex align-items-center" aria-label="Main Navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'nav-list d-flex gap-3',
                    'fallback_cb'    => function () {
                        $post_types = get_post_types(array('public' => true), 'objects');
                        echo '<ul class="nav-list">';
                        $current_url = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        $home_url = home_url('/');
                        $home_class = ($home_url === $current_url) ? 'current-menu-item' : '';
                        echo '<li><a href="' . esc_url($home_url) . '" class="' . esc_attr($home_class) . '">Home</a></li>';
                        foreach ($post_types as $post_type) {
                            if ($post_type->has_archive) {
                                $archive_url = get_post_type_archive_link($post_type->name);
                                $archive_class = ($archive_url === $current_url || is_singular($post_type->name)) ? 'current-menu-item' : '';
                                echo '<li><a href="' . esc_url($archive_url) . '" class="' . esc_attr($archive_class) . '">' . esc_html($post_type->labels->name) . '</a></li>';
                            }
                        }
                        echo '</ul>';
                    },
                ));
                ?>

                <!-- Login / Register Links -->
                <ul class="nav-list d-flex gap-3">
                    <?php if (is_user_logged_in()) :
                        $current_user = wp_get_current_user();
                        $artist_post_link = '';
                        $user_id = get_current_user_id();

                        $artist_posts = get_posts(array(
                            'post_type' => 'artist',
                            'posts_per_page' => -1,
                        ));
                         $found_artist = false;
                         if($artist_posts)
                         {
                             foreach($artist_posts as $artist_post)
                             {
                                   $artist_user = get_field('artist_user', $artist_post->ID);

                                   if($artist_user && is_object($artist_user) && isset($artist_user->ID) && $artist_user->ID == $user_id)
                                   {
                                        $artist_post_link = get_permalink($artist_post->ID);
                                        $found_artist = true;
                                          break;
                                   }
                             }
                        }

                       if (empty($artist_post_link)) {
                            $artist_post_link = get_post_type_archive_link('artist');
                        }
                        ?>
                        <li>
                         <a href="<?php echo esc_url($artist_post_link); ?>">
                             <?php echo esc_html($current_user->display_name); ?>
                         </a>
                       </li>
                        <li><a href="<?php echo esc_url(wp_logout_url(home_url())); ?>">Logout</a></li>
                    <?php else : ?>
                        <li><a href="<?php echo esc_url(wp_login_url()); ?>">Login</a></li>
                        <li><a href="<?php echo esc_url(wp_registration_url()); ?>">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <script src="https://www.paypal.com/sdk/js?client-id=Aae2-vyUvPHAMtnVeXYZLLkQIGcVoziz0FcVMGBQAtReSaHWcAl-kaaSbeLsuy424O3K5zP_DOi0b_r3&currency=EUR"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Preload the image
                const img = new Image();
                img.onload = function() {
                    // Once the image is loaded, show the page and start the fade-out
                    document.body.classList.add("page-loaded");
                };
                img.src = "<?php echo get_stylesheet_directory_uri(); ?>/images/login_bg.jpg"; // Replace with your image path

                // Fallback in case the image fails to load
                setTimeout(() => {
                    if (!document.body.classList.contains("page-loaded")) {
                        document.body.classList.add("page-loaded");
                    }
                }, 2000); // Max 2 seconds to load, then proceed anyway

                // Link click handling (move this to the header too)
                document.querySelectorAll("a").forEach(link => {
                    // Only apply effect to internal links, excluding # anchors and special classes
                    if (link.host === window.location.host && !link.classList.contains("no-transition") && link.getAttribute("href") !== "#") {
                        link.addEventListener("click", function(event) {
                            event.preventDefault(); // Stop default navigation
                            const targetUrl = this.href; // Store the URL *before* the fade-out

                            document.body.classList.add("fade-out");

                            // Delay navigation until fade-out is done
                            setTimeout(() => {
                                window.location.href = targetUrl;
                            }, 400); // Match the transition duration (0.4s)
                        });
                    }
                });
            });
        </script>
    </header>