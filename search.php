<?php
/**
* The search results template file
*/
?>

<?php get_header(); ?>

<section class="section section-styles section-styles--page search_results">
    <div class="container-xxl">
        <div class="block-title">
            <h1 class="mb-3">Search Results</h1>
        </div>
        <div class="block-results list-group">
            <?php
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                $args = array(
                    'posts_per_page' => get_option('posts_per_page'),
                    'paged' => $paged,
                    's' => get_query_var('s')
                );
                $results = new WP_query($args);
            ?>
            <?php if ($results->have_posts()): ?>
                <?php while ( $results->have_posts() ) : $results->the_post(); ?>
                    <div class="block-results-item list-group-item p-1">
                        <div class="block-results-title"><a href="<?php the_permalink(); ?>" class="text-decoration-none"><?php the_title(); ?></a></div>
                        <div class="block-results-text"><?php the_excerpt() ?></div>
                    </div>

                <?php endwhile; // end of the loop. ?>

            <?php else: ?>
                <p><?php _e('There are no search results.', 'customtemplate'); ?></p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        

        <?php
            $total_pages = $results->max_num_pages;
            if ($total_pages > 1 && $total_pages > $paged) wp_pagenavi( array('query' => $results) );
        ?>
    </div>
</section>

<?php get_footer(); ?>