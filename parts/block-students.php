<?php
/**
 * Block Name: Students / Reviews
 */

$title    = get_field('review_title'); // Let op: je gebruikte zowel section_titel als review_title
$students = get_field('students');
?>

<div class="block block-students">
    <div class="block-inner">

        <?php if ($title) : ?>
            <div class="block-students__header">
                <h2 class="title">
                    <?php echo wp_kses_post($title); ?>
                </h2>
            </div>
        <?php endif; ?>

        <?php if ($students) : ?>
            <div class="block-students__grid">

                <?php foreach ($students as $student) : 
                    $photo = $student['picture_student'] ?? null;
                    $name  = $student['name_student'] ?? '';
                    $study = $student['program_student'] ?? '';
                    $desc  = $student['discription'] ?? ''; // Let op de spelling 'discription' uit je ACF
                    
                    if ($name || $photo) : ?>
                        <div class="student-card">

                            <?php if ($photo) : ?>
                                <div class="student-card__photo">
                                    <img src="<?php echo esc_url($photo['url']); ?>" 
                                         alt="<?php echo esc_attr($photo['alt'] ?: $name); ?>"
                                         loading="lazy">
                                </div>
                            <?php endif; ?>

                            <div class="student-card__content">
                                <?php if ($name) : ?>
                                    <h3 class="student-card__name">
                                        <?php echo esc_html($name); ?>
                                    </h3>
                                <?php endif; ?>

                                <?php if ($study) : ?>
                                    <p class="student-card__study">
                                        <?php echo esc_html($study); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($desc) : ?>
                                    <div class="student-card__desc">
                                        <?php echo wp_kses_post($desc); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>

    </div>
</div>
<!-- .block-students -->