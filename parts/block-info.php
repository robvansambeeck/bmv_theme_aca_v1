<?php
$title = get_field('info_title');
$text  = get_field('info_text');
$cta   = get_field('info_cta');   // link array
$logo  = get_field('info_logo');  // image array
$bg_active = get_field('bg_active'); // "bg" or "no bg"
$no_bg_class = ($bg_active === 'no bg' || $bg_active === 'no_bg') ? 'block-info--no-bg' : '';
?>

<div class="block block-info <?php echo esc_attr($no_bg_class); ?>">
    <div class="block-inner">
        <div class="block-content block-info__content">

            <div class="block-info__col block-info__col--text">
                <?php if ($title) : ?>
                    <div class="block-info__title">
                        <?php echo $title; ?>
                    </div>
                <?php endif; ?>

                <?php if ($text) : ?>
                    <div class="block-info__text">
                        <?php echo $text; ?>
                    </div>
                <?php endif; ?>

                <?php if ($cta) : ?>
                    <a class="btn block-info__cta"
                        href="<?php echo esc_url($cta['url']); ?>"
                        target="<?php echo esc_attr($cta['target'] ?: '_self'); ?>">
                        <?php echo esc_html($cta['title']); ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="block-info__col block-info__col--logo">
                <?php if ($logo) : ?>
                    <div class="block-info__logo-wrap">
                        <img src="<?php echo esc_url($logo['url']); ?>"
                            alt="<?php echo esc_attr($logo['alt']); ?>">
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
<!-- /block-info -->