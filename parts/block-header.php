<?php
$title       = get_field('header_title');
$description = get_field('header_description');

$cta_1 = get_field('header_cta_1'); // of 'cta_header_cta1' als je geen underscore hebt
$cta_2 = get_field('header_cta_2'); // idem
?>

<div class="block block-header">
    <div class="block-inner">
        <div class="block-content">

            <div class="row title">
                <?php if ($title) : ?>
                    <?php echo $title; // WYSIWYG, bevat al HTML 
                    ?>
                <?php endif; ?>
            </div>

            <div class="row description">
                <?php if ($description) : ?>
                    <?php echo $description; ?>
                <?php endif; ?>
            </div>

            <div class="row cta">
                <?php if ($cta_1) : ?>
                    <a class="btn"
                        href="<?php echo esc_url($cta_1['url']); ?>"
                        target="<?php echo esc_attr($cta_1['target'] ?: '_self'); ?>">
                        <?php echo esc_html($cta_1['title']); ?>
                    </a>
                <?php endif; ?>

                <?php if ($cta_2) : ?>
                    <a class="btn btn-secondary"
                        href="<?php echo esc_url($cta_2['url']); ?>"
                        target="<?php echo esc_attr($cta_2['target'] ?: '_self'); ?>">
                        <?php echo esc_html($cta_2['title']); ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
<!-- /block-header -->