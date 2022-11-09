<?php
// Remove Global Styles and SVG Filters from WP 5.9.1 - 2022-02-27
function remove_global_styles_and_svg_filters() {
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
}
add_action('init', 'remove_global_styles_and_svg_filters');

// This snippet removes the Global Styles and SVG Filters that are mostly if not only used in Full Site Editing in WordPress 5.9.1+
// Detailed discussion at: https://github.com/WordPress/gutenberg/issues/36834
// WP default filters: https://github.com/WordPress/WordPress/blob/7d139785ea0cc4b1e9aef21a5632351d0d2ae053/wp-includes/default-filters.php

//Remove JQuery migrate
function remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) { // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array(
                'jquery-migrate'
            ));
        }
    }
}
add_action('wp_default_scripts', 'remove_jquery_migrate');

// remove emoji related scripts & Styles
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Theme Setup
 */
function custom_template_setup() {

	load_theme_textdomain( 'custom_template', get_template_directory() . '/languages' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'html5', array( 'search-form' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Main Navigation', 'custom_template' ) );
	// This theme supports a variety of post formats.
	//add_theme_support( 'post-formats', array( 'video', 'image', 'quote' ) );

	// add_theme_support( 'woocommerce' );

	add_theme_support( 'yoast-seo-breadcrumbs' );

	add_theme_support( "title-tag" );

	// add_theme_support( 'custom-header' );

	// add_theme_support( "custom-background");

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	add_editor_style( array( 'assets/css/editor-style.css' ) );

}
add_action( 'after_setup_theme', 'custom_template_setup' );

/**
 * Include CSS & JS
 */
function custom_template_scripts_styles() {
	global $wp_styles;

	$my_theme = wp_get_theme();

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_enqueue_script( 'jquery', $in_footer = false );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/vendor/bootstrap/js/bootstrap.min.js',array(), '', true );
	wp_enqueue_script( 'swiper' , get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.js',array(), '', true);
	wp_enqueue_script( 'aos', get_template_directory_uri() . '/assets/vendor/aos/aos.js',array(), '', true );
	// wp_enqueue_script( 'seletric', get_template_directory_uri().'/assets/vendor/selectric/jquery.selectric.min.js',array(), '', true );
	// wp_enqueue_script( 'infinitescroll', get_template_directory_uri() . '/assets/vendor/infinite-scroll.pkgd.min.js',array(), '', true );
	// wp_enqueue_script( 'vimeoapi', 'https://player.vimeo.com/api/player.js', array(), '', false );
	// wp_enqueue_script( 'googlemaps', 'https://maps.googleapis.com/maps/api/js?key=' . custom_template_get_api_key(), array(), '', false );
	wp_enqueue_script( 'functions', get_template_directory_uri() . '/assets/js/functions.js', array('jquery'), $my_theme->get('Version'), true );

	wp_localize_script( 'functions', 'ajax_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'ajax-nonce' ), ) );

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/vendor/bootstrap/css/bootstrap.min.css' );
	wp_enqueue_style( 'swiper', get_template_directory_uri().'/assets/vendor/swiper/swiper-bundle.min.css' );
	wp_enqueue_style( 'aos', get_template_directory_uri().'/assets/vendor/aos/aos.css' );
	wp_enqueue_style( 'selectric', get_template_directory_uri().'/assets/vendor/selectric/selectric.css' );
	wp_register_style('stylesheet', get_template_directory_uri() . '/style.css', array(), false, 'all');
    wp_enqueue_style('stylesheet');

    // remove block library css
    wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'custom_template_scripts_styles' );

/**
 * Registers our main widget area and the front page widget areas.
 */
// function custom_template_widgets_init() {

// 	register_sidebar( array(
// 		'name' => __( 'Footer Widgets', 'custom_template' ),
// 		'id' => 'footer-widgets',
// 		'description' => __( 'Appears on footer', 'customtheme' ),
// 		'before_widget' => '<div id="%1$s" class="widget %2$s">',
// 		'after_widget' => '</div>',
// 		'before_title' => '<h4 class="widget-title">',
// 		'after_title' => '</h4>',
// 	) );

// }
// add_action( 'widgets_init', 'custom_template_widgets_init' );

// EXCERPT LENGTH
function custom_template_custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'custom_template_custom_excerpt_length', 999 );

function custom_template_new_excerpt_more( $more ) {
	return ' [...]';
}
add_filter('excerpt_more', 'custom_template_new_excerpt_more');

// CUSTOM LOGIN
function custom_template_login_logo() { ?>
    <style type="text/css">
        body.login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.svg);
			background-size: 100%!important;
			width: 106px!important;
			height: 106px!important;
        }

		body.login {
			background: #FFF;
		}

		.login form {
			background: rgba(238,238,238,.7);
		}

		body.login #backtoblog a,
		body.login #nav a,
		body.login a {
			color: #020D2B;
		}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'custom_template_login_logo' );

function custom_template_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'custom_template_login_logo_url' );

