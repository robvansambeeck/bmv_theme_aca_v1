<?php
// Early return: als course_filter = false → block wordt niet getoond
$show_filter = get_field('course_filter');
if (! $show_filter) {
    return;
}

// Parent term "Opleiding" in taxonomy 'category'
$parent_term = get_term_by('slug', 'opleiding', 'category');

// Huidige filter uit de URL, bijv. ?opleiding_type=type-a
$current_filter = isset($_GET['opleiding_type'])
    ? sanitize_text_field($_GET['opleiding_type'])
    : '';

// Basis-URL van de pagina waar dit block staat
$base_url = get_permalink();

// Subcategorieën (children van "Opleiding")
$sub_terms = [];
if ($parent_term && ! is_wp_error($parent_term)) {
    $sub_terms = get_terms([
        'taxonomy'   => 'category',
        'hide_empty' => true,
        'parent'     => $parent_term->term_id,
    ]);
}
?>

<div class="block block-filter">
    <div class="block-inner">

        <div class="input">
            <div class="inner">

                <div class="filter-tabs">
                    <?php
                    // "Alle" knop – toont alle opleidingen onder hoofdcat "Opleiding"
                    $all_url = remove_query_arg('opleiding_type', $base_url);
                    ?>
                    <a href="<?php echo esc_url($all_url); ?>"
                        class="filter-tab <?php echo $current_filter === '' ? 'is-active' : ''; ?>">
                        Alle
                    </a>

                    <?php if ($sub_terms) : ?>
                        <?php foreach ($sub_terms as $term) :
                            $term_url = add_query_arg('opleiding_type', $term->slug, $base_url);
                        ?>
                            <a href="<?php echo esc_url($term_url); ?>"
                                class="filter-tab <?php echo $current_filter === $term->slug ? 'is-active' : ''; ?>">
                                <?php echo esc_html($term->name); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <div class="output">
            <div class="block-content">

                <?php
                // Basisquery voor CPT 'opleiding'
                $args = [
                    'post_type'      => 'opleiding',
                    'posts_per_page' => -1,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ];

                // Altijd beperken tot hoofdcat "Opleiding"
                $tax_query = [];

                if ($parent_term && ! is_wp_error($parent_term)) {
                    $tax_query[] = [
                        'taxonomy'         => 'category',
                        'field'            => 'term_id',
                        'terms'            => $parent_term->term_id,
                        'include_children' => true,
                    ];
                }

                // Extra filter op subcategorie als er één gekozen is
                if ($current_filter) {
                    $tax_query[] = [
                        'taxonomy' => 'category',
                        'field'    => 'slug',
                        'terms'    => $current_filter,
                    ];
                }

                if ($tax_query) {
                    $args['tax_query'] = $tax_query;
                }

                $opleidingen = new WP_Query($args);

                if ($opleidingen->have_posts()) : ?>

                    <div class="cards cards-courses">
                        <?php while ($opleidingen->have_posts()) : $opleidingen->the_post(); ?>
                            <?php get_template_part('parts/card', 'course'); ?>
                        <?php endwhile; ?>
                    </div>

                    <?php wp_reset_postdata(); ?>

                <?php else : ?>
                    <p>Er zijn geen opleidingen gevonden.</p>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>
<!-- /block-filter -->