<?php
$show_filter = get_field('course_filter');
if (! $show_filter) return;

$parent = get_term_by('slug', 'opleiding', 'category');

$sub_terms = get_terms([
    'taxonomy'   => 'category',
    'parent'     => $parent->term_id,
    'hide_empty' => true,
]);
?>

<div class="block block-filter">
    <div class="block-inner">

        <div class="input">
            <div class="inner">
                <div class="filter-tabs">

                    <button class="filter-tab is-active" data-filter="all">
                        Alle
                    </button>

                    <?php foreach ($sub_terms as $term) : ?>
                        <button class="filter-tab"
                            data-filter="<?php echo esc_attr($term->slug); ?>">
                            <?php echo esc_html($term->name); ?>
                        </button>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>

        <div class="output">
            <div class="block-content">
                <div class="cards cards-courses" data-cards-wrap>

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