<?php
/**
 * Block Name: Image Grid 1
 */

$left_image   = get_field('left_image');
$right_image  = get_field('right_image');
$text_top     = get_field('text_top');
$text_bottom  = get_field('text_bottom');
$show_quote   = get_field('show_quote_icon');
?>

<div class="block block-image-grid-1">
    <div class="block-inner container">
        <div class="block-content image-grid-1">

            <?php // Linker kolom: Afbeelding ?>
            <?php if ($left_image) : ?>
                <div class="image-grid-1__col image-grid-1__col--left">
                    <figure class="image-grid-1__image">
                        <img src="<?php echo esc_url($left_image['url']); ?>"
                             alt="<?php echo esc_attr($left_image['alt'] ?: ''); ?>"
                             loading="lazy">
                    </figure>
                </div>
            <?php endif; ?>

            <?php // Middelste kolom: Tekst kaarten ?>
            <?php if ($text_top || $text_bottom) : ?>
                <div class="image-grid-1__col image-grid-1__col--middle">

                    <?php if ($text_top) : ?>
                        <div class="image-grid-1__card image-grid-1__card--top">
                            <?php echo wp_kses_post($text_top); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($text_bottom) : ?>
                        <div class="image-grid-1__card image-grid-1__card--bottom">
                            <?php if ($show_quote) : ?>
                                <div class="image-grid-1__quote-icon">
                                    <i class="fa-sharp-duotone fa-light fa-quote-left"></i>
                                </div>
                            <?php endif; ?>
                            <?php echo wp_kses_post($text_bottom); ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

            <?php // Rechter kolom: Afbeelding ?>
            <?php if ($right_image) : ?>
                <div class="image-grid-1__col image-grid-1__col--right">
                    <figure class="image-grid-1__image">
                        <img src="<?php echo esc_url($right_image['url']); ?>"
                             alt="<?php echo esc_attr($right_image['alt'] ?: ''); ?>"
                             loading="lazy">
                    </figure>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- .block-image-grid-1 -->