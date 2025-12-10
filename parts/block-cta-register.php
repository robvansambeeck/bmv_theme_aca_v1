<?php
$title  = get_field('cta_register_title');
$button = get_field('cta_register_button');
$bg     = get_field('cta_register_bg');
?>

<div class="block block-cta-register">
    <div class="block-bg">
        <?php if ($bg) : ?>
            <img src="<?php echo esc_url($bg['url']); ?>"
                alt="<?php echo esc_attr($bg['alt']); ?>">
        <?php endif; ?>
    </div>

    <div class="block-inner">
        <div class="block-content cta-register">
            <?php if ($title) : ?>
                <div class="cta-register__title">
                    <?php echo $title; // WYSIWYG, dus HTML toegestaan 
                    ?>
                </div>
            <?php endif; ?>

            <?php if ($button) : ?>
                <a class="btn cta-register__button"
                    href="<?php echo esc_url($button['url']); ?>"
                    target="<?php echo esc_attr($button['target'] ?: '_self'); ?>">
                    <?php echo esc_html($button['title']); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- /block-cta-register -->