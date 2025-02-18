document.addEventListener('DOMContentLoaded', function () {
    const audioPlayer = document.getElementById('audio-player');
    const playPauseBtn = document.getElementById('play-pause-btn');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const trackTitle = document.getElementById('track-title');
    const volumeSlider = document.getElementById('volume-slider');
    const floatingPlayer = document.getElementById('floating-music-player');

    let isDragging = false, offsetX = 0, offsetY = 0;

    let currentTrack = playerData.currentTrack;
    let currentTitle = playerData.currentTitle;

    if (currentTrack) {
        floatingPlayer.style.display = 'flex';
        audioPlayer.src = currentTrack;
        trackTitle.textContent = currentTitle;
    }

    // Restore player state
    const savedTrack = localStorage.getItem('currentTrack');
    const savedTitle = localStorage.getItem('currentTitle');
    const savedTime = localStorage.getItem('playbackTime');
    const savedPosition = JSON.parse(localStorage.getItem('playerPosition'));

    if (savedTrack) {
        floatingPlayer.style.display = 'flex';
        audioPlayer.src = savedTrack;
        trackTitle.textContent = savedTitle;
        audioPlayer.currentTime = parseFloat(savedTime) || 0;
        audioPlayer.play();
        playPauseBtn.textContent = 'Pause';
    }

    if (savedPosition) {
        floatingPlayer.style.top = savedPosition.top;
        floatingPlayer.style.left = savedPosition.left;
    }

    // Play/Pause Functionality
    playPauseBtn.addEventListener('click', function () {
        if (audioPlayer.paused) {
            audioPlayer.play();
            playPauseBtn.textContent = 'Pause';
        } else {
            audioPlayer.pause();
            playPauseBtn.textContent = 'Play';
        }
    });

    // Volume Control
    volumeSlider.addEventListener('input', function () {
        audioPlayer.volume = volumeSlider.value;
    });

    // Save Player State on Unload
    window.addEventListener('beforeunload', function () {
        localStorage.setItem('currentTrack', currentTrack);
        localStorage.setItem('currentTitle', currentTitle);
        localStorage.setItem('playbackTime', audioPlayer.currentTime);
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
});
