<?php
/*
Template Name: Contact Us
*/
?>
<?php get_header(); ?>
<?php stmaris_hero( 'hero-contact', 'Get in Touch', 'Contact Us', 'We would love to hear from you.' ); ?>

<section class="section">
  <div class="container">
    <?php stmaris_form_notice(); ?>
    <div class="grid">
      <div class="card">
        <h3>Send Us a Message</h3>
        <form class="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
          <input type="hidden" name="action" value="stmaris_contact">
          <?php wp_nonce_field( 'stmaris_contact' ); ?>
          <div class="hp-field" aria-hidden="true"><label>Leave this empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
          <input type="text" name="full_name" placeholder="Full Name" aria-label="Full Name" required>
          <input type="email" name="email" placeholder="Email Address" aria-label="Email Address" required>
          <textarea name="message" placeholder="Your Message" rows="4" aria-label="Your Message" required></textarea>
          <button type="submit" class="btn">Send Message</button>
        </form>
      </div>
      <div class="card">
        <h3>Contact Details</h3>
        <div class="details">
          <p><strong>Location:</strong> <?php echo esc_html( stmaris_info( 'address' ) ); ?></p>
          <p><strong>Phone:</strong> <?php echo esc_html( stmaris_info( 'phone' ) ); ?></p>
          <p><strong>Email:</strong> <?php echo esc_html( stmaris_info( 'email' ) ); ?></p>
          <p><strong>Working Hours:</strong> <?php echo esc_html( stmaris_info( 'hours' ) ); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php stmaris_editor_content(); ?>
<?php get_footer(); ?>
