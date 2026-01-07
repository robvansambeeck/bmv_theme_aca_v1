<?php
/**
 * Block Name: Sidebar FAQ
 */

$title       = get_field('sidebar_title');
$intro       = get_field('sidebar_intro');
$pre_text    = get_field('text_above_contact_link');
$url_field   = get_field('contact_link_url'); 

// Veilig de URL ophalen uit de array
$url         = ( is_array($url_field) && !empty($url_field['url']) ) ? $url_field['url'] : '';
$link_text   = "Neem dan contact met ons op!";
?>

<div class="block block-faq">
    <div class="block-inner container-small">
        <div class="faq">
            
            <?php // Sidebar sectie ?>
            <div class="faq__sidebar">
                <?php if ($title) : ?>
                    <div class="faq__sidebar-title">
                        <?php echo wp_kses_post($title); ?>
                    </div>
                <?php endif; ?>

                <?php if ($intro) : ?>
                    <div class="faq__sidebar-intro">
                        <?php echo wp_kses_post($intro); ?>
                    </div>
                <?php endif; ?>

                <?php if ($pre_text) : ?>
                    <div class="faq__sidebar-pretext">
                        <?php echo esc_html($pre_text); ?>
                    </div>
                <?php endif; ?>

                <?php if ($url) : ?>
                    <a href="<?php echo esc_url($url); ?>" class="faq__sidebar-link">
                        <?php echo esc_html($link_text); ?> →
                    </a>
                <?php endif; ?>
            </div>

            <?php // FAQ Content sectie ?>
            <div class="faq__content">
                <?php if (have_rows('faq_questions')) : ?>
                    <div class="accordion-list">
                        <?php while (have_rows('faq_questions')) : the_row();
                            $question = get_sub_field('question');
                            $answer   = get_sub_field('answer');
                            $row_id   = get_row_index();

                            // Alleen tonen als beide velden gevuld zijn
                            if ($question && $answer) : ?>
                                <div class="accordion-list__item">
                                    <button class="accordion-list__question" 
                                            aria-expanded="false" 
                                            aria-controls="faq-answer-<?php echo $row_id; ?>">
                                        <span class="accordion-list__icon">+</span>
                                        <?php echo esc_html($question); ?>
                                    </button>
                                    <div id="faq-answer-<?php echo $row_id; ?>" 
                                         class="accordion-list__answer" 
                                         hidden>
                                        <div class="accordion-list__answer-inner">
                                            <?php echo wp_kses_post($answer); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
<!-- .block-faq -->