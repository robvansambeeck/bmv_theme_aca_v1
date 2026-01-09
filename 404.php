<?php
/*
@package (bmv_aca)
=========================
404.php
=========================
*/

// Zoek de pagina op
$page = get_page_by_path('404');
if (!$page) {
    $page = get_page_by_path('test-404');
}

if ($page) {
    // Gebruik direct het ID van de gevonden pagina voor de velden
    $page_id = $page->ID;
    $text    = get_field('text', $page_id);
    $button  = get_field('cta_button', $page_id);

    // Zet de globale post goed voor de template
    global $post;
    $post = $page;
    setup_postdata($post);

    include get_template_directory() . '/page-notification.php';

    wp_reset_postdata();
    exit;
}

// Fallback als er geen pagina gevonden wordt
get_header();
?>
<section class="block-404" style="padding: 100px 0; text-align: center; color: white;">
    <div class="container">
        <h1>404 - Pagina niet gevonden</h1>
        <p>De opgevraagde pagina bestaat niet.</p>
        <a href="<?php echo home_url(); ?>" class="btn-pill-outline">Terug naar home</a>
    </div>
</section>
<?php get_footer(); ?>