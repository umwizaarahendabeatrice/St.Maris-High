<?php
/*
Template Name: About Us
*/
?>
<?php get_header(); ?>
<?php stmaris_hero( 'hero-about', 'Our Story', 'About ' . stmaris_info( 'name' ), 'Our Story, Our Mission' ); ?>

<section class="section">
  <div class="container">
    <div class="grid">
      <div class="card"><h3>Our Mission</h3><p>To provide quality education that empowers students to learn, grow, and lead with integrity, curiosity, and compassion in a nurturing environment where every student is valued and supported.</p></div>
      <div class="card"><h3>Our Vision</h3><p>To be a leading institution recognized for academic excellence, character development, and preparing students to become confident, responsible global citizens ready to make a positive impact in the world.</p></div>
      <div class="card"><h3>Core Values</h3>
        <ul class="check-list"><li>Excellence in everything we do</li><li>Integrity and honesty</li><li>Respect for all</li><li>Community and teamwork</li><li>Innovation and lifelong learning</li></ul>
      </div>
    </div>
  </div>
</section>

<section class="stats">
  <div class="container grid">
    <div><strong>1500+</strong>Students enrolled</div>
    <div><strong>98%</strong>Pass rate, UNEB 2024</div>
    <div><strong>45+</strong>Qualified teachers</div>
    <div><strong>25 years</strong>of excellence</div>
  </div>
</section>

<section class="principal">
  <div class="container">
    <img src="<?php echo stmaris_img( 'principal.jpg' ); ?>" alt="Head Teacher">
    <div>
      <h2>Message from the Head Teacher</h2>
      <p>&ldquo;At St Maris High School, we believe that education is more than just academics &mdash; it is about shaping character, inspiring curiosity, and building a community where students thrive. For over 25 years, our dedicated educators and staff have been committed to providing a safe, inclusive, and challenging environment that nurtures each student&rsquo;s potential.&rdquo;</p>
      <p class="name">&mdash; Mrs. Eleanor Hayes, Head Teacher</p>
    </div>
  </div>
</section>

<?php stmaris_editor_content(); ?>
<?php get_footer(); ?>
