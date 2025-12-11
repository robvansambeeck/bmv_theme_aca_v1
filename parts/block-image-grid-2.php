<?php
$left_image  = get_field('left_image');
$label_text  = get_field('label_text');

$card_1_title = get_field('card_1_title');
$card_1_text  = get_field('card_1_text');

$card_2_title = get_field('card_2_title');
$card_2_text  = get_field('card_2_text');

$card_3_title = get_field('card_3_title');
$card_3_text  = get_field('card_3_text');
?>

<div class="block block-image-grid-2">
    <div class="block-inner">
        <div class="image-grid-2">

            <div class="image-grid-2__col image-grid-2__col--left">
                <?php if ($left_image) : ?>
                    <figure class="image-grid-2__image">
                        <img src="<?php echo esc_url($left_image['url']); ?>"
                             alt="<?php echo esc_attr($left_image['alt']); ?>">

                        <?php if ($label_text) : ?>
                            <div class="image-grid-2__label">
                                <?php echo esc_html($label_text); ?>
                            </div>
                        <?php endif; ?>
                    </figure>
                <?php endif; ?>
            </div>

            <!-- RIGHT CARDS -->
            <div class="image-grid-2__col image-grid-2__col--right">

                <?php if ($card_1_title || $card_1_text) : ?>
                    <div class="image-grid-2__card image-grid-2__card--top">
                        <?php if ($card_1_title) : ?>
                            <h3><?php echo esc_html($card_1_title); ?></h3>
                        <?php endif; ?>
                        <?php echo $card_1_text; ?>
                    </div>
                <?php endif; ?>

                <?php if ($card_2_title || $card_2_text) : ?>
                    <div class="image-grid-2__card image-grid-2__card--middle">
                        <?php if ($card_2_title) : ?>
                            <h3><?php echo esc_html($card_2_title); ?></h3>
                        <?php endif; ?>
                        <?php echo $card_2_text; ?>
                    </div>
                <?php endif; ?>

                <?php if ($card_3_title || $card_3_text) : ?>
                    <div class="image-grid-2__card image-grid-2__card--bottom">
                        <?php if ($card_3_title) : ?>
                            <h3><?php echo esc_html($card_3_title); ?></h3>
                        <?php endif; ?>
                        <?php echo $card_3_text; ?>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>
<!-- /block-image-grid-2 -->