<?php
$parent = get_term_by('slug', 'opleiding', 'category');
$parent_id = $parent ? (int) $parent->term_id : 0;

$terms = get_the_terms(get_the_ID(), 'category');
$filter_slugs = [];

// Pak ALLEEN subcats van "opleiding"
if ($terms && ! is_wp_error($terms) && $parent_id) {
    foreach ($terms as $term) {
        if ((int) $term->parent === $parent_id) {
            $filter_slugs[] = $term->slug;
        }
    }
}

$data_terms = implode(',', array_unique($filter_slugs)); // kan leeg zijn
?>

<div class="card card-course"
    data-course-card
    data-terms="<?php echo esc_attr($data_terms); ?>">

    <div class="card-inner">
        <div class="card-content">

            <div class="card-img">
                <?php the_post_thumbnail('large'); ?>
            </div>

            <div class="card-info">
                <div class="title"><?php the_title(); ?></div>
                <div class="description"><?php the_excerpt(); ?></div>
            </div>

        </div>
    </div>
</div>