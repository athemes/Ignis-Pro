<?php
/**
 * The template used for displaying projects on index view
 *
 * @package Ignis
 */

$read_more 		= get_theme_mod( 'portfolio_read_more', __( 'See this project', 'ignis' ) );
$portfolio_type = get_theme_mod( 'portfolio_type', 'portfolio-type-1' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-wow-duration="2s">
	<?php if ( '' != get_the_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>">
			<div class="portfolio-thumbnail">
				<?php the_post_thumbnail( '720x0' ); ?>
				</div>
			</a>
	<?php endif; ?>

	<div class="portfolio-content">
		<header class="entry-header">
			<?php echo get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<span class="portfolio-entry-meta">', esc_html_x(', ', 'Used between list items, there is a space after the comma.', 'ignis' ), '</span>' ); ?>
			<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<?php if ( $portfolio_type == 'portfolio-type-2' ) : ?>
			<div class="portfolio-read-more"><a href="<?php the_permalink(); ?>"><?php echo esc_html( $read_more ); ?></a></div>
			<?php endif; ?>
		</header>
	</div>
</article>
