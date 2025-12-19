<?php
// Ophalen van de afbeeldingsvelden
$left_image  = get_field('left_image');
$right_image = get_field('right_image'); // Nieuw: deze wordt nu wel opgehaald!

// Ophalen van de inhoud voor de drie kaarten
// Kaart 1 (Top)
$title_top = get_field('title_top');
$text_top  = get_field('text_top');

// Kaart 2 (Middle)
$title_middle = get_field('title_middle');
$text_middle  = get_field('text_middle');

// Kaart 3 (Bottom)
$title_buttom = get_field('title_buttom');
$text_buttom  = get_field('text_buttom');
?>

<div class="block block-image-grid-3">
    <div class="block-inner">
        <div class="image-grid-3">

            <div class="image-grid-3__col image-grid-3__col--left-top">
                <?php if ($left_image) : ?>
                    <figure class="image-grid-3__image-large">
                        <img src="<?php echo esc_url($left_image['url']); ?>"
                             alt="<?php echo esc_attr($left_image['alt']); ?>">
                    </figure>
                <?php endif; ?>
            </div>

            <div class="image-grid-3__col image-grid-3__col--right-top">
                <?php if ($title_top || $text_top) : ?>
                    <div class="image-grid-3__card image-grid-3__card--top">
                        <?php if ($title_top) : ?>
                            <h3><?php echo esc_html($title_top); ?></h3>
                        <?php endif; ?>
                        <?php if ($text_top) : ?>
                            <div><?php echo wp_kses_post($text_top); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="image-grid-3__col image-grid-3__col--left-bottom">
                <div class="image-grid-3__cards-bottom">
                    <?php if ($title_middle || $text_middle) : ?>
                        <div class="image-grid-3__card image-grid-3__card--middle">
                            <?php if ($title_middle) : ?>
                                <h3><?php echo esc_html($title_middle); ?></h3>
                            <?php endif; ?>
                            <?php if ($text_middle) : ?>
                                <div><?php echo wp_kses_post($text_middle); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($title_buttom || $text_buttom) : ?>
                        <div class="image-grid-3__card image-grid-3__card--bottom">
                            <?php if ($title_buttom) : ?>
                                <h3><?php echo esc_html($title_buttom); ?></h3>
                            <?php endif; ?>
                            <?php if ($text_buttom) : ?>
                                <div><?php echo wp_kses_post($text_buttom); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="image-grid-3__col image-grid-3__col--right-bottom">
                <?php if ($right_image) : ?>
                    <figure class="image-grid-3__image-small">
                        <img src="<?php echo esc_url($right_image['url']); ?>"
                             alt="<?php echo esc_attr($right_image['alt']); ?>">
                    </figure>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>