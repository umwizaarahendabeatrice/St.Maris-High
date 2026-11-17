<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
  <div class="container">
    <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo stmaris_img( 'Badge.jpg' ); ?>" alt=""><?php echo esc_html( stmaris_info( 'name' ) ); ?></a>
    <nav class="nav" aria-label="Main menu">
      <?php
      wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'menu',
        'fallback_cb'    => 'stmaris_fallback_menu',
      ) );
      ?>
      <a class="btn" href="<?php echo esc_url( stmaris_page_url( 'apply' ) ); ?>">Apply now</a>
    </nav>
  </div>
</header>

<main class="site-main">
