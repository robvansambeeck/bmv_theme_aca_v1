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
                // Footer logo uit ACF options (Nav - footer > Footer Logo)
                $footer_logo = function_exists('get_field') ? get_field('footer_logo', 'option') : null;

                if ($footer_logo && is_array($footer_logo) && !empty($footer_logo['url'])) :
                    $footer_logo_url = esc_url($footer_logo['url']);
                    $footer_logo_alt = esc_attr($footer_logo['alt'] ?? get_bloginfo('name'));
                ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
                        <img src="<?php echo $footer_logo_url; ?>" alt="<?php echo $footer_logo_alt; ?>">
                    </a>
                <?php
                // Fallback: gebruik site identity logo als ACF nog niet is gevuld
                elseif (function_exists('the_custom_logo')) :
                    the_custom_logo();
                endif;
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