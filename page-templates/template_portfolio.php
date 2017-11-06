<?php
/*

Template Name: Portfolio

*/


get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php do_action( 'ignis_portfolio_before' ); ?>

			<?php
				if ( get_query_var( 'paged' ) ) :
					$paged = get_query_var( 'paged' );
				elseif ( get_query_var( 'page' ) ) :
					$paged = get_query_var( 'page' );
				else :
					$paged = 1;
				endif;

				$portfolio_type = get_theme_mod( 'portfolio_type', 'portfolio-type-1' );

				$posts_per_page = get_option( 'jetpack_portfolio_posts_per_page', '10' );
				$args = array(
					'post_type'      => 'jetpack-portfolio',
					'posts_per_page' => $posts_per_page,
					'paged'          => $paged,
				);
				$project_query = new WP_Query ( $args );
				if ( post_type_exists( 'jetpack-portfolio' ) && $project_query -> have_posts() ) :
			?>
				
				<?php $i = 1; ?>
				<div id="portfolio-wrapper" class="portfolio-wrapper clearfix <?php echo esc_attr( $portfolio_type) ; ?>">
					<div class="ignis-sizer"></div>
					<?php /* Start the Loop */ ?>
					<?php while ( $project_query -> have_posts() ) : $project_query -> the_post(); ?>

						<?php get_template_part( 'template-parts/content', 'portfolio' ); ?>
						
						<?php
						$text = get_theme_mod('loop_text', __( '<p>LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT.</p><a class="button" target="_blank" href="http://example.org">LEARN MORE</a>', 'ignis' ));
						if( ($i == 3) && ($text != '') ) : ?>
						<div class="loop-ribbon wow fadeInUp hentry" data-wow-duration="2s">
							<div class="loop-ribbon-inner">
								<?php echo wp_kses_post($text); ?>
							</div>
						</div>
						<?php endif; ?>

					<?php 
					$i++;
					endwhile; ?>

				</div>
				<?php
					if ($project_query->max_num_pages > 1) { ?>
					<nav class="posts-navigation">
					    <div class="prev-posts-link">
					      <?php echo get_next_posts_link( __( 'Older entries', 'ignis' ), $project_query->max_num_pages ); ?>
					    </div>
					    <div class="next-posts-link">
					      <?php echo get_previous_posts_link( __( 'Newer entries', 'ignis' ) ); ?>
					    </div>
					</nav>
					<?php } 
					wp_reset_postdata();
				?>

			<?php else : ?>

				<section class="no-results not-found">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'ignis' ); ?></h1>
					</header>
					<div class="page-content">
						<?php if ( current_user_can( 'publish_posts' ) ) : ?>

							<p><?php printf( wp_kses( __( 'Ready to publish your first project? <a href="%1$s">Get started here</a>.', 'ignis' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php?post_type=jetpack-portfolio' ) ) ); ?></p>

						<?php else : ?>

							<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ignis' ); ?></p>
							<?php get_search_form(); ?>

						<?php endif; ?>
					</div>
				</section>
			<?php endif; ?>
			
			<?php do_action( 'ignis_portfolio_after' ); ?>			
			
			</main>
		</div>

<?php
get_footer();