<?php
$image       = get_field('bullet_list_image');
$title       = get_field('bullet_list_titel');        // WYSIWYG
$description = get_field('bullet_list_discription');  // WYSIWYG
$cta         = get_field('bullet_list_cta');
?>

<div class="block block-bullet-list">
    <div class="block-inner container-small">
        <div class="block-content bullet-list__container">

            <div class="bullet-list__col bullet-list__col--image">
                <?php if ($image) : ?>
                    <figure class="bullet-list__image">
                        <img src="<?php echo esc_url($image['url']); ?>"
                            alt="<?php echo esc_attr($image['alt']); ?>">
                    </figure>
                <?php endif; ?>
            </div>

            <div class="bullet-list__col bullet-list__col--content">

                <?php if ($title) : ?>
                    <div class="bullet-list__title">
                        <?php echo wp_kses_post($title); // WYSIWYG, laat HTML toe 
                        ?>
                    </div>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <div class="bullet-list__description">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                <?php endif; ?>

                <?php if (have_rows('bullet_list_items')) : ?>
                    <ul class="bullet-list__items">
                        <?php while (have_rows('bullet_list_items')) : the_row(); ?>
                            <?php $item_text = get_sub_field('item_text'); ?>
                            <?php if ($item_text) : ?>
                                <li class="bullet-list__item">
                                    <span class="bullet-list__item-icon">
                                        <i class="fa-sharp-duotone fa-solid fa-check-circle"></i>
                                    </span>
                                    <span class="bullet-list__item-text">
                                        <?php echo esc_html($item_text); ?>
                                    </span>
                                </li>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>

                <?php
                // ACF Link field returns array with url, title, target
                if ($cta && is_array($cta)) :
                    $cta_url = isset($cta['url']) ? $cta['url'] : '';
                    $cta_title = isset($cta['title']) ? $cta['title'] : '';
                    $cta_target = isset($cta['target']) ? $cta['target'] : '_self';

                    if (!empty($cta_url) && !empty($cta_title)) : ?>
                        <div style="margin-top: 1rem; display: block !important;">
                            <a class="bullet-list__cta"
                                href="<?php echo esc_url($cta_url); ?>"
                                target="<?php echo esc_attr($cta_target); ?>">
                                <?php echo esc_html($cta_title); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>
<!-- /block-bullet-list -->