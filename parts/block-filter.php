<?php
$show_filter = get_field('course_filter');
if (! $show_filter) return;

$parent = get_term_by('slug', 'opleiding', 'category');
$parent_id = $parent ? (int) $parent->term_id : 0;

$sub_terms = $parent_id ? get_terms([
    'taxonomy'   => 'category',
    'parent'     => $parent_id,
    'hide_empty' => true,
]) : [];

$current_filter = isset($_GET['filter']) ? sanitize_title(wp_unslash($_GET['filter'])) : 'all';
$valid_slugs = array_map(fn($t) => $t->slug, $sub_terms);
if ($current_filter !== 'all' && !in_array($current_filter, $valid_slugs, true)) {
    $current_filter = 'all';
}
?>

<div class="block block-filter">
    <div class="block-inner">

        <div class="input">
            <div class="inner">
                    <div class="filter-tabs-scroll">
                      <div class="filter-tabs">
                    <button class="filter-tab <?php echo $current_filter === 'all' ? 'is-active' : ''; ?>"
                        data-filter="all">
                        Alle
                    </button>

                    <?php foreach ($sub_terms as $term) : ?>
                        <button class="filter-tab <?php echo $current_filter === $term->slug ? 'is-active' : ''; ?>"
                            data-filter="<?php echo esc_attr($term->slug); ?>">
                            <?php echo esc_html($term->name); ?>
                        </button>
                    <?php endforeach; ?>
                      </div>
                    </div>
            </div>
        </div>

        <div class="output">
            <div class="block-content">
                <div class="cards cards-courses card-grid" data-cards-wrap>

                    <?php
                    $q = new WP_Query([
                        'post_type' => 'opleiding',
                        'posts_per_page' => -1,
                    ]);

                    while ($q->have_posts()) : $q->the_post();
                        get_template_part('parts/card', 'course');
                    endwhile;
                    wp_reset_postdata();
                    ?>

                </div>
            </div>
        </div>

    </div>
</div>