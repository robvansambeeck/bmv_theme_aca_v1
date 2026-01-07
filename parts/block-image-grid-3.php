<?php
/**
 * Block Name: Image Grid 3
 */

$left_image  = get_field('left_image');
$right_image = get_field('right_image');

// Kaart 1 (Top)
$title_top = get_field('title_top');
$text_top  = get_field('text_top');

// Kaart 2 (Middle)
$title_middle = get_field('title_middle');
$text_middle  = get_field('text_middle');

// Kaart 3 (Bottom)
$title_bottom = get_field('title_buttom') ?: get_field('title_bottom');
$text_bottom  = get_field('text_buttom') ?: get_field('text_bottom');
?>

<div class="block block-image-grid-3">
    <div class="block-inner container">
        <div class="image-grid-3">

            <?php // Linksboven: Grote afbeelding ?>
            <?php if ($left_image) : ?>
                <div class="image-grid-3__col image-grid-3__col--left-top">
                    <figure class="image-grid-3__image-large">
                        <img src="<?php echo esc_url($left_image['url']); ?>"
                             alt="<?php echo esc_attr($left_image['alt'] ?: ''); ?>"
                             loading="lazy">
                    </figure>
                </div>
            <?php endif; ?>

            <?php // Rechtsboven: Kaart 1 ?>
            <?php if ($title_top || $text_top) : ?>
                <div class="image-grid-3__col image-grid-3__col--right-top">
                    <div class="image-grid-3__card image-grid-3__card--top">
                        <?php if ($title_top) : ?>
                            <h3><?php echo esc_html($title_top); ?></h3>
                        <?php endif; ?>
                        <?php if ($text_top) : ?>
                            <div class="image-grid-3__card-text"><?php echo wp_kses_post($text_top); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php // Linksonder: Kaart 2 & 3 ?>
            <?php if ($title_middle || $text_middle || $title_bottom || $text_bottom) : ?>
                <div class="image-grid-3__col image-grid-3__col--left-bottom">
                    <div class="image-grid-3__cards-stack">
                        
                        <?php if ($title_middle || $text_middle) : ?>
                            <div class="image-grid-3__card image-grid-3__card--middle">
                                <?php if ($title_middle) : ?>
                                    <h3><?php echo esc_html($title_middle); ?></h3>
                                <?php endif; ?>
                                <?php if ($text_middle) : ?>
                                    <div class="image-grid-3__card-text"><?php echo wp_kses_post($text_middle); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php // Kaart 3 (Bottom) - altijd renderen voor test ?>
                        <div class="image-grid-3__card image-grid-3__card--bottom">
                            <?php if ($title_bottom) : ?>
                                <h3><?php echo esc_html($title_bottom); ?></h3>
                            <?php else : ?>
                                <h3>Altijd begeleiding, altijd groei</h3>
                            <?php endif; ?>
                            <?php if ($text_bottom) : ?>
                                <div class="image-grid-3__card-text"><?php echo wp_kses_post($text_bottom); ?></div>
                            <?php else : ?>
                                <div class="image-grid-3__card-text"><p>Je krijgt persoonlijke begeleiding van ervaren professionals die je helpen groeien in je vak. Of je nu net begint of al ervaring hebt, we zorgen ervoor dat je de juiste ondersteuning krijgt om succesvol te zijn in je carrière.</p></div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endif; ?>

            <?php // Rechtsonder: Kleine afbeelding ?>
            <?php if ($right_image) : ?>
                <div class="image-grid-3__col image-grid-3__col--right-bottom">
                    <figure class="image-grid-3__image-small">
                        <img src="<?php echo esc_url($right_image['url']); ?>"
                             alt="<?php echo esc_attr($right_image['alt'] ?: ''); ?>"
                             loading="lazy">
                    </figure>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- .block-image-grid-3 -->