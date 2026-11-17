</main>

<footer class="footer">
  <div class="container grid">
    <div><strong><?php echo esc_html( stmaris_info( 'name' ) ); ?></strong><br><?php echo esc_html( stmaris_info( 'address' ) ); ?></div>
    <div><strong>Contact</strong><br>
      <a href="mailto:<?php echo esc_attr( stmaris_info( 'email' ) ); ?>"><?php echo esc_html( stmaris_info( 'email' ) ); ?></a><br>
      <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', stmaris_info( 'phone' ) ) ); ?>"><?php echo esc_html( stmaris_info( 'phone' ) ); ?></a></div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
