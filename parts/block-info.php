<?php
/**
 * Block Name: Info Block
 */

$title       = get_field('info_title');
$text        = get_field('info_text');
$cta         = get_field('info_cta');   // link array
$logo        = get_field('info_logo');  // image array
$bg_active   = get_field('bg_active');  // "bg" or "no bg"

// Schonere check voor de background class
$no_bg_class = (in_array($bg_active, ['no bg', 'no_bg'])) ? 'block-info--no-bg' : '';

// Valideer CTA
$has_cta = ($cta && !empty($cta['url']) && !empty($cta['title']));
?>

<div class="block block-info <?php echo esc_attr($no_bg_class); ?>">
    <div class="block-inner">
        <div class="block-content block-info__content">

            <div class="block-info__col block-info__col--text">
                <?php if ($title) : ?>
                    <div class="block-info__title">
                        <?php echo wp_kses_post($title); ?>
                    </div>
                <?php endif; ?>

                <?php if ($text) : ?>
                    <div class="block-info__text">
                        <?php echo wp_kses_post($text); ?>
                    </div>
                <?php endif; ?>

                <?php if ($has_cta) : ?>
                    <div class="block-info__cta-wrapper">
                        <a class="btn block-info__cta"
                           href="<?php echo esc_url($cta['url']); ?>"
                           target="<?php echo esc_attr($cta['target'] ?: '_self'); ?>">
                            <?php echo esc_html($cta['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($logo) : ?>
                <div class="block-info__col block-info__col--logo">
                    <div class="block-info__logo-wrap">
                        <img src="<?php echo esc_url($logo['url']); ?>"
                             alt="<?php echo esc_attr($logo['alt'] ?: ''); ?>"
                             loading="lazy">
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- .block-info -->