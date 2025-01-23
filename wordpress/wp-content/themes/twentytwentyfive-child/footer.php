<footer class="site-footer" style="border-top:1px solid var(--primary-color);background-color: var(--light-bg); color: var(--input-bg); padding: 20px 0;">
    <div class="footer-container container d-flex justify-content-between align-items-center">
        <!-- Footer Navigation -->
        <nav class="footer-navigation" aria-label="Footer Navigation" style="flex-grow: 1;">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer', // Define a footer menu location in your theme
                'container' => false,
                'menu_class' => 'footer-nav d-flex gap-4',
                'fallback_cb' => function () {
                    echo '<div class="footer-nav d-flex gap-4">';
                    echo '<a href="' . esc_url(home_url('/')) . '" style="text-decoration: none; color: var(--primary-text);">Home</a>';
                    echo '<a href="' . esc_url(home_url('/about')) . '" style="text-decoration: none; color: var(--primary-text);">About</a>';
                    echo '<a href="' . esc_url(home_url('/contact')) . '" style="text-decoration: none; color: var(--primary-text);">Contact</a>';
                    echo '</div>';
                },
            ));
            ?>
        </nav>

        <!-- Copyright Section -->
        <div class="footer-copyright text-end">
            <p style="margin: auto; font-size: 0.9rem; color: var(--secondary-text);">
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

