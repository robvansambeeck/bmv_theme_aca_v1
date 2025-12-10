<div class="nav nav-footer">
    <div class="nav-inner">
        <div class="nav-content">

            <div class="col pages">
                <?php
                wp_nav_menu([
                    'theme_location'  => 'footer_pages_alg',
                    'container'       => 'nav',
                    'container_class' => 'footer-nav footer-nav--pages',
                    'menu_class'      => 'footer-menu footer-menu--pages',
                    'fallback_cb'     => false,
                ]);
                ?>
            </div>

            <div class="col logo">
                <?php
                if (function_exists('the_custom_logo')) {
                    the_custom_logo();
                }
                ?>
            </div>

            <div class="col legal">
                <?php
                wp_nav_menu([
                    'theme_location'  => 'footer_pages_legal',
                    'container'       => 'nav',
                    'container_class' => 'footer-nav footer-nav--legal',
                    'menu_class'      => 'footer-menu footer-menu--legal',
                    'fallback_cb'     => false,
                ]);
                ?>
            </div>

        </div>
    </div>
</div>

<div class="copyright">
    All rights reserved 2025 | Design en ontwikkeling
    <a target="_blank" href="https://redrockagency.nl/">Red Rock Agency</a>
</div>