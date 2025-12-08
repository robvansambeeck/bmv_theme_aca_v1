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
<main>
    <?php
    // Start de WordPress Loop om de content van de huidige pagina/post op te halen
    if (have_posts()) :
        while (have_posts()) : the_post();

            // De functie die de volledige content (inclusief Gutenberg blokken) weergeeft
            the_content();

        endwhile;
    endif;
    ?>
</main>
<!-- /main -->
<?php get_footer(); ?>