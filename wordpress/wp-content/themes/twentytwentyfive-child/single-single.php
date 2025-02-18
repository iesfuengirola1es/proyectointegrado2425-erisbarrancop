<?php get_header(); 
$genre = get_field('genre');
$duration = get_field('duration');
$artist_paypal = get_field('artist_paypal_email');
$tracks = get_field('track');

$track_url = '';
if ($tracks) {
    // If it's a file field (ACF returns an array)
    if (is_array($tracks) && isset($tracks['url'])) {
        $track_url = $tracks['url'];
    } else {
        // If it's a direct URL string
        $track_url = $tracks;
    }
}

?>

<div class="container-fluid" style="background-color: var(--light-bg); color: var(--primary-hover); font-family: 'Lato', sans-serif;">
    <!-- Hero Section -->
    <div class="hero-section py-5 d-flex align-items-center" style="background: radial-gradient(circle, rgba(220,78,119,1) 0%, rgba(142,50,87,1) 100%); color: var(--light-bg); border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <div class="container">
            <div class="row align-items-center">
                <?php if (has_post_thumbnail()) : ?>
                    <!-- Single Cover Image -->
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
                    <p class="lead mt-3" style="font-size: 1.2rem;">
                        Released on <?php echo get_the_date(); ?>
                    </p>
                    <?php 
                    // Get related artist field
                    $related_artist = get_field('related_artist');
                    if ($related_artist): 
                        foreach ($related_artist as $artist): ?>
                            <p class="mt-3" style="font-size: 1.2rem;">
                                by <a href="<?php echo get_permalink($artist->ID); ?>" style="color: var(--primary-hover); text-decoration: none; font-weight: bold;">
                                    <?php echo get_the_title($artist->ID); ?>
                                </a>
                            </p>
                        <?php endforeach; 
                    endif; 
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div id="content" class="content-section py-5" style="background-color: var(--mid-bg); border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
        <div class="container">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="row">
                    <!-- Main Content Column -->
                    <div class="col-md-8">
                        <div class="post-content" style="line-height: 1.8; background-color: var(--light-bg); padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px var(--accent-light);">
                            <?php 
                            if ($genre || $duration) {
                                echo '<div class="row mb-4">'; // Added mb-4 to the row
                                if ($genre) {
                                    echo '<div class="col-md-6 mt-4">'; 
                                    echo '<h4 class="mb-3" style="font-weight: bold;">Genre:</h4>';
                                    echo '<div id="genre-content" style="white-space: pre-wrap; word-wrap: break-word; background-color: var(--mid-bg); padding: 15px; border-radius: 10px; box-shadow: inset 0 2px 4px var(--primary-hover); transition: box-shadow 0.3s ease;">' . esc_html($genre) . '</div>';
                                    echo '</div>';
                                }
                                
                                if ($duration) {
                                    echo '<div class="col-md-6 mt-4">'; 
                                    echo '<h4 class="mb-3" style="font-weight: bold;">Duration:</h4>';
                                    echo '<div id="duration-content" style="white-space: pre-wrap; word-wrap: break-word; background-color: var(--mid-bg); padding: 15px; border-radius: 10px; box-shadow: inset 0 2px 4px var(--primary-hover); transition: box-shadow 0.3s ease;">' . esc_html($duration) . '</div>';
                                    echo '</div>';
                                }
                                echo '</div>'; 
                            }
                            
                            the_content(); 
                            ?>
                        </div>
                    </div>

                    <!-- PayPal Column -->
                    <div class="col-md-4">
                        <div class="paypal-content" style="background-color: var(--light-bg); padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px var(--accent-light);">
                            <h4 class="mb-3" style="font-weight: bold; text-align: center;">Donate to <?php echo get_the_title($artist->ID); ?></h4>
                            <div id="pay-what-you-like" class="pay-what-you-like-section mb-4">
                                <div class="amount-container">
                                    <div class="preset-amounts">
                                        <button class="preset-amount" data-amount="1">1€</button>
                                        <button class="preset-amount" data-amount="2">2€</button>
                                        <button class="preset-amount" data-amount="5">5€</button>
                                        <button class="preset-amount" data-amount="10">10€</button>
                                    </div>
                                </div>
                                <div class="custom-amount">
                                    <input type="number" id="custom-amount-input" class="form-control" placeholder="Enter amount" min="1" step="0.01" />
                                </div>
                                <div id="paypal-button-container"></div>
                            </div>
                            <?php if (!empty($track_url)) : ?>
                            <!-- Download Track Without Donation (Separate from PayPal) -->
                            <div class="text-center mt-3">
                                <p>Don't want to donate?  
                                <a id="download-track-link" href="#" style="color: var(--primary-hover); font-weight: bold; text-decoration: none;">
                                    Download track instead!
                                </a>
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Hidden fields for amount and PayPal email -->
                <input type="hidden" id="amount" value="1"> <!-- Default amount is €1 -->
                <input type="hidden" id="artist-email" value="<?php echo esc_attr($artist_paypal); ?>">
                <input type="hidden" id="track-file" value="<?php echo esc_url($track_url); ?>">
            <?php endwhile; endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>