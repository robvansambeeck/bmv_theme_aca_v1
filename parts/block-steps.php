<?php
$steps = get_field('steps');
?>

<div class="block block-steps">
    <div class="block-inner">
        <div class="steps">

            <?php if ($steps) : ?>
                <div class="steps__grid">

                    <?php foreach ($steps as $index => $step) :
                        $icon  = $step['icon'];
                        $text  = $step['text'];
                        $number = $step['number'] ? $step['number'] : $index + 1;
                    ?>
                        <div class="steps__item">

                            <?php if ($icon) : ?>
                                <div class="steps__icon">
                                    <img src="<?php echo esc_url($icon['url']); ?>"
                                         alt="<?php echo esc_attr($icon['alt']); ?>">
                                </div>
                            <?php endif; ?>

                            <div class="steps__number"><?php echo $number; ?>.</div>

                            <?php if ($text) : ?>
                                <div class="steps__text"><?php echo $text; ?></div>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endif; ?>

        </div>
    </div>
</div>


<!-- /block-steps -->
