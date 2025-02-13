<footer class="site-footer"
    style="border-top:1px solid var(--primary-color);background-color: var(--light-bg); color: var(--input-bg); padding: 20px 0;">
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
                    echo '<a href="' . esc_url(home_url('/artists')) . '" style="text-decoration: none; color: var(--primary-text);">Artists</a>';
                    echo '<a href="' . esc_url(home_url('/albums')) . '" style="text-decoration: none; color: var(--primary-text);">Albums</a>';
                    echo '<a href="' . esc_url(home_url('/singles')) . '" style="text-decoration: none; color: var(--primary-text);">Singles</a>';
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
<div id="page-transition"></div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ensure overlay stays until everything is fully loaded
        setTimeout(() => {
            document.body.classList.add("page-loaded");
        }, 500); // Small delay to ensure smooth transition

        document.querySelectorAll("a").forEach(link => {
            // Only apply effect to internal links, excluding # anchors and special classes
            if (link.host === window.location.host && !link.classList.contains("no-transition") && link.getAttribute("href") !== "#") {
                link.addEventListener("click", function(event) {
                    event.preventDefault(); // Stop default navigation
                    document.body.classList.add("fade-out");

                    // Delay navigation until fade-out is done
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 600); // Match the transition duration
                });
            }
        });
    });

    </script>
</body>

</html>