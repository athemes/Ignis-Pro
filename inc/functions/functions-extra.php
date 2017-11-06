<?php
/**
 * @package Ignis
 */


/**
 * Before portfolio widget area
 */
function ignis_before_portfolio_widgets() {

    if ( ! is_active_sidebar( 'portfolio-before' ) ) {
        return;
    }
    ?>

    <div id="widgets-top" class="portfolio-widgets-before">
        <?php dynamic_sidebar( 'portfolio-before' ); ?>
    </div>
    <?php
}
add_action( 'ignis_portfolio_before', 'ignis_before_portfolio_widgets', 9 );

/**
 * After portfolio widget area
 */
function ignis_after_portfolio_widgets() {

    if ( ! is_active_sidebar( 'portfolio-after' ) ) {
        return;
    }
    ?>

    <div id="widgets-bottom" class="portfolio-widgets-after">
        <?php dynamic_sidebar( 'portfolio-after' ); ?>
    </div>
    <?php
}
add_action( 'ignis_portfolio_after', 'ignis_after_portfolio_widgets', 9 );