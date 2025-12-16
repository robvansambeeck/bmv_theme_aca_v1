<div class="nav nav-main">
    <div class="nav-inner">
        <div class="nav-content">
            <div class="logo">
                <?php
                if (function_exists('the_custom_logo')) {
                    the_custom_logo();
                }
                ?>
            </div>
            <div class="items">
                <?php
                wp_nav_menu([
                    'theme_location' => 'main',        // zelfde als in register_nav_menu
                    'container'      => 'nav',        // wrapt het in <nav>...</nav>
                    'container_class' => 'main-nav',   // class op de <nav>
                    'menu_class'     => 'main-menu',  // class op de <ul>
                    'fallback_cb'    => false,        // niks tonen als er geen menu is gekoppeld
                ]);
                ?>
            </div>
            <div class="cta">
                <?php
                $nav_cta = get_field('nav_cta', 'option'); // ← ACF options page

                if ($nav_cta) : ?>
                    <a class="btn nav-cta"
                        href="<?php echo esc_url($nav_cta['url']); ?>"
                        target="<?php echo esc_attr($nav_cta['target'] ?: '_self'); ?>">
                        <?php echo esc_html($nav_cta['title']); ?>
                    </a>
                <?php endif; ?>
            </div>
            <button class="toggle" aria-label="Toggle menu" aria-expanded="false">
                <i class="fa-sharp-duotone fa-light fa-bars-sort fa-flip-horizontal toggle-icon toggle-icon--open"></i>
                <i class="fa-light fa-xmark toggle-icon toggle-icon--close"></i>
            </button>
        </div>
    </div>
</div>
<!-- /nav-main -->

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" aria-hidden="true">
    <div class="mobile-menu-content">
        <div class="mobile-menu-header">
            <div class="mobile-menu-logo">
                <?php
                if (function_exists('the_custom_logo')) {
                    the_custom_logo();
                }
                ?>
            </div>
            <button class="mobile-menu-close" aria-label="Close menu">
                <i class="fa-light fa-xmark"></i>
            </button>
        </div>
        <nav class="mobile-menu-nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'main',
                'container'      => false,
                'menu_class'     => 'mobile-menu-list',
                'fallback_cb'    => false,
            ]);
            ?>
        </nav>
    </div>
</div>