function custom_template_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertext', 'custom_template_login_logo_url_title' );

// Custom excerpt
function custom_template_excerpt($limit) {
      $excerpt = explode(' ', get_the_content(), $limit);

      if (count($excerpt) >= $limit) {
          array_pop($excerpt);
          $excerpt = implode(" ", $excerpt) . ' [...]';
      } else {
          $excerpt = implode(" ", $excerpt);
      }

      // $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);

      return $excerpt;
}

// add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );

// Options Page
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Custom Template - Settings',
		'menu_title'	=> 'Custom Template',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

}

// Google Maps API Key
function custom_template_acf_init() {
	$api_key = custom_template_get_api_key();
	acf_update_setting('google_api_key', $api_key);
}

add_action('acf/init', 'custom_template_acf_init');

function custom_template_get_api_key() {
	return '';
	// return 'AIzaSyANobgF-KcTG__tq1nqQhg4RPLe_KBoQyc';
}

// Custom Admin CSS
function custom_template_load_custom_wp_admin_style() {
    wp_register_style( 'custom_wp_admin_css', get_stylesheet_directory_uri() . '/assets/css/admin-style.css', false, '1.0.0' );
    wp_enqueue_style( 'custom_wp_admin_css' );
    
}
add_action( 'admin_enqueue_scripts', 'custom_template_load_custom_wp_admin_style' );

