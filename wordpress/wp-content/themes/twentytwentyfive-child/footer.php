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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
        <!-- Pin Button -->
        <button id="pin-player-btn" style="position: absolute; top: 5px; right: 5px; background: none; border: none; cursor: pointer; color: var(--primary-text);">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="16" height="16">
                <path
                d="M32 32C32 14.3 46.3 0 64 0L320 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-29.5 0 11.4 148.2c36.7 19.9 65.7 53.2 79.5 94.7l1 3c3.3 9.8 1.6 20.5-4.4 28.8s-15.7 13.3-26 13.3L32 352c-10.3 0-19.9-4.9-26-13.3s-7.7-19.1-4.4-28.8l1-3c13.8-41.5 42.8-74.8 79.5-94.7L93.5 64 64 64C46.3 64 32 49.7 32 32zM160 384l64 0 0 96c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-96z"/>
            </svg>
        </button>

        <div class="player-top-row">
            <img id="track-image" src="" alt="Track Image">
            <span id="track-title"></span>
        </div>
        <div id="progress-container">
                <div id="progress-bar"></div>
        </div>
        <div class="player-controls">
            <button id="prev-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!-- Previous Icon -->
                    <path
                        d="M459.5 440.6c9.5 7.9 22.8 9.7 34.1 4.4s18.4-16.6 18.4-29l0-320c0-12.4-7.2-23.7-18.4-29s-24.5-3.6-34.1 4.4L288 214.3l0 41.7 0 41.7L459.5 440.6zM256 352l0-96 0-128 0-32c0-12.4-7.2-23.7-18.4-29s-24.5-3.6-34.1 4.4l-192 160C4.2 237.5 0 246.5 0 256s4.2 18.5 11.5 24.6l192 160c9.5 7.9 22.8 9.7 34.1 4.4s18.4-16.6 18.4-29l0-64z" />
                </svg>
            </button>
            <button id="play-pause-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!-- play -->
                    <path
                        d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM188.3 147.1c-7.6 4.2-12.3 12.3-12.3 20.9l0 176c0 8.7 4.7 16.7 12.3 20.9s16.8 4.1 24.3-.5l144-88c7.1-4.4 11.5-12.1 11.5-20.5s-4.4-16.1-11.5-20.5l-144-88c-7.4-4.5-16.7-4.7-24.3-.5z" />
                </svg>
            </button>
            <button id="next-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!-- Next Icon -->
                    <path
                        d="M52.5 440.6c-9.5 7.9-22.8 9.7-34.1 4.4S0 428.4 0 416L0 96C0 83.6 7.2 72.3 18.4 67s24.5-3.6 34.1 4.4L224 214.3l0 41.7 0 41.7L52.5 440.6zM256 352l0-96 0-128 0-32c0-12.4 7.2-23.7 18.4-29s24.5-3.6 34.1 4.4l192 160c7.3 6.1 11.5 15.1 11.5 24.6s-4.2 18.5-11.5 24.6l-192 160c-9.5 7.9-22.8 9.7-34.1 4.4s-18.4-16.6-18.4-29l0-64z" />
                </svg>
            </button>
            <input type="range" id="volume-slider" min="0" max="1" step="0.1" value="1">
        </div>
        <audio id="audio-player"></audio>
    </div>
</body>

</html>