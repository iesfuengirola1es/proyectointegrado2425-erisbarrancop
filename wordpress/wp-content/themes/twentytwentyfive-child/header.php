<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="site-header" style="background-color: var(--dark-bg); color: var(--input-bg);">
        <div class="header-container">
            <div class="site-logo">
                <?php 
                // Check if a custom logo exists and display it
                if ( has_custom_logo() ) {
                    the_custom_logo(); // Display custom logo if available
                } else {
                    // If no custom logo is set, display a fallback image
                    echo '<img src="' . get_stylesheet_directory_uri() . '/images/together_logo515x190.png" alt="Site Logo" style="max-width: 200px; height: auto;" />';
                }
                ?>
            </div>
            <nav class="site-navigation">
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-list' ) ); ?>
            </nav>
        </div>
    </header>
    <?php wp_body_open(); ?>
</body>
</html>
