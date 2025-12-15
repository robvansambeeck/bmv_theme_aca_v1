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
                <div class="card-date">
                    <?php
                    $raw = get_field('course_date', get_the_ID());

                    if ($raw) {
                        $timestamp = strtotime($raw);
                        if ($timestamp) {
                            echo esc_html(wp_date('F Y', $timestamp));
                        }
                    }
                    ?>

                </div>
                <?php the_post_thumbnail('large'); ?>
            </div>
            <div class="card-info">
                <div class="title">
                    <h5><?php the_title(); ?></h5>
                    <div class="level">
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'category');
                        $level_parent = get_term_by('slug', 'level', 'category');

                        if ($terms && !is_wp_error($terms) && $level_parent) {
                            foreach ($terms as $term) {
                                if ((int) $term->parent === (int) $level_parent->term_id) {
                                    echo esc_html($term->name);
                                    break; // stop na eerste level
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="description">
                    <span><?php the_excerpt(); ?></span>
                </div>
                <div class="tags">
                    <?php
                    $tags = get_the_terms(get_the_ID(), 'post_tag');

                    if ($tags && !is_wp_error($tags)) {
                        foreach ($tags as $tag) {
                            echo '<span class="tag">' . esc_html($tag->name) . '</span>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /card-course -->