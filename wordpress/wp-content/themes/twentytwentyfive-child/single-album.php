<?php get_header(); 
$genre = get_field('genre');
$duration = get_field('duration');
$tracklist = get_field('album_tracklist'); // Retrieve the tracklist field
?>

<div class="container-fluid" style="background-color: var(--light-bg); color: var(--primary-text); font-family: 'Lato', sans-serif;">
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
                            if ($genre || $duration) {
                                echo '<div class="info-box mb-4" style="background-color: var(--mid-bg); padding: 15px; border-radius: 10px; box-shadow: inset 0 2px 4px var(--primary-hover); transition: box-shadow 0.5s ease">';
                                if ($genre) {
                                    echo '<p style="font-size: 1.2rem; margin-bottom: 10px;"><strong>Genre:</strong> ' . esc_html($genre) . '</p>';
                                }
                                
                                if ($duration) {
                                    echo '<p style="font-size: 1.2rem; margin-bottom: 10px;"><strong>Duration:</strong> ' . esc_html($duration) . '</p>';
                                }
                                echo '</div>';
                            }
                            
                            if ($tracklist) {
                                echo '<div class="tracklist mt-4">';
                                echo '<h4 class="mb-3" style="font-weight: bold;">Tracklist:</h4>';
                                echo '<pre id="tracklist-content" style="white-space: pre-wrap; word-wrap: break-word; background-color: var(--mid-bg); padding: 15px; border-radius: 10px; box-shadow: inset 0 2px 4px var(--primary-hover); transition: box-shadow 0.5s ease">' . esc_html($tracklist) . '</pre>';
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