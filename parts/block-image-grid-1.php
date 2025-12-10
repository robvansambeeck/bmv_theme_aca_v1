<?php
$left_image   = get_field('left_image');
$right_image  = get_field('right_image');
$text_top     = get_field('text_top');
$text_bottom  = get_field('text_bottom');
$show_quote   = get_field('show_quote_icon');
?>

<div class="block block-image-grid-1">
    <div class="block-inner">
        <div class="block-content image-grid-1">

            <div class="image-grid-1__col image-grid-1__col--left">
                <?php if ($left_image) : ?>
                    <figure class="image-grid-1__image">
                        <img src="<?php echo esc_url($left_image['url']); ?>"
                            alt="<?php echo esc_attr($left_image['alt']); ?>">
                    </figure>
                <?php endif; ?>
            </div>

            <div class="image-grid-1__col image-grid-1__col--middle">

                <?php if ($text_top) : ?>
                    <div class="image-grid-1__card image-grid-1__card--top">
                        <?php echo $text_top; ?>
                    </div>
                <?php endif; ?>

                <?php if ($text_bottom) : ?>
                    <div class="image-grid-1__card image-grid-1__card--bottom">
                        <?php if ($show_quote) : ?>
                            <div class="image-grid-1__quote-icon">
                                <i class="fa-sharp-duotone fa-light fa-quote-left"></i>
                            </div>
                        <?php endif; ?>

                        <?php echo $text_bottom; ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="image-grid-1__col image-grid-1__col--right">
                <?php if ($right_image) : ?>
                    <figure class="image-grid-1__image">
                        <img src="<?php echo esc_url($right_image['url']); ?>"
                            alt="<?php echo esc_attr($right_image['alt']); ?>">
                    </figure>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
<!-- /block-image-grid-1 -->