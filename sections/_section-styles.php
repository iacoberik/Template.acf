<?php
    $section_styles = [];

    // container options
    $container_class = [get_row_layout()];
    $container_options = get_sub_field('container_options');
    $container_id = str_replace(' ', '-', $container_options['section_id']);
    if ($container_options['section_inactive']) $container_class[] = 'd-none';

    // title options
    $title_options = get_sub_field('title_options');
    if ($title_options) {
        if ($title_options['color']) $section_styles[] = '--heading-color: ' . $title_options['color'];
        if ($title_options['text_align']) $section_styles[] = '--heading-align: ' . $title_options['align'];
        if ($title_options['style']) $section_styles[] = '--heading-style: ' . $title_options['style'];
    } 

    // text options
    $text_options = get_sub_field('text_options');
    if ($text_options) {
        if ($text_options['color']) $section_styles[] = '--text-color: ' . $text_options['color'];
        if ($text_options['text_align']) $section_styles[] = '--text-align: ' . $text_options['align'];
    }

    // background
    $background_options = get_sub_field('background_options');
    if ($background_options) {
        if ($background_options['background_color']) $section_styles[] = '--bg-color: ' . $background_options['background_color'];
        if ($background_options['background_size']) $section_styles[] = '--bg-size: ' . $background_options['background_size'];
        if ($background_options['background_position']) $section_styles[] = '--bg-position: ' . $background_options['background_position']['horizontal'] . ' ' . $background_options['background_position']['vertical'];
        if ($background_options['background_image']) {
            $background_image_size = $background_options['background_image_size'] ? $background_options['background_image_size'] : '2048x2048';
            $section_styles[] = '--bg-image: url(' . $background_options['background_image']['sizes'][$background_image_size] . ')';
        }
        
    }

    if ($background_options['background_overlay'])
    {
        if ($background_options['background_overlay']['overlay_color']) $section_styles[] = '--bg-overlay-color: ' . $background_options['background_overlay']['overlay_color'];
        if ($background_options['background_overlay']['overlay_opacity']) $section_styles[] = '--bg-overlay-opacity: ' . $background_options['background_overlay']['overlay_opacity'];
    }

    // Padding

    $padding_options = get_sub_field('padding_options');
    if ($padding_options)
    {
        $section_styles[] = '--padding-top: ' . $padding_options['padding_top'] .'px';
        $section_styles[] = '--padding-bottom: ' . $padding_options['padding_bottom'] .'px';
        $section_styles[] = '--padding-left: ' . $padding_options['padding_left'] .'px';
        $section_styles[] = '--padding-right: ' . $padding_options['padding_right'] .'px';
    }

    // spacing
    $spacing_options = get_sub_field('spacing_options');
    foreach ($spacing_options as $key=>$option) {
        foreach ($option as $key2=>$value) {
            if ($value == '0') {
                $section_styles[] = '--' . $key . '-' . $key2 . ': 0';
            } else {
                // if ($key == 'padding' && (int) $value / 2 < 50) {
                    // $section_styles[] = clamp($key . '-' . $key2, (int) $value, 50);
                // } else {
                    $section_styles[] = clamp($key . '-' . $key2, (int) $value);
                // }
            }
        }
    }
?>