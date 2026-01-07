<?php
/**
 * Block Name: CTA Register
 */

$title  = get_field('cta_register_title');
$button = get_field('cta_register_button');
$bg     = get_field('cta_register_bg');

// Check of de knop echt bruikbaar is
$has_button = ($button && !empty($button['url']) && !empty($button['title']));
?>

<div class="block block-cta-register">
    <div class="block-bg">
        <?php if ($bg) : ?>
            <img src="<?php echo esc_url($bg['url']); ?>"
                 alt="<?php echo esc_attr($bg['alt'] ?: ''); ?>"
                 loading="lazy">
        <?php endif; ?>
    </div>

    <div class="block-inner container">
        <div class="block-content cta-register">
            <?php if ($title) : ?>
                <div class="cta-register__title">
                    <?php echo wp_kses_post($title); ?>
                </div>
            <?php endif; ?>

            <?php if ($has_button) : ?>
                <a class="btn cta-register__button"
                    href="<?php echo esc_url($button['url']); ?>"
                    target="<?php echo esc_attr($button['target'] ?: '_self'); ?>">
                    <?php echo esc_html($button['title']); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- .block-cta-register -->