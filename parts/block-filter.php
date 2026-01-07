<?php
/**
 * Block Name: Course Filter
 */

$show_filter = get_field('course_filter');
if (!$show_filter) return;

// 1. Haal de hoofd-categorie op
$parent = get_term_by('slug', 'opleiding', 'category');
$parent_id = $parent ? (int) $parent->term_id : 0;

// 2. Haal sub-categorieën alleen op als de parent bestaat
$sub_terms = ($parent_id > 0) ? get_terms([
    'taxonomy'   => 'category',
    'parent'     => $parent_id,
    'hide_empty' => true,
]) : [];

// 3. Valideer huidige filter uit URL
$current_filter = isset($_GET['filter']) ? sanitize_title(wp_unslash($_GET['filter'])) : 'all';
$valid_slugs = !empty($sub_terms) ? array_map(fn($t) => $t->slug, $sub_terms) : [];

if ($current_filter !== 'all' && !in_array($current_filter, $valid_slugs, true)) {
    $current_filter = 'all';
}

// 4. Query argumenten opbouwen
$args = [
    'post_type'      => 'opleiding',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
];

// Als er een filter actief is, voeg tax_query toe
if ($current_filter !== 'all') {
    $args['tax_query'] = [
        [
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $current_filter,
        ],
    ];
}

$q = new WP_Query($args);
?>

<div class="block block-filter">
    <div class="block-inner container">

        <div class="filter-controls">
            <div class="filter-tabs-scroll">
                <div class="filter-tabs" data-filter-group>
                    <button class="filter-tab <?php echo $current_filter === 'all' ? 'is-active' : ''; ?>"
                            data-filter="all">
                        Alle
                    </button>

                    <?php if (!empty($sub_terms)) : ?>
                        <?php foreach ($sub_terms as $term) : ?>
                            <button class="filter-tab <?php echo $current_filter === $term->slug ? 'is-active' : ''; ?>"
                                    data-filter="<?php echo esc_attr($term->slug); ?>">
                                <?php echo esc_html($term->name); ?>
                            </button>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="filter-output">
            <div class="block-content">
                <?php if ($q->have_posts()) : ?>
                    <div class="cards cards-courses card-grid" data-cards-wrap>
                        <?php while ($q->have_posts()) : $q->the_post(); 
                            // Haal categorieën van deze post op voor JS filtering
                            $terms = get_the_terms(get_the_ID(), 'category');
                            $slugs = $terms ? implode(' ', array_map(fn($t) => $t->slug, $terms)) : '';
                            ?>
                            <div class="filter-item" data-category="<?php echo esc_attr($slugs); ?>">
                                <?php get_template_part('parts/card', 'course'); ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else : ?>
                    <p class="no-results">Geen opleidingen gevonden in deze categorie.</p>
                <?php endif; 
                wp_reset_postdata(); ?>
            </div>
        </div>

    </div>
</div>
<!-- .block-filter -->