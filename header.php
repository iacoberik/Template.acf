<!DOCTYPE html>
<html <?php language_attributes(); ?> class="h-100">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php wp_head(); ?>
    <?php if ($google_fonts = get_field('setup_group', 'options')['google_fonts']) : ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="<?php echo $google_fonts; ?>" rel="stylesheet">
    <?php endif; ?>
</head>

<body <?php body_class('d-flex flex-column h-100'); ?>>
    <header class="header py-1 border-bottom">
        <nav class="navbar navbar-expand-md">
            <div class="container-xxl">
                <!-- <?php vd(get_field('header_group', 'options')); ?>  -->
                <?php if ($logo = get_field('header_group', 'options')['logo']) : ?>
                    <a class="navbar-brand flex-shrink-0 p-0" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php echo get_image_code($logo['ID'], 'full'); ?>
                    </a>
                <?php endif; ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <?php wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'nav nav-pills me-auto'
                    ) ); ?>
                    <?php get_search_form() ?>
                </div>
            </div>
        </nav>
    </header>
    <main id="content" class="flex-shrink-0">

