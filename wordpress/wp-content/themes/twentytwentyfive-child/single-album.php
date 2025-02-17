<?php get_header(); 
$genre = get_field('genre');
$duration = get_field('duration');
$tracklist = get_field('album_tracklist');
?>

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
                <div class="col-md-8 offset-md-2">
                    <div class="post-content" style="line-height: 1.8; background-color: var(--light-bg); padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px var(--accent-light);">
                        
                        <?php 
                        if ($genre || $duration) {
                            echo '<div class="row">'; 
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
                        if ($tracklist) {
                            echo '<div class="tracklist mt-4">';
                            echo '<h4 class="mb-3" style="font-weight: bold;">Tracklist:</h4>';
                            echo '<pre id="tracklist-content" style="white-space: pre-wrap; word-wrap: break-word; background-color: var(--mid-bg); padding: 15px; border-radius: 10px; box-shadow: inset 0 2px 4px var(--primary-hover); transition: box-shadow 0.3s ease;">' . esc_html($tracklist) . '</pre>';
                            echo '</div>';
                        }

                        the_content(); ?>

                    </div>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>
</div>

</div>

<?php get_footer(); ?>