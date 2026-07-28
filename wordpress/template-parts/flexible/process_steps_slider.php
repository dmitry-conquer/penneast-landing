<?php
/**
 * Flexible layout: Process: Steps Slider
 */

$section_id = get_sub_field('section_id');

$section_kicker = get_sub_field('section_kicker');
$section_heading = get_sub_field('section_heading');
$section_heading_accent = get_sub_field('section_heading_accent');
$section_intro = get_sub_field('section_intro');

$steps = get_sub_field('steps');

$heading_id = !empty($section_id) ? sanitize_title($section_id) . '-title' : '';
$should_render_section = $section_heading || $section_heading_accent || $section_intro || $steps;

if (!$should_render_section) {
    return;
}

$allowed_card_classes = [
    'gold' => 'prepare-card--gold',
    'blue' => 'prepare-card--blue',
    'navy' => 'prepare-card--navy',
];
?>

<section
    <?php echo !empty($section_id) ? 'id="' . esc_attr($section_id) . '"' : ''; ?>
    class="prepare section-cream"
    <?php echo !empty($heading_id) ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : ''; ?>
>
    <div class="shell prepare__heading">
        <div>
            <?php if (!empty($section_kicker)) : ?>
                <p class="kicker reveal"><?php echo esc_html($section_kicker); ?></p>
            <?php endif; ?>

            <?php if (!empty($section_heading) || !empty($section_heading_accent)) : ?>
                <h2
                    <?php echo !empty($heading_id) ? 'id="' . esc_attr($heading_id) . '"' : ''; ?>
                    class="display-title"
                    data-split-reveal
                >
                    <?php echo !empty($section_heading) ? nl2br(esc_html($section_heading)) : ''; ?>
                    <?php if (!empty($section_heading_accent)) : ?>
                        <span><?php echo nl2br(esc_html($section_heading_accent)); ?></span>
                    <?php endif; ?>
                </h2>
            <?php endif; ?>
        </div>

        <?php if (!empty($section_intro)) : ?>
            <p class="prepare__intro reveal"><?php echo nl2br(esc_html($section_intro)); ?></p>
        <?php endif; ?>
    </div>

    <?php if (!empty($steps)) : ?>
        <div class="prepare__track-wrap" data-prepare-track>
            <div class="prepare__track shell">
                <?php foreach ($steps as $step_index => $step) : ?>
                    <?php
                    $step_heading = $step['heading'] ?? '';
                    $step_description = $step['description'] ?? '';
                    $step_theme = $step['theme'] ?? '';
                    $card_class = $allowed_card_classes[$step_theme] ?? '';
                    ?>
                    <?php if (!empty($step_heading) || !empty($step_description)) : ?>
                        <article class="prepare-card <?php echo esc_attr($card_class); ?> tilt-card" data-tilt-card>
                            <div class="prepare-card__number"><?php echo esc_html(str_pad((string) ($step_index + 1), 2, '0', STR_PAD_LEFT)); ?></div>
                            <div class="prepare-card__content">
                                <?php if (!empty($step_heading)) : ?>
                                    <h3><?php echo esc_html($step_heading); ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($step_description)) : ?>
                                    <p><?php echo nl2br(esc_html($step_description)); ?></p>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
