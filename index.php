<?php
/**
* The main template file
*/

get_header(); ?>

<?php
	$blog_page = get_option('page_for_posts');
    $page_id = get_the_ID();
	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : (get_query_var( 'page' ) ? get_query_var( 'page' ) : 1);

	$title = is_home() ? get_the_title($blog_page) : get_the_title();

	global $wp_query;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <section class="section section-styles section-styles--page">
        <div class="container-xxl">
            <div class="block-title">
                <h1><?php echo $title; ?></h1>
            </div>
            <?php if (get_the_content()) : ?>
                <div class="block-text">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</article>

<?php get_footer(); ?>