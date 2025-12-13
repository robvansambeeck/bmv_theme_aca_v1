<?php
$parent = get_term_by('slug', 'opleiding', 'category');
$parent_id = $parent ? (int) $parent->term_id : 0;

$terms = get_the_terms(get_the_ID(), 'category');
$filter_slug = '';

// Pak ALLEEN subcats van "opleiding"
if ($terms && ! is_wp_error($terms)) {
    foreach ($terms as $term) {
        if ((int) $term->parent === $parent_id) {
            $filter_slug = $term->slug; // type-a / type-b / etc
            break;
        }
    }
}
?>

<div class="card card-course"
    data-course-card
    data-term="<?php echo esc_attr($filter_slug); ?>">

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