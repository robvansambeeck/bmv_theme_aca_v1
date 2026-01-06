<?php
/**
 * Block Name: Steps
 */

$steps = get_field('steps');
?>

<div class="block block-steps">
    <div class="block-inner">
        <div class="steps">

            <?php if (!empty($steps) && is_array($steps)) : ?>
                <div class="steps__grid">

                    <?php foreach ($steps as $index => $step) :
                        $icon   = isset($step['icon']) ? $step['icon'] : null;
                        $text   = isset($step['text']) ? $step['text'] : null;
                        
                        // Handmatig nummer of automatische index
                        $manual_number = isset($step['number']) ? $step['number'] : '';
                        $display_number = !empty($manual_number) ? $manual_number : ($index + 1);
                        
                        // Alleen tonen als er tekst of een icoon is
                        if ($text || $icon) : ?>
                            
                            <div class="steps__item">

                                <?php if ($icon) : ?>
                                    <div class="steps__icon">
                                        <img src="<?php echo esc_url($icon['url']); ?>"
                                             alt="<?php echo esc_attr($icon['alt'] ?: ''); ?>"
                                             loading="lazy">
                                    </div>
                                <?php endif; ?>

                                <div class="steps__number">
                                    <span class="steps__number-value"><?php echo esc_html($display_number); ?></span>
                                    <span class="steps__number-dot">.</span>
                                </div>

                                <?php if ($text) : ?>
                                    <div class="steps__text">
                                        <?php echo wp_kses_post($text); ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- .block-steps -->