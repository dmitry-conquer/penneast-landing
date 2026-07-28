<?php
/**
 * Flexible layout: Content: Lists Split
 */

$section_id = get_sub_field('section_id');

$marquee_primary = get_sub_field('marquee_primary');
$marquee_secondary = get_sub_field('marquee_secondary');
$section_kicker = get_sub_field('section_kicker');
$section_heading = get_sub_field('section_heading');
$section_heading_accent = get_sub_field('section_heading_accent');
$section_intro = get_sub_field('section_intro');
$summary_label = get_sub_field('summary_label');
$summary_heading = get_sub_field('summary_heading');

$items = get_sub_field('items');
$summary_items = get_sub_field('summary_items');

$heading_id = !empty($section_id) ? sanitize_title($section_id) . '-title' : '';
$should_render_section = $section_heading || $section_heading_accent || $section_intro || $items || $summary_items;

if (!$should_render_section) {
    return;
}
?>

<section
    <?php echo !empty($section_id) ? 'id="' . esc_attr($section_id) . '"' : ''; ?>
    class="same section-blue"
    <?php echo !empty($heading_id) ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : ''; ?>
>
    <?php if (!empty($marquee_primary) || !empty($marquee_secondary)) : ?>
        <div class="same__marquee" aria-hidden="true">
            <div data-marquee-track>
                <div class="same__marquee-set" data-marquee-set>
                    <?php for ($marquee_index = 0; $marquee_index < 2; $marquee_index++) : ?>
                        <?php if (!empty($marquee_primary)) : ?>
                            <span><?php echo esc_html($marquee_primary); ?></span><i></i>
                        <?php endif; ?>
                        <?php if (!empty($marquee_secondary)) : ?>
                            <span><?php echo esc_html($marquee_secondary); ?></span><i></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="shell same__grid">
        <div>
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

            <?php if (!empty($section_intro)) : ?>
                <p class="same__intro reveal"><?php echo nl2br(esc_html($section_intro)); ?></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($items)) : ?>
            <ul class="same__list">
                <?php foreach ($items as $item_index => $item) : ?>
                    <?php $item_text = $item['text'] ?? ''; ?>
                    <?php if (!empty($item_text)) : ?>
                        <li class="reveal-row">
                            <span><?php echo esc_html(str_pad((string) ($item_index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                            <?php echo esc_html($item_text); ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <?php if (!empty($summary_label) || !empty($summary_heading) || !empty($summary_items)) : ?>
        <div class="shell launch-glance reveal">
            <?php if (!empty($summary_label) || !empty($summary_heading)) : ?>
                <div class="launch-glance__title">
                    <?php if (!empty($summary_label)) : ?>
                        <span><?php echo esc_html($summary_label); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($summary_heading)) : ?>
                        <strong><?php echo esc_html($summary_heading); ?></strong>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($summary_items)) : ?>
                <dl>
                    <?php foreach ($summary_items as $summary_item) : ?>
                        <?php
                        $item_label = $summary_item['label'] ?? '';
                        $item_value = $summary_item['value'] ?? '';
                        ?>
                        <?php if (!empty($item_label) || !empty($item_value)) : ?>
                            <div>
                                <?php if (!empty($item_label)) : ?>
                                    <dt><?php echo esc_html($item_label); ?></dt>
                                <?php endif; ?>
                                <?php if (!empty($item_value)) : ?>
                                    <dd><?php echo nl2br(esc_html($item_value)); ?></dd>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </dl>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
