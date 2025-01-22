<?php

get_header(); ?>

<div class="container-fluid" style="background-color: var(--light-bg); color: var(--primary-text); font-family: 'Lato', sans-serif;">
    <!-- Hero Section -->
    <div class="hero-section text-center py-5" style="background: var(--mid-bg); color: var(--input-bg); border-bottom: 2px solid var(--primary-color);">
        <div class="container">
            <h1 class="display-4" style="font-weight: bold; letter-spacing: 1px; color: var(--primary-text);">Welcome to <?php bloginfo('name'); ?></h1>
            <p class="lead" style="font-size: 1.25rem; margin-bottom: 20px;">Your gateway to awesome content and ideas.</p>
            <a href="#content" class="btn btn-light btn-lg" style="background-color: var(--input-bg); color: var(--primary-color); border: none; padding: 10px 30px; border-radius: 50px; transition: all 0.3s ease;">Explore More</a>
        </div>
    </div>

    <!-- Content Section -->
    <div id="content" class="content-section py-5" style="background-color: var(--light-bg);">
        <div class="container">
            <div class="row">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100" style="border: 1px solid var(--border-color); border-radius: 10px; background-color: var(--input-bg); box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease;">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'style' => 'border-top-left-radius: 10px; border-top-right-radius: 10px;']); ?>
                                    </a>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title" style="color: var(--primary-color); font-weight: bold;">
                                        <a href="<?php the_permalink(); ?>" style="color: var(--primary-color); text-decoration: none; transition: color 0.3s ease;">
                                            <?php the_title(); ?>
                                        </a>
                                    </h5>
                                    <p class="card-text" style="color: var(--secondary-text); font-size: 0.95rem;">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                    </p>
                                </div>
                                <div class="card-footer" style="background-color: var(--light-bg); text-align: center;">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary" style="background-color: var(--primary-color); color: var(--input-bg); border-radius: 20px; padding: 8px 20px; text-transform: uppercase; font-size: 0.9rem; transition: background-color 0.3s ease;">Read More</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p class="text-center" style="font-size: 1.2rem; color: var(--secondary-text);">Sorry, no posts were found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Add hover effect on cards
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'scale(1.03)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'scale(1)';
        });
    });
</script>

<?php get_footer(); ?>
