<?php
/*

Template Name: Fullwidth

*/

get_header(); ?>

	<div id="primary" class="content-area col-md-10 nosidebar">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>
			<div class="posts-loop">
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'single' );

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
