<?php get_header(); ?>

<div class="container-fluid" style="background-color: var(--light-bg); color: var(--primary-text); font-family: 'Lato', sans-serif; height: 100vh; display: flex; flex-direction: column;">
    <!-- Hero Section -->
    <div class="hero-section text-center py-5" style="background: radial-gradient(circle, rgba(220,78,119,1) 0%, rgba(142,50,87,1) 100%); color: var(--light-bg); border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <div class="container">
            <h1 class="display-4" style="font-weight: bold; letter-spacing: 1px; margin-bottom: 20px;">
                Welcome to <?php bloginfo('name'); ?>
            </h1>
            <p class="lead" style="font-size: 1.2rem; margin-bottom: 30px;">Your gateway to awesome content and ideas.</p>
            <a href="#content" class="btn btn-lg" style="background-color: var(--light-bg); color: var(--primary-color)!important; padding: 12px 40px; border-radius: 50px; text-transform: uppercase; font-weight: bold; transition: all 0.3s ease;">
                Explore More
            </a>
        </div>
    </div>

    <!-- Scrollable Content Section -->
    <div id="content" class="content-section py-5 flex-grow-1" style="background-color: var(--mid-bg); border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; overflow-y: auto;">
        <div class="container">
            <div class="row">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100" style="border: 1px solid var(--border-color); border-radius: 10px; background-color: var(--input-bg); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'style' => 'border-top-left-radius: 10px; border-top-right-radius: 10px;']); ?>
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
                                        Read More
                                    </a>
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
