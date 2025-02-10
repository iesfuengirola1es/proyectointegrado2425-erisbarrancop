<?php get_header(); ?>

<div class="container-fluid" style="background-color: var(--light-bg); color: var(--primary-text); font-family: 'Lato', sans-serif;">
    <!-- Hero Section -->
        <div class="hero-section text-center py-5 d-flex justify-content-center align-items-center position-relative"
        style="background: radial-gradient(circle, rgba(220,78,119,1) 0%, rgba(142,50,87,1) 100%); color: var(--light-bg); border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <h1 class="display-4" style="font-weight: bold; margin: 0;">All Albums</h1>

        <?php
            $current_user = wp_get_current_user();
            $artist_post_id = null;

            if (is_user_logged_in()) {
                $artist_query = new WP_Query([
                    'post_type' => 'artist',
                    'meta_key' => 'artist_user',
                    'meta_value' => $current_user->ID,
                    'posts_per_page' => 1
                ]);

                if ($artist_query->have_posts()) {
                    $artist_query->the_post();
                    $artist_post_id = get_the_ID();
                }
                wp_reset_postdata();
            }
            ?>
        
            <?php if ($artist_post_id): ?>
                <button id="createAlbumBtn" class="btn btn-lg"
                    style="position: absolute; right: 20px; background-color: var(--light-bg); color: var(--primary-color)!important; padding: 12px 40px; border-radius: 50px; text-transform: uppercase; font-weight: bold; transition: all 0.3s ease;">
                    Create Album
                </button>
            <?php endif; ?>
        </div>

    <!-- Filter Section -->
    <div id="content" class="content-section py-5" style="background-color: var(--mid-bg); border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; padding-top: 8px !important;">
        <div class="container">
            <div class="text-center py-4">
                <!-- Search Bar -->
                <input type="text" id="search-bar" class="form-control d-inline-block w-auto" placeholder="Search..."
                    style="font-size: 1rem; padding: 0.5rem; border-radius: 5px; border-color: var(--primary-hover); transition: border-color 0.3s ease;">

                <!-- Dropdown for sorting -->
                <select id="filter-sort" class="form-select d-inline-block w-auto"
                    style="font-size: 1rem; padding: 0.5rem 2rem 0.5rem 0.5rem; border-radius: 5px; border: 1px solid var(--primary-hover); background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22none%22%3E%3Cpath d=%22M5 7L10 12L15 7H5Z%22 fill=%22%23333%22/%3E%3C/svg%3E'); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1rem; transition: border-color 0.3s ease;">
                    <option value="alphabetical" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'alphabetical') ? 'selected' : ''; ?>>Sort Alphabetically</option>
                    <option value="date" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'date') ? 'selected' : ''; ?>>Sort by Date</option>
                </select>
            </div>

            <!-- Album Items Section -->
            <div class="d-flex flex-wrap justify-content-center gap-3" id="items-container">
                <?php
                // Determine the sorting method
                $orderby = isset($_GET['sort']) && $_GET['sort'] === 'date' ? 'date' : 'title';
                $order = ($orderby === 'date') ? 'DESC' : 'ASC';

                // Query to fetch albums based on sorting
                $albums_query = new WP_Query(array(
                    'post_type' => 'album', // Change 'album' to your custom post type slug
                    'orderby' => $orderby,
                    'order' => $order,
                    'posts_per_page' => -1 // Display all posts
                ));
                ?>

                <?php if ($albums_query->have_posts()): ?>
                    <?php while ($albums_query->have_posts()):
                        $albums_query->the_post(); ?>
                        <div class="card text-center album-item" data-name="<?php echo strtolower(get_the_title()); ?>"
                            style="max-width: 300px; border: 1px solid var(--border-color); border-radius: 10px; background-color: var(--input-bg); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                            <?php if (has_post_thumbnail()): ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('thumbnail', ['class' => 'img-fluid', 'style' => 'margin: 10px; border-radius: 10px;']); ?>
                                </a>
                            <?php endif; ?>
                            <div class="card-body" style="padding: 20px;">
                                <h5 class="card-title" style="font-weight: bold; margin-bottom: 15px;">
                                    <a href="<?php the_permalink(); ?>" style="color: var(--primary-color); text-decoration: none; transition: color 0.3s ease;">
                                        <?php the_title(); ?>
                                    </a>
                                </h5>
                                <p class="card-text" style="color: var(--secondary-text); font-size: 0.95rem; line-height: 1.6;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </p>
                            </div>
                            <div class="card-footer text-center" style="background-color: var(--light-bg); padding: 15px;">
                                <a href="<?php the_permalink(); ?>" class="btn" style="background-color: var(--primary-color); color: var(--light-bg) !important; padding: 10px 30px; border-radius: 30px; text-transform: uppercase; font-weight: bold; font-size: 0.9rem; transition: background-color 0.3s ease;">
                                    View Album
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center" style="font-size: 1.2rem; color: var(--secondary-text);">No albums found.</p>
                <?php endif; ?>
                <?php wp_reset_postdata(); // Reset the query to default ?>
            </div>
        </div>
    </div>
