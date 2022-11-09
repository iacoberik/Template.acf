<?php
/**
 * Template Name: Site Builder
 *
**/

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php
				$page_id = get_the_ID();
				if (!is_front_page() && is_home()) {
					$page_id = get_option( 'page_for_posts' );
				}
			    if( have_rows('sections', $page_id) ) {
			        while ( have_rows('sections', $page_id) ) { the_row();
						$layout = get_row_layout();
						get_template_part('sections/section', $layout);
					} // endwhile
				} // endif
			?>
		</article><!-- #post -->
	<?php endwhile; // end of the loop. ?>
				
<?php get_footer(); ?>