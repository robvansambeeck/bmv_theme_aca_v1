<?php
$title       = get_field('sidebar_title');
$intro       = get_field('sidebar_intro');
$pre_text    = get_field('text_above_contact_link');
$url_field   = get_field('contact_link_url'); 

$url = ( is_array($url_field) && isset($url_field['url']) ) ? $url_field['url'] : '';

$link_text   = "Neem dan contact met ons op!";
?>

<div class="block block-faq">
    <div class="block-inner">
        <div class="faq">
            <div class="faq__sidebar">
                <?php if ($title) : ?>
                    <?php echo wp_kses_post($title); ?>
                <?php endif; ?>

                <?php if ($intro) : ?>
                    <div><?php echo $intro; ?></div>
                <?php endif; ?>

                <?php if ($pre_text) : ?>
                    <div><?php echo esc_html($pre_text); ?></div>
                <?php endif; ?>

                <?php if ($link_text && $url) : ?>
                    <a href="<?php echo esc_url($url); ?>">
                        <?php echo esc_html($link_text); ?> →
                    </a>
                <?php endif; ?>
            </div>

            <div class="faq__content">
            <?php if (have_rows('faq_questions')) : ?>
                <div class="accordion-list">
                    <?php while (have_rows('faq_questions')) : the_row();
                        $question = get_sub_field('question');
                        $answer   = get_sub_field('answer');
                    ?>
                        <div class="accordion-list__item">
                            <button class="accordion-list__question" aria-expanded="false" aria-controls="faq-answer-<?php echo get_row_index(); ?>">
                                <span class="accordion-list__icon">+</span>
                                <?php echo esc_html($question); ?>
                            </button>
                            <div id="faq-answer-<?php echo get_row_index(); ?>" class="accordion-list__answer" hidden>
                                <?php echo $answer; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
            </div>

        </div>
    </div>
</div>
<!-- /block-faq -->