<?php
/**
 * Block Name: Program Items
 */

$items = get_field('program_items');
?>

<div class="block block-program">
    <div class="block-inner">
        <div class="block-content program-grid">

            <?php if (!empty($items) && is_array($items)) : ?>
                <?php foreach ($items as $item) :
                    // Variabelen binnen de loop
                    $icon    = isset($item['icon']) ? $item['icon'] : null;
                    $title   = isset($item['title']) ? $item['title'] : '';
                    $text    = isset($item['text']) ? $item['text'] : '';
                    $variant = !empty($item['background_color']) ? $item['background_color'] : 'peach';

                    // Alleen een kaart tonen als er daadwerkelijk inhoud is
                    if ($icon || $title || $text) : ?>
                        
                        <div class="program-card program-card--<?php echo esc_attr($variant); ?>">
                            
                            <?php if ($icon) : ?>
                                <div class="program-card__icon">
                                    <img src="<?php echo esc_url($icon['url']); ?>"
                                         alt="<?php echo esc_attr($icon['alt'] ?: ''); ?>"
                                         loading="lazy">
                                </div>
                            <?php endif; ?>

                            <?php if ($title) : ?>
                                <h3 class="program-card__title">
                                    <?php echo esc_html($title); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ($text) : ?>
                                <div class="program-card__text">
                                    <?php // nl2br behoudt de enters die de klant in het tekstveld zet ?>
                                    <?php echo wp_kses_post(nl2br($text)); ?>
                                </div>
                            <?php endif; ?>
                            
                        </div>

                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>
