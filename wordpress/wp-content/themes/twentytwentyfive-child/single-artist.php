<?php get_header(); 
$genre = get_field('artist_genre');
$artist_location = get_field('location');
?>

<div class="container-fluid" style="background-color: var(--light-bg); color: var(--primary-text); font-family: 'Lato', sans-serif; ">
    <!-- Hero Section -->
    <div class="hero-section py-5 d-flex align-items-center" style="background: radial-gradient(circle, rgba(220,78,119,1) 0%, rgba(142,50,87,1) 100%); color: var(--light-bg); border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <div class="container">
            <div class="row align-items-center">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="col-md-4 text-center text-md-start">
                        <?php the_post_thumbnail('large', [
                            'class' => 'img-fluid',
                            'style' => 'border-radius: 10px; max-height: 300px; object-fit: cover;',
                        ]); ?>
                    </div>
                <?php endif; ?>
                <div class="col-md-8 d-flex flex-column justify-content-center text-center">
                    <h1 class="display-4" style="font-weight: bold; letter-spacing: 1px;"><?php the_title(); ?></h1>
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
                        <div class="post-content" style="line-height: 1.8;">
                            <?php 
                            if ($genre) {
                                echo '<p><strong>Genre:</strong> ' . esc_html($genre) . '</p>';
                            }
                            
                            if ($artist_location) {
                                echo '<p><strong>Location:</strong> ' . esc_html($artist_location) . '</p>';
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
                        'post_type' => ['single', 'album', 'vinyl'],
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
