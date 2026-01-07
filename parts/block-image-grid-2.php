<?php
/**
 * Block Name: Image Grid 2
 */

$left_image   = get_field('left_image');
$label_text   = get_field('label_text');

// Kaart data ophalen
$card_1_title = get_field('card_1_title');
$card_1_text  = get_field('card_1_text');

$card_2_title = get_field('card_2_title');
$card_2_text  = get_field('card_2_text');

$card_3_title = get_field('card_3_title');
$card_3_text  = get_field('card_3_text');

// Check of er überhaupt content is voor de rechterkolom
$has_right_content = ($card_1_title || $card_1_text || $card_2_title || $card_2_text || $card_3_title || $card_3_text);
?>

<div class="block block-image-grid-2">
    <div class="block-inner container">
        <div class="image-grid-2">

            <?php // LINKER KOLOM: Grote afbeelding met optioneel label ?>
            <?php if ($left_image) : ?>
                <div class="image-grid-2__col image-grid-2__col--left">
                    <figure class="image-grid-2__image">
                        <img src="<?php echo esc_url($left_image['url']); ?>"
                             alt="<?php echo esc_attr($left_image['alt'] ?: ''); ?>"
                             loading="lazy">

                        <?php if ($label_text) : ?>
                            <div class="image-grid-2__label">
                                <?php echo esc_html($label_text); ?>
                            </div>
                        <?php endif; ?>
                    </figure>
                </div>
            <?php endif; ?>

            <?php // RECHTER KOLOM: Gestapelde kaarten ?>
            <?php if ($has_right_content) : ?>
                <div class="image-grid-2__col image-grid-2__col--right">

                    <?php // Kaart 1 ?>
                    <?php if ($card_1_title || $card_1_text) : ?>
                        <div class="image-grid-2__card image-grid-2__card--1">
                            <?php if ($card_1_title) : ?>
                                <h3><?php echo esc_html($card_1_title); ?></h3>
                            <?php endif; ?>
                            <?php if ($card_1_text) : ?>
                                <div class="image-grid-2__card-text">
                                    <?php echo wp_kses_post($card_1_text); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php // Kaart 2 ?>
                    <?php if ($card_2_title || $card_2_text) : ?>
                        <div class="image-grid-2__card image-grid-2__card--2">
                            <?php if ($card_2_title) : ?>
                                <h3><?php echo esc_html($card_2_title); ?></h3>
                            <?php endif; ?>
                            <?php if ($card_2_text) : ?>
                                <div class="image-grid-2__card-text">
                                    <?php echo wp_kses_post($card_2_text); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php // Kaart 3 ?>
                    <?php if ($card_3_title || $card_3_text) : ?>
                        <div class="image-grid-2__card image-grid-2__card--3">
                            <?php if ($card_3_title) : ?>
                                <h3><?php echo esc_html($card_3_title); ?></h3>
                            <?php endif; ?>
                            <?php if ($card_3_text) : ?>
                                <div class="image-grid-2__card-text">
                                    <?php echo wp_kses_post($card_3_text); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- .block-image-grid-2 -->