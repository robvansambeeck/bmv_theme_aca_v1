<?php
$image       = get_field('bullet_list_image');
$title       = get_field('bullet_list_title');        // WYSIWYG
$description = get_field('bullet_list_description');  // WYSIWYG
$cta         = get_field('bullet_list_cta');
?>

<div class="block block-bullet-list">
    <div class="block-inner">
        <div class="block-content bullet-list">

            <div class="bullet-list__col bullet-list--image">
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
                        <?php echo $title; // WYSIWYG, laat HTML toe 
                        ?>
                    </div>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <div class="bullet-list__description">
                        <?php echo $description; ?>
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

                <?php if ($cta) : ?>
                    <a class="btn bullet-list__cta"
                        href="<?php echo esc_url($cta['url']); ?>"
                        target="<?php echo esc_attr($cta['target'] ?: '_self'); ?>">
                        <?php echo esc_html($cta['title']); ?>
                    </a>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>
<!-- /block-bullet-list -->