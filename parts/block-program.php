<?php
$items = get_field('program_items');
?>

<div class="block block-program">
    <div class="block-inner container-small">
        <div class="block-content program-grid">

            <?php if ($items) : ?>
                <?php foreach ($items as $item) :

                    $icon    = $item['icon'];
                    $title   = $item['title'];
                    $text    = $item['text'];
                    $variant = $item['background_color'] ?: 'peach'; // fallback
                ?>

                    <div class="program-card program-card--<?php echo esc_attr($variant); ?>">
                        <?php if ($icon) : ?>
                            <div class="program-card__icon">
                                <img src="<?php echo esc_url($icon['url']); ?>"
                                    alt="<?php echo esc_attr($icon['alt']); ?>">
                            </div>
                        <?php endif; ?>

                        <?php if ($title) : ?>
                            <h3 class="program-card__title">
                                <?php echo esc_html($title); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ($text) : ?>
                            <div class="program-card__text">
                                <?php echo wp_kses_post(nl2br($text)); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- /block-program -->