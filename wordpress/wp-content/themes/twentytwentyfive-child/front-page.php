<?php get_header(); ?>

<div class="container-fluid"
    style="background-color: var(--light-bg); color: var(--primary-text); font-family: 'Lato', sans-serif; height: 100vh; display: flex; flex-direction: column;">

    <!-- Hero Section -->
    <div class="hero-section text-center py-5"
        style="background: radial-gradient(circle, rgba(220,78,119,1) 0%, rgba(142,50,87,1) 100%); color: var(--light-bg); border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <div class="container">
            <h1 class="display-4" style="font-weight: bold; letter-spacing: 1px; margin-bottom: 20px;">
                Welcome to <?php bloginfo('name'); ?>
            </h1>
            <p class="lead" style="font-size: 1.2rem; margin-bottom: 30px;">
                Discover and support independent artists from around the world.
            </p>

            <?php
            $current_user = wp_get_current_user();
            $artist_post_id = null;

            if (is_user_logged_in()) {
                // Get the artist post linked to the user
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

            <?php if (!is_user_logged_in()): ?>
                <a href="<?php echo esc_url(wp_registration_url()); ?>" class="btn btn-lg"
                    style="background-color: var(--light-bg); color: var(--primary-color)!important; padding: 12px 40px; border-radius: 50px; text-transform: uppercase; font-weight: bold; transition: all 0.3s ease;">
                    Sign Up to Become An Artist
                </a>
            <?php elseif (current_user_can('subscriber')): ?>
                <button id="becomeArtistBtn" class="btn btn-lg"
                    style="background-color: var(--light-bg); color: var(--primary-color)!important; padding: 12px 40px; border-radius: 50px; text-transform: uppercase; font-weight: bold; transition: all 0.3s ease;">
                    Become An Artist
                </button>

                <div id="artistFormContainer">
                    <button id="closeForm"
                        style="position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--primary-color) !important;">&times;
                    </button>

                    <form id="artistFormSubmit" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="artist_image">Profile Picture</label>
                            <input type="file" name="artist_image" id="artist_image" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="artist_name">Artist Name</label>
                            <input type="text" name="artist_name" id="artist_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="artist_genre">Genre</label>
                            <input type="text" name="artist_genre" id="artist_genre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" name="location" id="location" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-lg"
                            style="background-color: var(--primary-color); color: var(--light-bg); margin-top: 20px; padding: 10px 30px; border-radius: 30px; text-transform: uppercase; font-weight: bold; width: 100%;">
                            Submit
                        </button>
                    </form>
                </div>

                <div id="overlay"></div>
            <?php elseif ($artist_post_id || current_user_can('artist')): ?>
                <a href="<?php echo get_permalink($artist_post_id); ?>" class="btn btn-lg"
                    style="background-color: var(--light-bg); color: var(--primary-color)!important; padding: 12px 40px; border-radius: 50px; text-transform: uppercase; font-weight: bold; transition: all 0.3s ease;">
                    See Profile
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div id="content" class="content-section py-5" style="background-color: var(--mid-bg); border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; padding-top: 8px !important;">
                
    <div class="container py-5">
        <!-- Donate to Artists Section -->
        <div class="row align-items-center mb-5 py-4" style="background: linear-gradient(135deg, rgba(220,78,119,0.9), rgba(142,50,87,0.9)); border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
            <div class="col-md-8 text-md-start text-center ps-md-5 ps-3"> <!-- Added ps-md-5 and ps-3 for left padding -->
                <h2 style="color: var(--light-bg); font-weight: bold; padding-bottom: 20px;">
                    <i class="fas fa-donate" style="margin-right: 10px;"></i>Donate to Artists
                </h2>
                <p style="color: var(--light-bg); font-size: 1.1rem; line-height: 1.6;">
                    Show your support to your favorite artists by donating. Your contributions help them create more amazing music and continue their creative journey. While you get to enjoy and share their work.
                </p>
                <p style="color: var(--light-bg); font-size: 1.1rem; line-height: 1.6;">
                    Your donations are secure and go directly to the artists. You can donate any amount you like, and every bit helps.
                </p>
                <a href="<?php echo get_post_type_archive_link('single')?>" class="btn btn-lg mt-3"
                    style="background-color: var(--light-bg); color: var(--primary-color)!important; padding: 12px 40px; border-radius: 50px; text-transform: uppercase; font-weight: bold; transition: all 0.3s ease;">
                    Donate Now
                </a>
            </div>
            <div class="col-md-4 text-md-end text-center">
                <img
                    src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/paypal-feature.png'); ?>"
                    alt="Feature Image 1"
                    class="img-fluid rounded"
                    style="max-width: 100%; height: auto; border-radius: 10px;" />
            </div>
        </div>

        <!-- Join Our Community Section -->
        <div class="row align-items-center mb-5 py-4 flex-md-row-reverse" style="background: linear-gradient(135deg, rgba(142,50,87,0.9), rgba(220,78,119,0.9)); border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
            <div class="col-md-8 text-md-start text-center ps-md-5 ps-3"> <!-- Added ps-md-5 and ps-3 for left padding -->
                <h2 style="color: var(--light-bg); font-weight: bold; padding-bottom: 20px;">
                    <i class="fas fa-users" style="margin-right: 10px;"></i>Listen to Music, Share, and Connect
                </h2>
                <p style="color: var(--light-bg); font-size: 1.1rem; line-height: 1.6;">
                    Join our community of music lovers and artists. Discover new music, share your tracks, and connect with artists from around the world. Get access to exclusive content, and more.
                </p>
                <p style="color: var(--light-bg); font-size: 1.1rem; line-height: 1.6;">
                    Connect with like-minded individuals, share your thoughts, and enjoy the vibrant community of music enthusiasts. Whether you're an artist or a fan, there's a place for you here.
            </div>
            <div class="col-md-4 text-md-start text-center">
                <img
                    src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/player-feature.png'); ?>"
                    alt="Feature Image 2"
                    class="img-fluid rounded"
                    style="max-width: 100%; height: auto; border-radius: 10px;" />
            </div>
        </div>
    </div>
    
        <div class="container">
            <div class="row">
                <?php
                // Query for Latest Singles
                $singles_args = [
                    'post_type' => 'single',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ];

                $singles_query = new WP_Query($singles_args);
                ?>

                <?php if ($singles_query->have_posts()): ?>
                    <h2 class="text-center" style="color: var(--primary-color); font-weight: bold; margin-bottom: 40px;">
                        Latest Singles</h2>
                    <div class="row">
                        <?php while ($singles_query->have_posts()):
                            $singles_query->the_post(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 text-center"
                                    style="border: 1px solid var(--border-color); border-radius: 10px; background-color: var(--input-bg); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                    <?php if (has_post_thumbnail()): ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail', ['class' => 'card-img-center', 'style' => 'margin: 10px; border-radius: 10px;']); ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="card-body" style="padding: 20px;">
                                        <h5 class="card-title" style="font-weight: bold; margin-bottom: 15px;">
                                            <a href="<?php the_permalink(); ?>"
                                                style="color: var(--primary-color); text-decoration: none; transition: color 0.3s ease;">
                                                <?php the_title(); ?>
                                            </a>
                                        </h5>
                                        <p class="card-text"
                                            style="color: var(--secondary-text); font-size: 0.95rem; line-height: 1.6;">
                                            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                        </p>
                                    </div>
                                    <div class="card-footer text-center"
                                        style="background-color: var(--light-bg); padding: 15px;">
                                        <a href="<?php the_permalink(); ?>" class="btn"
                                            style="background-color: var(--primary-color); color: var(--light-bg) !important; padding: 10px 30px; border-radius: 30px; text-transform: uppercase; font-weight: bold; font-size: 0.9rem; transition: background-color 0.3s ease;">
                                            View Release
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php else: ?>
                    <p class="text-center" style="font-size: 1.2rem; color: var(--secondary-text);">No singles found.</p>
                <?php endif; ?>

                <?php
                // Query for Latest Albums
                $albums_args = [
                    'post_type' => 'album',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ];

                $albums_query = new WP_Query($albums_args);
                ?>

                <?php if ($albums_query->have_posts()): ?>
                    <h2 class="text-center"
                        style="color: var(--primary-color); font-weight: bold; margin-top: 60px; margin-bottom: 40px;">
                        Latest Albums</h2>
                    <div class="row">
                        <?php while ($albums_query->have_posts()):
                            $albums_query->the_post(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 text-center"
                                    style="border: 1px solid var(--border-color); border-radius: 10px; background-color: var(--input-bg); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                    <?php if (has_post_thumbnail()): ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail', ['class' => 'card-img-center', 'style' => 'margin: 10px; border-radius: 10px;']); ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="card-body" style="padding: 20px;">
                                        <h5 class="card-title" style="font-weight: bold; margin-bottom: 15px;">
                                            <a href="<?php the_permalink(); ?>"
                                                style="color: var(--primary-color); text-decoration: none; transition: color 0.3s ease;">
                                                <?php the_title(); ?>
                                            </a>
                                        </h5>
                                        <p class="card-text"
                                            style="color: var(--secondary-text); font-size: 0.95rem; line-height: 1.6;">
                                            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                        </p>
                                    </div>
                                    <div class="card-footer text-center"
                                        style="background-color: var(--light-bg); padding: 15px;">
                                        <a href="<?php the_permalink(); ?>" class="btn"
                                            style="background-color: var(--primary-color); color: var(--light-bg) !important; padding: 10px 30px; border-radius: 30px; text-transform: uppercase; font-weight: bold; font-size: 0.9rem; transition: background-color 0.3s ease;">
                                            View Release
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php else: ?>
                    <p class="text-center" style="font-size: 1.2rem; color: var(--secondary-text);">No albums found.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

<script>
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

    document.getElementById('becomeArtistBtn')?.addEventListener('click', function () {
        document.getElementById('overlay').classList.add('active');
        const form = document.getElementById('artistFormContainer');
        form.style.display = 'block';
        setTimeout(() => form.classList.add('active'), 10); // Small delay for smooth transition
    });

    document.getElementById('closeForm')?.addEventListener('click', function () {
        const form = document.getElementById('artistFormContainer');
        form.classList.remove('active');
        document.getElementById('overlay').classList.remove('active');

        setTimeout(() => {
            form.style.display = 'none';
        }, 400); // Matches transition duration
    });

    document.getElementById('overlay')?.addEventListener('click', function () {
        const form = document.getElementById('artistFormContainer');
        form.classList.remove('active');
        document.getElementById('overlay').classList.remove('active');

        setTimeout(() => {
            form.style.display = 'none';
        }, 400);
    });
</script>

<?php get_footer(); ?>