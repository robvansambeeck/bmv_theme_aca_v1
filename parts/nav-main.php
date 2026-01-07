<?php
/**
 * Block Name: Main Navigation
 */

$nav_cta = get_field('nav_cta', 'option');
?>

<header class="nav-main" data-navigation>
    <div class="nav-bg"></div>
    
    <div class="nav-inner">
        <div class="nav-content">
            
            <?php // Logo ?>
            <div class="logo">
                <?php
                if (function_exists('the_custom_logo') && has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
                }
                ?>
            </div>

            <?php // Desktop Menu ?>
            <div class="items">
                <?php
                wp_nav_menu([
                    'theme_location' => 'main',
                    'container'      => 'nav',
                    'container_class' => 'main-nav',
                    'menu_class'     => 'main-menu',
                    'fallback_cb'    => false,
                ]);
                ?>
            </div>

            <?php // CTA & Mobile Toggle ?>
            <div class="nav-actions">
                <?php if ($nav_cta && !empty($nav_cta['url'])) : ?>
                    <a class="btn nav-cta"
                       href="<?php echo esc_url($nav_cta['url']); ?>"
                       target="<?php echo esc_attr($nav_cta['target'] ?: '_self'); ?>">
                        <?php echo esc_html($nav_cta['title']); ?>
                    </a>
                <?php endif; ?>

                <button class="toggle" 
                        aria-label="Menu openen" 
                        aria-expanded="false" 
                        data-nav-toggle>
                    <i class="fa-sharp-duotone fa-light fa-bars-sort fa-flip-horizontal toggle-icon toggle-icon--open"></i>
                    <i class="fa-light fa-xmark toggle-icon toggle-icon--close"></i>
                </button>
            </div>

        </div>
    </div>
</header>

<?php // Mobile Menu ?>
<div class="nav-mobile" aria-hidden="true" data-nav-mobile>
    <div class="nav-mobile__overlay" data-nav-toggle></div>
    <div class="nav-mobile__inner">
        <div class="nav-mobile__header">
            <button class="mobile-close" aria-label="Menu sluiten" data-nav-toggle>
                <i class="fa-light fa-xmark"></i>
            </button>
        </div>
        <div class="nav-mobile__content">
            <?php
            wp_nav_menu([
                'theme_location' => 'main',
                'container'      => 'nav',
                'container_class' => 'mobile-nav',
                'menu_class'     => 'mobile-menu-list',
                'fallback_cb'    => false,
            ]);
            ?>
        </div>
    </div>
</div>
<!-- .nav-main -->