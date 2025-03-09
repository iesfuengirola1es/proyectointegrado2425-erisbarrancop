<?php get_header(); 
$genre = get_field('artist_genre');
$artist_location = get_field('location');
$soundcloud_link = get_field('soundcloud_link');
$youtube_link = get_field('youtube_link');
?>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container-fluid" style="background-color: var(--light-bg); color: var(--primary-hover); font-family: 'Lato', sans-serif;">
    <!-- Hero Section -->
    <div class="hero-section py-5 d-flex align-items-center" style="background: radial-gradient(circle, rgba(220,78,119,1) 0%, rgba(142,50,87,1) 100%); color: var(--light-bg); border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <div class="container">
            <div class="row align-items-center">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="col-md-4 text-center text-md-start">
                        <?php the_post_thumbnail('large', [
                            'class' => 'img-fluid',
                            'style' => 'border-radius: 10px; max-height: 300px; object-fit: cover; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);',
                        ]); ?>
                    </div>
                <?php endif; ?>
                <div class="col-md-8 d-flex flex-column justify-content-center text-center">
                    <h1 class="display-4" style="font-weight: bold; letter-spacing: 1px; color: var(--light-bg); text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                        <?php the_title(); ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div id="content" class="content-section py-5" style="background-color: var(--mid-bg); border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
        <div class="container">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="post-content" style="line-height: 1.8; background-color: var(--light-bg); padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px var(--accent-light);">

                             <?php 
                            // Display genre and location
                            if ($genre || $artist_location || $soundcloud_link || $youtube_link) {
                                echo '<div class="row mb-4">'; // Added mb-4 for spacing
                                if ($genre) {
                                    echo '<div class="col-md-6 mt-4">';
                                    echo '<h4 class="mb-3" style="font-weight: bold;">Genre:</h4>';
                                    echo '<div id="genre-content" style="white-space: pre-wrap; word-wrap: break-word; background-color: var(--mid-bg); padding: 15px; border-radius: 10px; box-shadow: inset 0 2px 4px var(--primary-hover); transition: box-shadow 0.3s ease;">';
                                    echo '<i class="fas fa-music" style="margin-right: 10px; color: var(--primary-color);"></i>'; // Music icon inside the container
                                    echo esc_html($genre);
                                    echo '</div>';
                                    echo '</div>';
                                }
                                
                                if ($artist_location) {
                                    echo '<div class="col-md-6 mt-4">';
                                    echo '<h4 class="mb-3" style="font-weight: bold;">Location:</h4>';
                                    echo '<div id="location-content" style="white-space: pre-wrap; word-wrap: break-word; background-color: var(--mid-bg); padding: 15px; border-radius: 10px; box-shadow: inset 0 2px 4px var(--primary-hover); transition: box-shadow 0.3s ease;">';
                                    echo '<i class="fas fa-map-marker-alt" style="margin-right: 10px; color: var(--primary-color);"></i>'; // Map marker icon inside the container
                                    echo esc_html($artist_location);
                                    echo '</div>';
                                    echo '</div>';
                                }

                                if ($soundcloud_link) {
                                    echo '<div class="col-md-6 mt-4">';
                                    echo '<h4 class="mb-3" style="font-weight: bold;">SoundCloud:</h4>';
                                    echo '<div id="soundcloud-content" style="white-space: pre-wrap; word-wrap: break-word; background-color: var(--mid-bg); padding: 15px; border-radius: 10px; box-shadow: inset 0 2px 4px var(--primary-hover); transition: box-shadow 0.3s ease;">';
                                    echo '<a href="' . esc_url($soundcloud_link) . '" target="_blank" style="color: var(--primary-color); text-decoration: none;">';
                                    echo '<i class="fab fa-soundcloud" style="margin-right: 10px; color: var(--primary-color);"></i>'; // SoundCloud icon
                                    echo esc_html($soundcloud_link);
                                    echo '</a>';
                                    echo '</div>';
                                    echo '</div>';
                                }

                                if ($youtube_link) {
                                    echo '<div class="col-md-6 mt-4">';
                                    echo '<h4 class="mb-3" style="font-weight: bold;">YouTube:</h4>';
                                    echo '<div id="youtube-content" style="white-space: pre-wrap; word-wrap: break-word; background-color: var(--mid-bg); padding: 15px; border-radius: 10px; box-shadow: inset 0 2px 4px var(--primary-hover); transition: box-shadow 0.3s ease;">';
                                    echo '<a href="' . esc_url($youtube_link) . '" target="_blank" style="color: var(--primary-color); text-decoration: none;">';
                                    echo '<i class="fab fa-youtube" style="margin-right: 10px; color: var(--primary-color);"></i>'; // YouTube icon
                                    echo esc_html($youtube_link);
                                    echo '</a>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                echo '</div>';
                            }

                            the_content(); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; endif; ?>

            <!-- Associated Releases Section -->
            <div class="associated-releases mt-5">
                <h2 class="text-center mb-4" style="font-weight: bold; color: var(--primary-color);">Releases by this Artist</h2>
                <div class="row">
                    <?php
                    // Query for associated Singles, Albums, and Vinyls
                    $artist_id = get_the_ID();
                    $args = [
                        'post_type' => ['single', 'album'],
                        'meta_query' => [
                            [
                                'key' => 'related_artist', // ACF field name
                                'value' => '"' . $artist_id . '"', // Serialized ID for matching
                                'compare' => 'LIKE',
                            ],
                        ],
                    ];
                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 text-center" style="border: 1px solid var(--border-color); border-radius: 10px; background-color: var(--input-bg); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail', ['class' => 'card-img-center', 'style' => 'margin: 10px; border-radius: 10px;']); ?>
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
                                            View Release
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    else : ?>
                        <p class="text-center" style="font-size: 1.2rem; color: var(--secondary-text);">No releases found for this artist.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

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
</script>

<?php get_footer(); ?>