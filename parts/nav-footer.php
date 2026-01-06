<?php
/**
 * Block Name: Footer Navigation
 */

// Footer logo uit ACF options
$footer_logo = function_exists('get_field') ? get_field('footer_logo', 'option') : null;
$socials     = function_exists('get_field') ? get_field('social_media', 'option') : null; // Optionele repeater voor socials
?>

<footer class="nav-footer">
    <div class="nav-inner">
        <div class="nav-content">

            <?php // Kolom 1: Algemene Pagina's ?>
            <div class="col col--pages">
                <?php
                wp_nav_menu([
                    'theme_location'  => 'footer_pages_alg',
                    'container'       => 'nav',
                    'container_class' => 'footer-nav',
                    'menu_class'      => 'footer-menu',
                    'fallback_cb'     => false,
                ]);
                ?>
            </div>

            <?php // Kolom 2: Logo & Socials ?>
            <div class="col col--branding">
                <div class="footer-logo-wrap">
                    <?php if ($footer_logo && !empty($footer_logo['url'])) : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
                            <img src="<?php echo esc_url($footer_logo['url']); ?>" 
                                 alt="<?php echo esc_attr($footer_logo['alt'] ?: get_bloginfo('name')); ?>"
                                 loading="lazy">
                        </a>
                    <?php elseif (function_exists('the_custom_logo')) : ?>
                        <?php the_custom_logo(); ?>
                    <?php endif; ?>
                </div>

                <?php if ($socials) : ?>
                    <div class="footer-socials">
                        <?php foreach ($socials as $social) : ?>
                            <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener">
                                <i class="<?php echo esc_attr($social['icon_class']); ?>"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php // Kolom 3: Juridische Pagina's ?>
            <div class="col col--legal">
                <?php
                wp_nav_menu([
                    'theme_location'  => 'footer_pages_legal',
                    'container'       => 'nav',
                    'container_class' => 'footer-nav',
                    'menu_class'      => 'footer-menu',
                    'fallback_cb'     => false,
                ]);
                ?>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="copyright">
            &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> | All rights reserved | 
            Design en ontwikkeling <a target="_blank" rel="nofollow" href="https://redrockagency.nl/">Red Rock Agency</a>
        </div>
    </div>
</footer>
<!-- .nav-footer -->