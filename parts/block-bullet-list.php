<?php
/**
 * Block Name: Bullet List
 */

$image       = get_field('bullet_list_image');
$title       = get_field('bullet_list_titel'); 
$description = get_field('bullet_list_discription');
$cta         = get_field('bullet_list_cta');

// Valideer de CTA link
$has_cta = ($cta && !empty($cta['url']) && !empty($cta['title']));
?>

<div class="block block-bullet-list">
    <div class="block-inner">
        <div class="block-content bullet-list__container">

            <?php if ($image) : ?>
                <div class="bullet-list__col bullet-list__col--image">
                    <figure class="bullet-list__image">
                        <img src="<?php echo esc_url($image['url']); ?>"
                             alt="<?php echo esc_attr($image['alt'] ?: ''); ?>"
                             loading="lazy">
                    </figure>
                </div>
            <?php endif; ?>

            <div class="bullet-list__col bullet-list__col--content">

                <?php if ($title) : ?>
                    <div class="bullet-list__title">
                        <?php echo wp_kses_post($title); ?>
                    </div>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <div class="bullet-list__description">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                <?php endif; ?>

                <?php if (have_rows('bullet_list_items')) : ?>
                    <ul class="bullet-list__items">
                        <?php while (have_rows('bullet_list_items')) : the_row(); 
                            $item_text = get_sub_field('item_text');
                            if ($item_text) : ?>
                                <li class="bullet-list__item">
                                    <span class="bullet-list__item-icon">
                                        <i class="fa-sharp-duotone fa-solid fa-check-circle"></i>
                                    </span>
                                    <span class="bullet-list__item-text">
                                        <?php echo esc_html($item_text); ?>
                                    </span>
                                </li>
                            <?php endif; 
                        endwhile; ?>
                    </ul>
                <?php endif; ?>

                <?php if ($has_cta) : ?>
                    <div class="bullet-list__cta-wrapper">
                        <a class="btn bullet-list__cta"
                           href="<?php echo esc_url($cta['url']); ?>"
                           target="<?php echo esc_attr($cta['target'] ?: '_self'); ?>">
                            <?php echo esc_html($cta['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>
<!-- .block-bullet-list -->