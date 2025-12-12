<?php
/*
@package (bmv_aca)
=========================
single.php

The single post template. Used when a single post is queried. For this and all other query templates, index.php is used if the query template is not present.
=========================
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