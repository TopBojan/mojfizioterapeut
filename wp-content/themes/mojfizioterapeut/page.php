<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <section class="landing-section page-content">
            <div class="container">
                <h1 class="heading h2"><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>
        </section>
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
