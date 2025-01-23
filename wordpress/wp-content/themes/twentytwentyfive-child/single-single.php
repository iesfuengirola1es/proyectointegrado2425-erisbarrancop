<?php get_header(); ?>

<div class="container-fluid" style="background-color: var(--light-bg); color: var(--primary-text); font-family: 'Lato', sans-serif;">
    <!-- Hero Section -->
    <div class="hero-section text-center py-5" style="background: radial-gradient(circle, rgba(220,78,119,1) 0%, rgba(142,50,87,1) 100%); color: var(--light-bg); border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <div class="container">
            <h1 class="display-4" style="font-weight: bold; letter-spacing: 1px; margin-bottom: 20px;">
                <?php the_title(); ?>
            </h1>
            <p class="lead" style="font-size: 1.2rem; margin-bottom: 30px;">
                Published on <?php the_date(); ?>
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div id="content" class="content-section py-5" style="background-color: var(--mid-bg);">
        <div class="container">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="text-center mb-4">
                                <?php the_post_thumbnail('large', ['class' => 'img-fluid', 'style' => 'border-radius: 10px;']); ?>
                            </div>
                        <?php endif; ?>
                        <div class="post-content" style="color: var(--primary-text);">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
