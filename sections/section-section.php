<?php
    include '_section-styles.php';
    
    // title
    $title = get_sub_field('title');
    
    // text
    $text = get_sub_field('text');
?>

<section <?php if ($container_id) echo 'id="'.$container_id.'"'; ?> class="section section-styles <?php echo join(' ', $container_class) ?>"  <?php if ($section_styles) echo 'style="' . join(';', $section_styles) . '"' ?>>
    <div class="container">
        <?php if (!empty($title)) :?>
            <<?php echo $title_options['heading']; if ($title_options['style']) echo ' class=' . $title_options['style'] ?>> 
                <?php echo $title ?>
            </<?php echo $title_options['heading'] ?>>    
        <?php endif ?>
        <?php if (!empty($text)) :?>
            <?php echo $text ?>
        <?php endif ?>
    </div>
</section> 