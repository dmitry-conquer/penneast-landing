<?php
/**
 * Flexible layout: Process: Steps Sticky
 */

$section_id = get_sub_field('section_id');

$section_kicker = get_sub_field('section_kicker');
$section_heading = get_sub_field('section_heading');
$section_heading_accent = get_sub_field('section_heading_accent');

$steps = get_sub_field('steps');

$heading_id = !empty($section_id) ? sanitize_title($section_id) . '-title' : '';
$should_render_section = $section_heading || $section_heading_accent || $steps;

if (!$should_render_section) {
    return;
}
?>

<section
    <?php echo !empty($section_id) ? 'id="' . esc_attr($section_id) . '"' : ''; ?>
    class="journey section-dark"
    <?php echo !empty($heading_id) ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : ''; ?>
>
    <div class="shell journey__layout">
        <div class="journey__sticky">
            <?php if (!empty($section_kicker)) : ?>
                <p class="kicker reveal"><?php echo esc_html($section_kicker); ?></p>
            <?php endif; ?>

            <?php if (!empty($section_heading) || !empty($section_heading_accent)) : ?>
                <h2
                    <?php echo !empty($heading_id) ? 'id="' . esc_attr($heading_id) . '"' : ''; ?>
                    class="display-title display-title--light"
                    data-split-reveal
                >
                    <?php echo !empty($section_heading) ? nl2br(esc_html($section_heading)) : ''; ?>
                    <?php if (!empty($section_heading_accent)) : ?>
                        <span><?php echo nl2br(esc_html($section_heading_accent)); ?></span>
                    <?php endif; ?>
                </h2>
            <?php endif; ?>
        </div>

        <?php if (!empty($steps)) : ?>
            <div class="journey__timeline" data-journey>
                <div class="journey__line" aria-hidden="true"><span data-journey-line></span><i data-journey-dot></i></div>

                <?php foreach ($steps as $step) : ?>
                    <?php
                    $step_label = $step['label'] ?? '';
                    $step_heading = $step['heading'] ?? '';
                    $step_items = $step['items'] ?? [];
                    ?>
                    <?php if (!empty($step_label) || !empty($step_heading) || !empty($step_items)) : ?>
                        <article class="journey-step" data-journey-step>
                            <?php if (!empty($step_label)) : ?>
                                <span class="journey-step__date"><?php echo esc_html($step_label); ?></span>
                            <?php endif; ?>

                            <?php if (!empty($step_heading)) : ?>
                                <h3><?php echo esc_html($step_heading); ?></h3>
                            <?php endif; ?>

                            <?php if (!empty($step_items)) : ?>
                                <ul>
                                    <?php foreach ($step_items as $step_item) : ?>
                                        <?php $item_text = $step_item['text'] ?? ''; ?>
                                        <?php if (!empty($item_text)) : ?>
                                            <li><?php echo esc_html($item_text); ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </article>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
