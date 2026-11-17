<?php get_header(); ?>
<section class="section">
  <div class="container entry-content">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php the_excerpt(); ?>
    <?php endwhile; else : ?>
      <h2>Nothing found</h2>
      <p>Sorry, we could not find that page. <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Return home</a>.</p>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>
