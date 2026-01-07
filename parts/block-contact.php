<?php
/**
 * Block Name: Contact
 */

// Haal alle ACF-velden op
$title           = get_field('contact_title');
$intro           = get_field('contact_intro');
$text_above_faq  = get_field('text_above_faq_link');
$faq_link_array  = get_field('faq_link_url');

$address_title   = get_field('address_title');
$address_content = get_field('address');
$address_email   = get_field('email_address');
$address_kvk     = get_field('address_kvk');

$form_title      = get_field('form_title');

// Formulier ID ophalen (Gravity Forms)
$form_object     = get_field('form'); 
$form_id         = is_array($form_object) ? $form_object['id'] : false; 

// Verwerk de Link velden veilig
$faq_url    = $faq_link_array['url'] ?? '';
$faq_title  = $faq_link_array['title'] ?? '';
$faq_target = $faq_link_array['target'] ?: '_self';
?>

<div class="block block-contact">
    <div class="block-inner container">
        <div class="contact-grid">

            <div class="contact-grid__col contact-grid__col--left">
                
                <?php if ($title) : ?>
                    <h2 class="contact-grid__title"><?php echo wp_kses_post($title); ?></h2>
                <?php endif; ?>
                
                <?php if ($intro) : ?>
                    <div class="contact-grid__intro">
                        <?php echo wp_kses_post($intro); ?>
                    </div>
                <?php endif; ?>

                <?php if ($faq_url && $faq_title) : ?>
                    <p class="contact-grid__faq-link-wrapper">
                        <?php echo esc_html($text_above_faq); ?> 
                        <a href="<?php echo esc_url($faq_url); ?>" 
                           class="contact-grid__faq-link" 
                           target="<?php echo esc_attr($faq_target); ?>">
                            <?php echo esc_html($faq_title); ?> →
                        </a>
                    </p>
                <?php endif; ?>

                <?php 
                // Alleen de adres-wrapper tonen als er minstens één veld gevuld is
                if ($address_title || $address_content || $address_email || $address_kvk) : ?>
                    <div class="contact-grid__address-info">
                        <?php if ($address_title) : ?>
                            <h3 class="contact-grid__address-title"><?php echo esc_html($address_title); ?></h3>
                        <?php endif; ?>
                        
                        <?php if ($address_content) : ?>
                            <p><?php echo nl2br(esc_html($address_content)); ?></p>
                        <?php endif; ?>

                        <?php if ($address_email) : ?>
                            <p>
                                <a href="mailto:<?php echo esc_attr($address_email); ?>">
                                    <?php echo esc_html($address_email); ?>
                                </a>
                            </p>
                        <?php endif; ?>

                        <?php if ($address_kvk) : ?>
                            <p class="contact-grid__kvk"><?php echo esc_html($address_kvk); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="contact-grid__col contact-grid__col--right">
                
                <?php if ($form_title) : ?>
                    <h3 class="contact-grid__form-title"><?php echo esc_html($form_title); ?></h3>
                <?php endif; ?>
                
                <?php if ($form_id) : ?>
                    <div class="contact-grid__form-wrapper">
                        <?php echo do_shortcode('[gravityform id="' . $form_id . '" title="false" description="false" ajax="true"]'); ?>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>
<!-- .block-contact -->