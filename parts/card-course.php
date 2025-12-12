<div class="card card-course">
    <div class="card-inner">
        <div class="card-content">

            <div class="card-img">

                <?php
                // Startdatum badge
                $course_date = get_field('course_date'); // ACF Date Picker returns string in format set in field settings

                if ($course_date) {
                    // ACF Date Picker usually returns a string (e.g., "20251201" or "2025-12-01" depending on field settings)
                    // Convert to timestamp
                    $timestamp = false;
                    
                    if (is_array($course_date) && isset($course_date['date'])) {
                        // If it's an array with 'date' key
                        $timestamp = strtotime($course_date['date']);
                    } elseif (is_string($course_date)) {
                        // Most common: ACF returns a string
                        $timestamp = strtotime($course_date);
                    }

                    // Only display if we have a valid timestamp
                    if ($timestamp && $timestamp > 0) {
                        $label = sprintf(
                            'Start %s',
                            date_i18n('F Y', $timestamp) // "december 2025" (Nederlandse maandnaam)
                        );
                    ?>
                        <div class="card-course__badge">
                            <?php echo esc_html($label); ?>
                        </div>
                    <?php }
                } ?>

                <?php if (has_post_thumbnail()) : ?>
                    <figure class="card-course__image">
                        <?php the_post_thumbnail('large'); ?>
                    </figure>
                <?php endif; ?>

            </div>

            <div class="card-info">

                <div class="title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </div>

                <div class="level">
                    <?php
                    // Hoofd- en subcategorie uit taxonomy 'opleiding_cat'
                    $terms = get_the_terms(get_the_ID(), 'opleiding_cat');

                    $main_cat  = null;
                    $level_cat = null;

                    if ($terms && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            if ($term->parent == 0 && ! $main_cat) {
                                $main_cat = $term;
                            } elseif ($term->parent != 0 && ! $level_cat) {
                                $level_cat = $term;
                            }
                        }
                    }

                    if ($main_cat || $level_cat) {
                        if ($main_cat) {
                            echo esc_html($main_cat->name);
                        }
                        if ($main_cat && $level_cat) {
                            echo ' &gt; ';
                        }
                        if ($level_cat) {
                            echo esc_html($level_cat->name);
                        }
                    }
                    ?>
                </div>

                <div class="description">
                    <?php echo get_the_excerpt(); ?>
                </div>

                <div class="tags">
                    <?php
                    // Tags uit eigen taxonomy 'opleiding_tag' (of pas aan naar 'post_tag')
                    $tags = get_the_terms(get_the_ID(), 'opleiding_tag');

                    if ($tags && !is_wp_error($tags)) :
                        foreach ($tags as $tag) : ?>
                            <span class="tag">
                                <?php echo esc_html($tag->name); ?>
                            </span>
                    <?php endforeach;
                    endif;
                    ?>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- /card-course -->