<?php
/*
@package (bmv_aca)
=========================
404.php

The 404 Not Found template. Used when WordPress cannot find a post or page that matches the query.
=========================
*/
?>

<?php
// Probeer eerst de uiteindelijke pagina '404'
$page = get_page_by_path('404');

// Als die niet bestaat, gebruik de testpagina
if (!$page) {
    $page = get_page_by_path('test-404');
}

if ($page) {
    global $post;
    $post = $page;
    setup_postdata($post);

    // Laad jouw page template
    include get_template_directory() . '/page-notification.php';

    wp_reset_postdata();
    exit;
}

// fallback voor als echt niets bestaat
get_header();
?>
<h1>404 - Pagina niet gevonden</h1>
<p>Deze pagina bestaat niet.</p>
<?php
get_footer();
