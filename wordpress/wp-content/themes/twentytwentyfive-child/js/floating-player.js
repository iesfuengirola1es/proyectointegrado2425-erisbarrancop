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
    const pinPlayerBtn = document.getElementById('pin-player-btn');
    const trackImage = document.getElementById('track-image'); 
    const trackArtist = document.getElementById('track-artist'); 

    let isDragging = false,
        offsetX = 0,
        offsetY = 0;

    let isPinned = false;

    function updatePinIcon() {
        if (isPinned) {
            pinPlayerBtn.innerHTML = `
                <svg class="pin-icon" xmlns="http://www.w3.org/2000/svg" height="28" width="28" viewBox="0 0 640 512">
                    <path fill="#dc4e77" d="M32 32C32 14.3 46.3 0 64 0L320 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-29.5 0 11.4 148.2c36.7 19.9 65.7 53.2 79.5 94.7l1 3c3.3 9.8 1.6 20.5-4.4 28.8s-15.7 13.3-26 13.3L32 352c-10.3 0-19.9-4.9-26-13.3s-7.7-19.1-4.4-28.8l1-3c13.8-41.5 42.8-74.8 79.5-94.7L93.5 64 64 64C46.3 64 32 49.7 32 32zM160 384l64 0 0 96c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-96z"/>
                </svg>
            `;
        } else {
            pinPlayerBtn.innerHTML = `
                <svg class="pin-icon" xmlns="http://www.w3.org/2000/svg" height="28" width="28" viewBox="0 0 640 512">
                    <path fill="#8e3257" d="M32 32C32 14.3 46.3 0 64 0L320 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-29.5 0 11.4 148.2c36.7 19.9 65.7 53.2 79.5 94.7l1 3c3.3 9.8 1.6 20.5-4.4 28.8s-15.7 13.3-26 13.3L32 352c-10.3 0-19.9-4.9-26-13.3s-7.7-19.1-4.4-28.8l1-3c13.8-41.5 42.8-74.8 79.5-94.7L93.5 64 64 64C46.3 64 32 49.7 32 32zM160 384l64 0 0 96c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-96z"/>
                </svg>
            `;
        }
    }

    updatePinIcon();

    function updatePlayPauseButton() {
        if (audioPlayer.paused) {
            playPauseBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM188.3 147.1c-7.6 4.2-12.3 12.3-12.3 20.9l0 176c0 8.7 4.7 16.7 12.3 20.9s16.8 4.1 24.3-.5l144-88c7.1-4.4 11.5-12.1 11.5-20.5s-4.4-16.1-11.5-20.5l-144-88c-7.4-4.5-16.7-4.7-24.3-.5z" />
                </svg>`;
        } else {
            playPauseBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM224 192l0 128c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-128c0-17.7 14.3-32 32-32s32 14.3 32 32zm128 0l0 128c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-128c0-17.7 14.3-32 32-32s32 14.3 32 32z" />
                </svg>`;
        }
    }

    function loadAndPlayTrack(trackUrl, trackTitleText, trackArtistText, trackImageUrl) {
        if (!trackUrl) {
            floatingPlayer.style.display = 'none';
            return;
        }
    
        floatingPlayer.style.display = 'flex';
        audioPlayer.src = trackUrl;
        trackTitle.textContent = trackTitleText;
        trackArtist.textContent = trackArtistText;
        
        // Ensure the image updates correctly
        if (trackImageUrl) {
            trackImage.src = trackImageUrl; // Update the image
        } else {
            trackImage.src = "default-image.jpg"; // Fallback image if none is provided
        }
    
        // Save data in localStorage for persistence
        localStorage.setItem('currentTrack', trackUrl);
        localStorage.setItem('currentTitle', trackTitleText);
        localStorage.setItem('currentArtist', trackArtistText);
        localStorage.setItem('trackImageUrl', trackImageUrl || "default-image.jpg");
        
        audioPlayer.load();
        audioPlayer.play().catch(error => {
            console.error("Autoplay prevented:", error);
        });
    
        updatePlayPauseButton();
    }
    

    if (floatingPlayer) {
        let currentTrack = playerData.currentTrack;
        let currentTitle = playerData.currentTitle;
        let currentArtist = playerData.currentArtist; // Retrieve the artist name
        let currentImageUrl = playerData.currentImageUrl; // Retrieve the image URL


        if (currentTrack) {
            loadAndPlayTrack(currentTrack, currentTitle, currentArtist, currentImageUrl);
        } else {
            const savedTrack = localStorage.getItem('currentTrack');
            const savedTitle = localStorage.getItem('currentTitle');
            const savedArtist = localStorage.getItem('currentArtist'); // Retrieve the saved artist name
            const savedImageUrl = localStorage.getItem('trackImageUrl'); // Retrieve the saved image URL

            if (savedTrack) {
                loadAndPlayTrack(savedTrack, savedTitle, savedArtist, savedImageUrl);
                const savedTime = localStorage.getItem('playbackTime');
                audioPlayer.currentTime = parseFloat(savedTime) || 0;
            } else {
                floatingPlayer.style.display = 'none';
            }
        }

        const savedPosition = JSON.parse(localStorage.getItem('playerPosition'));
        if (savedPosition) {
            floatingPlayer.style.top = savedPosition.top;
            floatingPlayer.style.left = savedPosition.left;
        }

        // Restore play/pause state
        const isPlaying = localStorage.getItem('isPlaying') === 'true';
        if (isPlaying) {
            audioPlayer.play().catch(error => {
                console.error("Autoplay prevented:", error);
            });
        } else {
            audioPlayer.pause();
        }
        updatePlayPauseButton();

        // Restore volume state
        const savedVolume = localStorage.getItem('volumeLevel');
        if (savedVolume !== null) {
            audioPlayer.volume = parseFloat(savedVolume);
            volumeSlider.value = savedVolume; // Update the slider to reflect the restored volume
        }

        // Restore pinned state
        const savedPinnedState = localStorage.getItem('isPinned');
        if (savedPinnedState !== null) {
            isPinned = savedPinnedState === 'true'; // Convert string to boolean
            updatePinIcon();

            if (isPinned) {
                floatingPlayer.style.position = 'fixed';
                floatingPlayer.style.top = floatingPlayer.offsetTop + 'px';
                floatingPlayer.style.left = floatingPlayer.offsetLeft + 'px';
            } else {
                floatingPlayer.style.position = 'absolute';
            }
        }
    } else {
        console.warn("Floating player element not found.");
        return;
    }

    playPauseBtn.addEventListener('click', function () {
        if (audioPlayer.paused) {
            audioPlayer.play();
        } else {
            audioPlayer.pause();
        }
        updatePlayPauseButton();
    });

    volumeSlider.addEventListener('input', function () {
        audioPlayer.volume = volumeSlider.value;
        localStorage.setItem('volumeLevel', volumeSlider.value); // Save volume level
    });

    window.addEventListener('beforeunload', function () {
        localStorage.setItem('playbackTime', audioPlayer.currentTime);
        localStorage.setItem('playerPosition', JSON.stringify({
            top: floatingPlayer.style.top,
            left: floatingPlayer.style.left
        }));
    });

    pinPlayerBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        isPinned = !isPinned; // Toggle the pinned state
        updatePinIcon();

        if (isPinned) {
            floatingPlayer.style.position = 'fixed';
            floatingPlayer.style.top = floatingPlayer.offsetTop + 'px';
            floatingPlayer.style.left = floatingPlayer.offsetLeft + 'px';
        } else {
            floatingPlayer.style.position = 'absolute';
        }

        // Save pinned state to localStorage
        localStorage.setItem('isPinned', isPinned);
    });

    floatingPlayer.addEventListener('mousedown', function (event) {
        if (event.target.tagName === "BUTTON" || event.target.tagName === "INPUT") return;

        isDragging = true;
        offsetX = event.clientX - floatingPlayer.getBoundingClientRect().left;
        offsetY = event.clientY - floatingPlayer.getBoundingClientRect().top;
        floatingPlayer.style.cursor = "grabbing";
    });

    document.addEventListener('mousemove', function (event) {
        if (!isDragging) return;

        let newX = event.clientX - offsetX;
        let newY = event.clientY - offsetY;

        const maxX = window.innerWidth - floatingPlayer.clientWidth;
        const maxY = window.innerHeight - floatingPlayer.clientHeight;

        floatingPlayer.style.left = Math.max(0, Math.min(newX, maxX)) + 'px';
        floatingPlayer.style.top = Math.max(0, Math.min(newY, maxY)) + 'px';
    });

    document.addEventListener('mouseup', function () {
        if (isDragging) {
            isDragging = false;
            floatingPlayer.style.cursor = "grab";

            localStorage.setItem('playerPosition', JSON.stringify({
                top: floatingPlayer.style.top,
                left: floatingPlayer.style.left
            }));
        }
    });

    audioPlayer.addEventListener('timeupdate', function () {
        if (audioPlayer.duration > 0) {
            const progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
            progressBar.style.width = progress + '%';
        }
    });

    progressContainer.addEventListener('click', function (e) {
        const width = this.clientWidth;
        const clickX = e.offsetX;
        const duration = audioPlayer.duration;

        audioPlayer.currentTime = (clickX / width) * duration;
    });

    // Save play/pause state
    audioPlayer.addEventListener('play', function () {
        localStorage.setItem('isPlaying', true);
    });

    audioPlayer.addEventListener('pause', function () {
        localStorage.setItem('isPlaying', false);
    });
});