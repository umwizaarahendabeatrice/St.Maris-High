<?php
/**
 * St Maris High School theme functions.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- School details: edit once, used everywhere ---------- */
function stmaris_info( $key ) {
	$info = array(
		'name'    => 'St Maris High School',
		'address' => 'Plot 42, Muyenga Hill, Kampala',
		'email'   => 'info@stmarishigh.sc.ug',
		'phone'   => '+256 772 279 126',
		'hours'   => 'Mon - Fri: 8:00 AM - 5:00 PM',
	);
	return isset( $info[ $key ] ) ? $info[ $key ] : '';
}

/* ---------- Theme setup ---------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus( array( 'primary' => 'Primary Menu' ) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'stmaris-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
} );

/* ---------- Helpers ---------- */
function stmaris_img( $file ) {
	return esc_url( get_theme_file_uri( 'assets/images/' . $file ) );
}

function stmaris_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

function stmaris_fallback_menu() {
	$items = array( 'Home' => home_url( '/' ), 'About Us' => stmaris_page_url( 'about-us' ), 'Academics' => stmaris_page_url( 'academics' ), 'Gallery' => stmaris_page_url( 'gallery' ), 'Contact' => stmaris_page_url( 'contact-us' ) );
	echo '<ul class="menu">';
	foreach ( $items as $label => $url ) {
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

function stmaris_hero( $class, $small, $title, $text = '' ) {
	echo '<section class="hero ' . esc_attr( $class ) . '"><div class="container">';
	echo '<small>' . esc_html( $small ) . '</small><h1>' . esc_html( $title ) . '</h1>';
	if ( $text ) { echo '<p>' . esc_html( $text ) . '</p>'; }
	echo '</div></section>';
}

/* Anything typed in the normal WordPress page editor shows below the template content. */
function stmaris_editor_content() {
	if ( ! have_posts() ) { return; }
	the_post();
	$content = trim( get_the_content() );
	if ( $content !== '' ) {
		echo '<section class="section section-white"><div class="container entry-content">';
		the_content();
		echo '</div></section>';
	}
}

/* ---------- Create pages, menu and pretty links (runs on activation, and again if anything is missing) ---------- */
function stmaris_find_page( $slug ) {
	$found = get_posts( array(
		'name'           => $slug,
		'post_type'      => 'page',
		'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'trash' ),
		'posts_per_page' => 1,
	) );
	return $found ? $found[0] : null;
}

function stmaris_setup() {
	$pages = array(
		'home'       => 'Home',
		'about-us'   => 'About Us',
		'academics'  => 'Academics',
		'gallery'    => 'Gallery',
		'contact-us' => 'Contact Us',
		'apply'      => 'Apply',
	);
	$ids = array();
	foreach ( $pages as $slug => $title ) {
		$page = stmaris_find_page( $slug );
		if ( $page ) {
			if ( 'publish' !== $page->post_status ) {
				wp_update_post( array( 'ID' => $page->ID, 'post_status' => 'publish' ) );
			}
			$ids[ $slug ] = $page->ID;
		} else {
			$ids[ $slug ] = wp_insert_post( array( 'post_title' => $title, 'post_name' => $slug, 'post_status' => 'publish', 'post_type' => 'page' ) );
		}
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $ids['home'] );

	// Pretty links like /about-us/ (plain links break page templates on some hosts).
	if ( '' === get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}

	// Menu: create ours if the Primary location is empty or its menu has no items.
	$locations = get_nav_menu_locations();
	$assigned  = ! empty( $locations['primary'] ) ? wp_get_nav_menu_items( $locations['primary'] ) : array();
	if ( empty( $assigned ) ) {
		$menu = wp_get_nav_menu_object( 'Main Menu' );
		$menu_id = $menu ? $menu->term_id : wp_create_nav_menu( 'Main Menu' );
		if ( ! is_wp_error( $menu_id ) ) {
			if ( ! wp_get_nav_menu_items( $menu_id ) ) {
				$menu_items = array( 'home' => 'Home', 'about-us' => 'About Us', 'academics' => 'Academics', 'gallery' => 'Gallery', 'contact-us' => 'Contact' );
				foreach ( $menu_items as $slug => $label ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-title'     => $label,
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $ids[ $slug ],
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					) );
				}
			}
			$locations['primary'] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	update_option( 'stmaris_setup_version', '2' );
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'stmaris_setup' );
add_action( 'admin_init', function () {
	if ( get_option( 'stmaris_setup_version' ) !== '2' && current_user_can( 'manage_options' ) ) {
		stmaris_setup();
	}
} );

/* ---------- Form handling (contact + application) ---------- */
function stmaris_clean( $key ) {
	return isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
}

function stmaris_handle_form( $type ) {
	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'stmaris_' . $type ) ) {
		wp_die( 'Security check failed. Please go back and try again.' );
	}
	$back = wp_get_referer() ? remove_query_arg( 'sent', wp_get_referer() ) : home_url( '/' );

	// Honeypot: real visitors leave this empty.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $back ) );
		exit;
	}

	$headers  = array( 'Content-Type: text/plain; charset=UTF-8' );
	$reply_to = is_email( stmaris_clean( 'email' ) ) ? stmaris_clean( 'email' ) : '';
	if ( $reply_to ) { $headers[] = 'Reply-To: ' . $reply_to; }

	if ( 'contact' === $type ) {
		$subject = 'Website message from ' . stmaris_clean( 'full_name' );
		$body    = "Name: " . stmaris_clean( 'full_name' ) . "\nEmail: " . stmaris_clean( 'email' ) . "\n\nMessage:\n" . ( isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '' );
	} else {
		$fields = array(
			'first_name' => 'First name', 'last_name' => 'Last name', 'dob' => 'Date of birth', 'class' => 'Class applying for',
			'prev_school' => 'Previous school', 'boarding' => 'Boarding or day', 'guardian_name' => 'Guardian name',
			'relationship' => 'Relationship', 'phone' => 'Phone', 'email' => 'Email', 'address' => 'Home address',
		);
		$subject = 'Application: ' . stmaris_clean( 'first_name' ) . ' ' . stmaris_clean( 'last_name' );
		$body    = "NEW APPLICATION\n\n";
		foreach ( $fields as $name => $label ) {
			$body .= $label . ': ' . stmaris_clean( $name ) . "\n";
		}
		$body .= "\nNotes:\n" . ( isset( $_POST['notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['notes'] ) ) : '' ) . "\n";
	}

	$ok = wp_mail( stmaris_info( 'email' ), $subject, $body, $headers );
	wp_safe_redirect( add_query_arg( 'sent', $ok ? '1' : '0', $back ) );
	exit;
}
add_action( 'admin_post_nopriv_stmaris_contact', function () { stmaris_handle_form( 'contact' ); } );
add_action( 'admin_post_stmaris_contact',        function () { stmaris_handle_form( 'contact' ); } );
add_action( 'admin_post_nopriv_stmaris_apply',   function () { stmaris_handle_form( 'apply' ); } );
add_action( 'admin_post_stmaris_apply',          function () { stmaris_handle_form( 'apply' ); } );

function stmaris_form_notice() {
	if ( ! isset( $_GET['sent'] ) ) { return; }
	if ( '1' === $_GET['sent'] ) {
		echo '<div class="notice notice-ok">Thank you! Your message has been sent. We will get back to you soon.</div>';
	} else {
		echo '<div class="notice notice-err">Sorry, something went wrong sending your message. Please email us directly at ' . esc_html( stmaris_info( 'email' ) ) . '.</div>';
	}
}

/* ---------- Browser tab titles exactly as in the original site ---------- */
add_filter( 'pre_get_document_title', function ( $title ) {
	$school = stmaris_info( 'name' );
	if ( is_front_page() ) { return 'Kampala, Uganda | ' . $school; }
	if ( is_page() ) { return get_the_title() . ' | ' . $school; }
	return $title;
} );
