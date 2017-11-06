<?php
/**
 * The template for displaying archive pages for Jetpack portfolio
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ignis
 */

get_header();

$portfolio_type = get_theme_mod( 'portfolio_type', 'portfolio-type-1' );

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>
			<div id="portfolio-wrapper" class="portfolio-wrapper clearfix <?php echo esc_attr( $portfolio_type) ; ?>">
			<div class="ignis-sizer"></div>			
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'portfolio' );

			endwhile; ?>

			</div>
			<?php

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();