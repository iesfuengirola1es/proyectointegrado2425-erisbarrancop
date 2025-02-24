document.addEventListener('DOMContentLoaded', function () {
    const audioPlayer = document.getElementById('audio-player');
    const playPauseBtn = document.getElementById('play-pause-btn');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const trackTitle = document.getElementById('track-title');
    const volumeSlider = document.getElementById('volume-slider');
    const floatingPlayer = document.getElementById('floating-music-player');
    const progressBar = document.getElementById('progress-bar');
    const progressContainer = document.getElementById('progress-container');
    const pinPlayerBtn = document.getElementById('pin-player-btn');  // Add this line!

    let isDragging = false,
        offsetX = 0,
        offsetY = 0;

    let isPinned = false; // Add this line - initial state

    // Function to update the pin icon (no change needed, but keep it)
    function updatePinIcon() {
        if (isPinned) {
            //Unpinnned Icon - same
            pinPlayerBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="28" width="28" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#dc4e77" d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L481.4 352c9.8-.4 18.9-5.3 24.6-13.3c6-8.3 7.7-19.1 4.4-28.8l-1-3c-13.8-41.5-42.8-74.8-79.5-94.7L418.5 64 448 64c17.7 0 32-14.3 32-32s-14.3-32-32-32L192 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l29.5 0-6.1 79.5L38.8 5.1zM324.9 352L177.1 235.6c-20.9 18.9-37.2 43.3-46.5 71.3l-1 3c-3.3 9.8-1.6 20.5 4.4 28.8s15.7 13.3 26 13.3l164.9 0zM288 384l0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-96-64 0z"/></svg>';
        } else {
            //Pinned Icon - same
            pinPlayerBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#8e3257" d="M32 32C32 14.3 46.3 0 64 0L320 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-29.5 0 11.4 148.2c36.7 19.9 65.7 53.2 79.5 94.7l1 3c3.3 9.8 1.6 20.5-4.4 28.8s-15.7 13.3-26 13.3L32 352c-10.3 0-19.9-4.9-26-13.3s-7.7-19.1-4.4-28.8l1-3c13.8-41.5 42.8-74.8 79.5-94.7L93.5 64 64 64C46.3 64 32 49.7 32 32zM160 384l64 0 0 96c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-96z"/></svg>';
        }
    }

    // Call it to set the initial state of the icon (optional, defaults to unpinned anyway)
    updatePinIcon();

    function updatePlayPauseButton() {
        if (audioPlayer.paused) {
            playPauseBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!-- play -->
                    <path
                        d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM188.3 147.1c-7.6 4.2-12.3 12.3-12.3 20.9l0 176c0 8.7 4.7 16.7 12.3 20.9s16.8 4.1 24.3-.5l144-88c7.1-4.4 11.5-12.1 11.5-20.5s-4.4-16.1-11.5-20.5l-144-88c-7.4-4.5-16.7-4.7-24.3-.5z" />
                </svg>`;
        } else {
            playPauseBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!-- Pause -->
                    <path
                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM224 192l0 128c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-128c0-17.7 14.3-32 32-32s32 14.3 32 32zm128 0l0 128c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-128c0-17.7 14.3-32 32-32s32 14.3 32 32z" />
                </svg>`;
        }
    }

    function loadAndPlayTrack(trackUrl, trackTitleText) {
        if (!trackUrl) {
            floatingPlayer.style.display = 'none'; // Hide player if no track
            return;
        }

        floatingPlayer.style.display = 'flex';
        audioPlayer.src = trackUrl;
        trackTitle.textContent = trackTitleText;

        // Save track information to localStorage (for persistence)
        localStorage.setItem('currentTrack', trackUrl);
        localStorage.setItem('currentTitle', trackTitleText);

        audioPlayer.load(); // Load the new track
        audioPlayer.play().catch(error => {
                console.error("Autoplay prevented:", error);
                // Optionally, show a message to the user or provide a button to manually play.
            }); // Attempt to play immediately

        updatePlayPauseButton(); // Update the button to "pause"
    }

    // Check if player already exists (persistence) and load from playerData or localStorage
    if (floatingPlayer) {
        let currentTrack = playerData.currentTrack;
        let currentTitle = playerData.currentTitle;

        // Check playerData first
        if (currentTrack) {
            loadAndPlayTrack(currentTrack, currentTitle);
        } else {
            // If no playerData, check localStorage
            const savedTrack = localStorage.getItem('currentTrack');
            const savedTitle = localStorage.getItem('currentTitle');

            if (savedTrack) {
                loadAndPlayTrack(savedTrack, savedTitle);
                const savedTime = localStorage.getItem('playbackTime');
                 audioPlayer.currentTime = parseFloat(savedTime) || 0;
            } else {
                floatingPlayer.style.display = 'none';
            }
        }

        // Restore player position (from localStorage)
        const savedPosition = JSON.parse(localStorage.getItem('playerPosition'));
        if (savedPosition) {
            floatingPlayer.style.top = savedPosition.top;
            floatingPlayer.style.left = savedPosition.left;
        }
    } else {
        console.warn("Floating player element not found.");
        return;
    }

    // Play/Pause Functionality (Delegate to updatePlayPauseButton)
    playPauseBtn.addEventListener('click', function () {
        if (audioPlayer.paused) {
            audioPlayer.play();
        } else {
            audioPlayer.pause();
        }
        updatePlayPauseButton();
    });

    // Volume Control
    volumeSlider.addEventListener('input', function () {
        audioPlayer.volume = volumeSlider.value;
    });

    // Save Player State on Unload
    window.addEventListener('beforeunload', function () {
        localStorage.setItem('playbackTime', audioPlayer.currentTime);
        localStorage.setItem('playerPosition', JSON.stringify({
            top: floatingPlayer.style.top,
            left: floatingPlayer.style.left
        }));
    });

   // Pin Player Functionality - **MISSING IN YOUR CODE**
    pinPlayerBtn.addEventListener('click', function (e) {
        e.stopPropagation(); // Prevent dragging when clicking the pin button

        isPinned = !isPinned; // Toggle the pinned state
        updatePinIcon();

        if (isPinned) {
            floatingPlayer.style.position = 'fixed'; // Stay in place
            floatingPlayer.style.top = floatingPlayer.offsetTop + 'px'; // set position from the top
            floatingPlayer.style.left = floatingPlayer.offsetLeft + 'px'; // set position from the left
        } else {
            floatingPlayer.style.position = 'absolute'; // Follow the document
        }
    });

    // Dragging Functionality with Boundaries
    floatingPlayer.addEventListener('mousedown', function (event) {
        if (event.target.tagName === "BUTTON" || event.target.tagName === "INPUT") return; // Prevent dragging when clicking buttons

        isDragging = true;
        offsetX = event.clientX - floatingPlayer.getBoundingClientRect().left;
        offsetY = event.clientY - floatingPlayer.getBoundingClientRect().top;
        floatingPlayer.style.cursor = "grabbing";
    });

    document.addEventListener('mousemove', function (event) {
        if (!isDragging) return;

        let newX = event.clientX - offsetX;
        let newY = event.clientY - offsetY;

        // Prevent player from moving out of screen
        const maxX = window.innerWidth - floatingPlayer.clientWidth;
        const maxY = window.innerHeight - floatingPlayer.clientHeight;

        floatingPlayer.style.left = Math.max(0, Math.min(newX, maxX)) + 'px';
        floatingPlayer.style.top = Math.max(0, Math.min(newY, maxY)) + 'px';
    });

    document.addEventListener('mouseup', function () {
        if (isDragging) {
            isDragging = false;
            floatingPlayer.style.cursor = "grab";

            // Save position after dragging stops
            localStorage.setItem('playerPosition', JSON.stringify({
                top: floatingPlayer.style.top,
                left: floatingPlayer.style.left
            }));
        }
    });

    // Time/Progress Updates
    audioPlayer.addEventListener('timeupdate', function () {
        if (audioPlayer.duration > 0) {
            const progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
            progressBar.style.width = progress + '%';
        }
    });

    // Seeking
    progressContainer.addEventListener('click', function (e) {
        const width = this.clientWidth;
        const clickX = e.offsetX;
        const duration = audioPlayer.duration;

        audioPlayer.currentTime = (clickX / width) * duration;
    });
});