// get_template_part without echo
function load_template_part($template_name, $part_name=null) {
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

// Custom Archive Title
add_filter( 'get_the_archive_title', function ($title) {    
    if ( is_category() ) {    
        $title = single_cat_title( '', false );    
    } elseif ( is_tag() ) {    
        $title = single_tag_title( '', false );    
    } elseif ( is_author() ) {    
        $title = '<span class="vcard">' . get_the_author() . '</span>' ;    
    } elseif ( is_tax() ) { //for custom post types
        $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title( '', false );
    }
    return $title;    
});

// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );

// Disables the block editor from managing widgets. renamed from wp_use_widgets_block_editor
add_filter( 'use_widgets_block_editor', '__return_false' );

// SUB & SUP buttons to WP toolbar
function custom_template_mce_buttons_2($buttons) {
	$buttons[] = 'subscript';
	$buttons[] = 'superscript';

	return $buttons;
}
add_filter('mce_buttons_2', 'custom_template_mce_buttons_2');

function custom_template_basic_editor_buttons( $buttons ) {
	$buttons['Basic'][1][] = 'subscript';
	$buttons['Basic'][1][] = 'superscript';

	return $buttons;
}
add_filter( 'acf/fields/wysiwyg/toolbars', 'custom_template_basic_editor_buttons' );

// Add Bootstrap .img-fluid class to wysiwyg images
function custom_template_add_image_class($class){
    $class .= ' img-fluid';
    return $class;
}
add_filter('get_image_tag_class', 'custom_template_add_image_class');


// Write to WP Log
if (!function_exists('write_log')) {
    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}

// PLUGINS
// require_once get_template_directory() . '/inc/plugins.php';

// PRETTY VAR DUMP
function vd($data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}
function vdd($data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

// CHECK IF USER DEVELOPER
function is_developer(){
    return wp_get_current_user()->user_login == 'developer';
}

// DISPLAY CURRENT TEMPLATE USED
add_action('wp_footer', 'show_template');
function show_template() {
    global $template;
    $template_split = explode('/', $template);
    $template_file = end($template_split);
    if (is_developer()) {
        echo '<div class="template-used position-fixed bg-dark text-light p-1 start-0 bottom-0" style="opacity: 0.5; z-index: 100">Template used is: <br /><strong>' . $template_file . '</strong></div>';
    }
}


// CUSTOM IMAGE SIZES
// add_image_size( '1920x1080', '1920', '1080', false );
// add_image_size( 'medium_large', '768', '0', false );

// return image or svg code for a given image id
function get_image_code($id, $size = '2048x2048', $alt = null) {
    $image = wp_get_attachment_image_src($id, $size);
    $image_url = $image[0];
    $image_type = pathinfo($image_url, PATHINFO_EXTENSION);
    if ($image_type == 'svg') {
        $image_code = file_get_contents( get_attached_file($id) );
    } else {
        $alt = $alt ? $alt : get_the_title($id);
        $image_code = '<img src="' . $image_url . '" alt="' . $alt . '" class="img-fluid" />';
    }
    return $image_code;
}
add_filter('acf/load_field/name=image_size', 'get_all_images_sizes');
add_filter('acf/load_field/name=background_image_size', 'get_all_images_sizes');
function get_all_images_sizes( $field ) {
    $field['allow_null'] = true;
    $wp_additional_image_sizes = wp_get_additional_image_sizes();
    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
    // Create the full array with sizes and crop info
    foreach ( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array(
                'width' => $wp_additional_image_sizes[ $_size ]['width'],
                'height' => $wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    }
    foreach ( $sizes as $key => $image_size ) {
        $field['choices'][$key] = $image_size['width'] . 'x' . $image_size['height'];
    }
    return $field;
}

// SVG ICONS
function svg($icon) {
    $html = '';
    switch($icon) {
        case 'search':
            $html .= '<svg xmlns="http://www.w3.org/2000/svg" width="21.772" height="21.638" viewBox="0 0 21.772 21.638"><g id="Group_2833" data-name="Group 2833" transform="translate(-2 -2)"><path id="Path_19416" data-name="Path 19416" d="M11,2a9,9,0,1,1-9,9A9.01,9.01,0,0,1,11,2Zm0,16a7,7,0,1,0-7-7A7.008,7.008,0,0,0,11,18Z" fill="#fff"/><path id="Path_19417" data-name="Path 19417" d="M22.772,23.638a1,1,0,0,1-.707-.293l-6.122-5.988a1,1,0,1,1,1.414-1.414l6.122,5.988a1,1,0,0,1-.707,1.707Z" fill="#fff"/></g></svg>';
        break;
    }
    return $html;
}

// sass mixing used in php file
function clamp($property, $value, $min = null, $screen = 1920) {
    if (!$min) {
        $min = $value / 2;
    }
    return '--' . $property . ': clamp(' . $min . 'px, ' . ($value * 100 / $screen) .'vw, ' . $value . 'px)';
}

// GRAVITY FORMS
// add_filter( 'gform_submit_button', 'form_submit_button', 10, 2 );
// add_filter('acf/load_field/name=gravity_forms', 'get_all_gravity_forms');
// function form_submit_button( $button, $form ) {
//     return '<button class="btn btn-outline-primary gform_button" id="gform_submit_button_' . $form['id'] . '"><span class="btn-text">' . $form['button']['text'] . '</span></button>';
// }
// function get_all_gravity_forms( $field ) {
//     $field['allow_null'] = true;
//     $forms = GFAPI::get_forms();
//     foreach ($forms as $form) {
//         $field['choices'][$form['id']] = $form['title'];
//     }
//     return $field;
// }

// PAGE NAVI
// add_filter('wp_pagenavi_class_previouspostslink', 'theme_pagination_class');
// add_filter('wp_pagenavi_class_nextpostslink', 'theme_pagination_class');
// function theme_pagination_class($class_name) {
//     switch($class_name) {
//         case 'previouspostslink':
//             $class_name = 'btn btn-previous';
//         break;
//         case 'nextpostslink':
//             $class_name = 'btn btn-outline-primary';
//         break;
//     }
//     return $class_name;
// }

// change navigation classes to look like bootstrap
add_filter( 'nav_menu_css_class', 'custom_theme_nav_li_class', 10, 3 );
add_filter( 'nav_menu_link_attributes', 'custom_theme_nav_link_class', 10, 3 );
function custom_theme_nav_li_class( $classes, $item, $args ) {
    if ( 'primary' === $args->theme_location ) {
        $classes[] = "nav-item";
    }
    return $classes;
}
function custom_theme_nav_link_class( $atts, $item, $args ) {
    if ( 'primary' === $args->theme_location ) {
        $atts['class'] = $atts['aria-current'] == 'page' ? 'nav-link active' : 'nav-link';
    }
    return $atts;
}