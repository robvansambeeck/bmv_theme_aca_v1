<?php
/*
@package (bmv_aca)
=========================
page-notification.php

The page template. Used when an individual Page is queried.
=========================

Template Name: Page Notification
Template Post Type: page
*/
?>

<?php get_header(); ?>
<?php get_template_part('parts/nav-main'); ?>
<main class="page-wrapper">
    <div class="page-content">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</main>
<?php get_footer(); ?>