</div>

<!-- Create Album Form (Hidden Initially) -->
<div id="albumFormContainer" class="overlay-container">
    <button id="closeAlbumForm" class="close-button">&times;</button>
    <form id="albumFormSubmit" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create_album">
        <input type="hidden" name="artist_id" value="<?php echo $artist_post_id; ?>">

        <div class="form-group">
            <label for="album_title">Title</label>
            <input type="text" name="album_title" id="album_title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="album_genre">Genre</label>
            <input type="text" name="album_genre" id="album_genre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="album_duration">Duration</label>
            <input type="text" name="album_duration" id="album_duration" class="form-control">
        </div>
        <div class="form-group">
            <label for="album_tracklist">Tracklist</label>
            <textarea name="album_tracklist" id="album_tracklist" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="album_cover">Cover Image</label>
            <input type="file" name="album_cover" id="album_cover" class="form-control" accept="image/*">
        </div>
        <div class="form-group">
            <label for="album_audio">Audio Tracks</label>
            <input type="file" name="album_audio[]" id="album_audio" class="form-control" accept=".mp3, .m4a, .wav" multiple>
        </div>
        <button type="submit" class="btn btn-lg" style="background-color: var(--primary-color); color: var(--light-bg); margin-top: 20px; padding: 10px 30px; border-radius: 30px; text-transform: uppercase; font-weight: bold; width: 100%;">
            Submit
        </button>
    </form>
</div>

<div id="overlay"></div>

<script>
    // Handle sort filter change
    document.getElementById('filter-sort').addEventListener('change', function () {
        const selectedValue = this.value;
        const currentURL = new URL(window.location.href);
        currentURL.searchParams.set('sort', selectedValue);
        window.location.href = currentURL.toString();
    });

    // Real-time search functionality
    document.getElementById('search-bar').addEventListener('input', function () {
        let searchQuery = this.value.toLowerCase();
        let items = document.querySelectorAll('.album-item');

        items.forEach(item => {
            let itemName = item.getAttribute('data-name');
            if (itemName.includes(searchQuery)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Add hover effect on cards
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'scale(1.05)';
            card.style.boxShadow = '0 6px 15px rgba(0, 0, 0, 0.2)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'scale(1)';
            card.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
        });
    });

    // Add focus styles
    document.querySelectorAll('#search-bar, #filter-sort').forEach(element => {
        element.addEventListener('focus', function () {
            this.style.borderColor = 'var(--primary-color)';
            this.style.outline = 'none';
        });
        element.addEventListener('blur', function () {
            this.style.borderColor = 'var(--primary-hover)';
        });
    });

        document.getElementById('createAlbumBtn')?.addEventListener('click', function () {
        document.getElementById('overlay').classList.add('active');
        const form = document.getElementById('albumFormContainer');
        form.style.display = 'block';
        setTimeout(() => form.classList.add('active'), 10);
    });

    document.getElementById('closeAlbumForm')?.addEventListener('click', function () {
        const form = document.getElementById('albumFormContainer');
        form.classList.remove('active');
        document.getElementById('overlay').classList.remove('active');

        setTimeout(() => {
            form.style.display = 'none';
        }, 400);
    });

    document.getElementById('overlay')?.addEventListener('click', function () {
        const form = document.getElementById('albumFormContainer');
        form.classList.remove('active');
        document.getElementById('overlay').classList.remove('active');

        setTimeout(() => {
            form.style.display = 'none';
        }, 400);
    });


</script>


<?php get_footer(); ?>
