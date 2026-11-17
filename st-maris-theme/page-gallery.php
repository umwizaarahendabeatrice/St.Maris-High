<?php
/*
Template Name: Gallery
*/
get_header();
stmaris_hero( 'hero-gallery', 'Visual Tour', 'School Gallery', 'Explore photos from our school activities, facilities, and student life.' );
$photos = array(
	array( 'lib.jpg', 'Library' ),
	array( 'bus.jpg', 'School Bus' ),
	array( 'mdd.jpg', 'MDD / Music' ),
	array( 'lab.jpg', 'Science Lab' ),
	array( 'computer-lab.jpg', 'Computer Lab' ),
	array( 'smart-classrooms.jpg', 'Smart Classroom' ),
	array( 'football-court.jpg', 'Sports' ),
	array( 'assembly.jpg', 'Assembly' ),
	array( 'compound-2.jpg', 'School Compound' ),
);
?>
<section class="section">
  <div class="container">
    <div class="grid">
      <?php foreach ( $photos as $p ) : ?>
        <div class="card photo"><img src="<?php echo stmaris_img( $p[0] ); ?>" alt="<?php echo esc_attr( $p[1] ); ?>"><div><h3><?php echo esc_html( $p[1] ); ?></h3></div></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php stmaris_editor_content(); ?>
<?php get_footer(); ?>
