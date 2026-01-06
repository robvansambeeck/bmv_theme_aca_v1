<?php
/**
 * Template part for displaying course cards
 */

$post_id = get_the_ID();

// 1. Categorie logica (haal termen één keer op)
$all_categories = get_the_terms($post_id, 'category');
$filter_slugs   = [];
$level_name     = '';

// Parent IDs ophalen
$parent_course = get_term_by('slug', 'opleiding', 'category');
$parent_level  = get_term_by('slug', 'level', 'category');

if ($all_categories && !is_wp_error($all_categories)) {
    foreach ($all_categories as $term) {
        // Verzamel slugs voor de JS filter
        if ($parent_course && (int) $term->parent === (int) $parent_course->term_id) {
            $filter_slugs[] = $term->slug;
        }
        // Zoek naar het niveau (level)
        if ($parent_level && (int) $term->parent === (int) $parent_level->term_id) {
            $level_name = $term->name;
        }
    }
}

$data_terms = implode(',', array_unique($filter_slugs));

// 2. Datum logica
$course_date = get_field('course_date', $post_id);
$date_display = '';

if ($course_date) {
    $timestamp = strtotime($course_date);
    if ($timestamp) {
        // wp_date respecteert de WordPress taalinstellingen
        $date_display = 'Start ' . wp_date('F Y', $timestamp);
    }
}
?>

<a class="card card-course" 
   href="<?php the_permalink(); ?>" 
   aria-label="Bekijk opleiding: <?php echo esc_attr(get_the_title()); ?>"
   data-course-card 
   data-terms="<?php echo esc_attr($data_terms); ?>">

    <div class="card-inner">
        <div class="card-content">
            
            <div class="card-img">
                <?php if ($date_display) : ?>
                    <div class="card-date">
                        <?php echo esc_html($date_display); ?>
                    </div>
                <?php endif; ?>

                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large'); ?>
                <?php else : ?>
                    <div class="card-placeholder"></div>
                <?php endif; ?>
            </div>

            <div class="card-info">
                <div class="title-row">
                    <h5><?php the_title(); ?></h5>
                    <?php if ($level_name) : ?>
                        <div class="level-badge">
                            <?php echo esc_html($level_name); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="description">
                    <?php 
                    // get_the_excerpt() gebruiken we om handmatig te strippen 
                    // zodat we geen <p> tags in een <span> krijgen.
                    $excerpt = get_the_excerpt();
                    echo wp_trim_words($excerpt, 20); 
                    ?>
                </div>

                <?php 
                $tags = get_the_terms($post_id, 'post_tag');
                if ($tags && !is_wp_error($tags)) : ?>
                    <div class="tags">
                        <?php foreach ($tags as $tag) : ?>
                            <span class="tag"><?php echo esc_html($tag->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</a>
<!-- .card-course -->