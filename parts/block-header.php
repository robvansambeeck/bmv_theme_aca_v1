<?php
/**
 * Block Name: Header Section
 */

$title       = get_field('header_title');
$description = get_field('header_description');

$cta_1 = get_field('header_cta_1');
$cta_2 = get_field('header_cta_2');

// Check of de knoppen valide zijn (bestaan ze en hebben ze een URL?)
$has_cta1 = ($cta_1 && !empty($cta_1['url']));
$has_cta2 = ($cta_2 && !empty($cta_2['url']));
?>

<div class="block block-header">
    <div class="block-inner container-small">
        <div class="block-content">

            <?php if ($title) : ?>
                <div class="row title">
                    <?php echo wp_kses_post($title); ?>
                </div>
            <?php endif; ?>

            <?php if ($description) : ?>
                <div class="row description">
                    <?php echo wp_kses_post($description); ?>
                </div>
            <?php endif; ?>

            <?php if ($has_cta1 || $has_cta2) : ?>
                <div class="row cta">
                    <?php if ($has_cta1) : ?>
                        <a class="btn"
                           href="<?php echo esc_url($cta_1['url']); ?>"
                           target="<?php echo esc_attr($cta_1['target'] ?: '_self'); ?>">
                            <?php echo esc_html($cta_1['title'] ?: 'Lees meer'); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($has_cta2) : ?>
                        <a class="btn btn-secondary"
                           href="<?php echo esc_url($cta_2['url']); ?>"
                           target="<?php echo esc_attr($cta_2['target'] ?: '_self'); ?>">
                            <?php echo esc_html($cta_2['title'] ?: 'Lees meer'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- .block-header -->