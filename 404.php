<?php
/*
@package (bmv_aca)
=========================
404.php
=========================
*/

$page = get_page_by_path('404');

if (!$page) {
    $page = get_page_by_path('test-404');
}

if ($page) {
    global $post;
    $post = $page;
    setup_postdata($post);

    // DIT TOEVOEGEN: Haal de specifieke ACF velden op van de geselecteerde pagina
    $text = get_field('text', $page->ID);
    $button = get_field('cta_button', $page->ID);

    // Laad jouw page template
    include get_template_directory() . '/page-notification.php';

    wp_reset_postdata();
    exit;
}

// Fallback
get_header();
?>
<section class="block-404" style="padding: 100px 0; text-align: center;">
    <div class="container">
        <h1>404 - Pagina niet gevonden</h1>
        <p>Deze pagina bestaat niet of is verhuisd.</p>
        <a href="<?php echo home_url(); ?>" class="btn-pill-outline">Terug naar home</a>
    </div>
</section>
<?php get_footer(); ?>