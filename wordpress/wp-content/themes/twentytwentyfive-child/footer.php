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
        var downloadLink = document.getElementById("download-track-link");
        var trackFile = document.getElementById("track-file").value;

        downloadLink.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior

            if (!trackFile) {
                alert("No track available for download.");
                return;
            }

            var a = document.createElement("a");
            a.href = trackFile;
            a.download = trackFile.split("/").pop(); // Extract filename from URL
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });
    });

    </script>

        <!-- Floating Music Player -->
    <div id="floating-music-player" style="display: none;">
        <div class="player-controls">
            <span id="track-title"><?php echo esc_html(get_the_title()); ?></span>
            <button id="play-pause-btn">Play</button>
            <button id="prev-btn">Previous</button>
            <button id="next-btn">Next</button>
            <input type="range" id="volume-slider" min="0" max="1" step="0.1" value="1">
        </div>
        <audio id="audio-player"></audio>
    </div>


    <style>
        #floating-music-player {
            position: fixed;
            top: 80px; /* Default position */
            left: 20px;
            width: 300px; /* Fixed width */
            height: auto;
            background-color: var(--mid-bg);
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            cursor: grab;
            user-select: none;
        }

        .player-controls {
            display: flex;
            flex-wrap: nowrap; /* Prevents stretching */
            align-items: center;
            gap: 10px;
        }

        #track-title {
            margin: 0 10px;
            font-weight: bold;
            white-space: nowrap; /* Prevents title from forcing resizing */
            overflow: hidden;
            text-overflow: ellipsis;
        }

    </style>

</body>

</html>