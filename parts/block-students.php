<?php
// Section titel
$title = get_field('section_titel');

// Repeater students
$students = get_field('students');
?>

<div class="block block-students">
    <div class="block-inner">

        <?php if ($title) : ?>
            <h2 class="block-students__title">
                <?php 
                // Highlight "studenten" in purple
                $title_highlighted = preg_replace(
                    '/\b(studenten)\b/i',
                    '<span class="block-students__title-highlight">$1</span>',
                    esc_html($title)
                );
                echo $title_highlighted;
                ?>
            </h2>
        <?php endif; ?>

        <?php if ($students) : ?>
            <div class="block-students__grid">

                <?php foreach ($students as $student) : ?>
                    <div class="student-card">

                        <?php if (!empty($student['picture_student'])) : ?>
                            <div class="student-card__photo">
                                <img src="<?php echo esc_url($student['picture_student']['url']); ?>" alt="<?php echo esc_attr($student['picture_student']['alt']); ?>">
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($student['name_student'])) : ?>
                            <h3 class="student-card__name">
                                <?php echo esc_html($student['name_student']); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if (!empty($student['program_student'])) : ?>
                            <p class="student-card__study">
                                <?php echo esc_html($student['program_student']); ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($student['discription'])) : ?>
                            <p class="student-card__desc">
                                <?php echo esc_html($student['discription']); ?>
                            </p>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>

            </div>
        <?php else : ?>
            <p>Geen studenten gevonden.</p>
        <?php endif; ?>

    </div>
</div>
