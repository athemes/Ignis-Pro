<?php
/**
 * Footer functions
 *
 * @package Ignis
 */

/**
 * Footer menu
 */
function ignis_footer_social_menu() {
	$cf 			= get_theme_mod( 'contact_shortcode' );
    $footer_image   = get_theme_mod( 'footer_banner' );

	if ( $footer_image ) {
		$has_banner = 'has-banner';
	} else {
		$has_banner = '';
	}

	if ( $cf ) {
		$has_contact = 'has-contact';
	} else {
		$has_contact = '';
	}
?>
	<div class="footer-banner <?php echo $has_banner; ?> <?php echo $has_contact; ?>">

		<?php if ( $cf ) : ?>
		<div class="footer-contact-form">
			<?php echo do_shortcode( wp_kses_post( $cf ) ); ?>
		</div>
		<?php endif; ?>
		<?php if ( has_nav_menu( 'social' ) ) : ?>
		<nav class="social-navigation clearfix">
			<?php wp_nav_menu( array( 'theme_location' => 'social', 'link_before' => '<span class="screen-reader-text">', 'link_after' => '</span>', 'container_class' => 'container', 'menu_class' => 'menu clearfix', 'fallback_cb' => false ) ); ?>
		</nav>
		<?php endif; ?>

	</div>
	<?php
}
add_action('ignis_footer', 'ignis_footer_social_menu', 8);

/**
 * Footer credits
 */
function ignis_footer_credits() {

	    $credits = get_theme_mod('footer_credits');

	?>
		<div class="site-info">
		<?php if ( $credits ) : ?>
			<?php echo wp_kses_post( $credits ); ?>
		<?php else : ?>
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'ignis' ) ); ?>" rel="nofollow"><?php printf( esc_html__( 'Proudly powered by %s', 'ignis' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %2$s by %1$s.', 'ignis' ), 'aThemes', '<a href="https://athemes.com/theme/ignis-pro" rel="nofollow">Ignis Pro</a>' ); ?>
		<?php endif; ?>
		</div><!-- .site-info -->
	<?php
}
add_action('ignis_footer', 'ignis_footer_credits', 9);