<?php
/**
 * Flexible layout: CTA: Centered
 */

$section_id = get_sub_field('section_id');

$section_kicker = get_sub_field('section_kicker');
$section_heading = get_sub_field('section_heading');
$section_heading_accent = get_sub_field('section_heading_accent');
$section_note = get_sub_field('section_note');
$credit_label = get_sub_field('credit_label');

$content_items = get_sub_field('content_items');

$primary_link = get_sub_field('primary_link');
$credit_link = get_sub_field('credit_link');

$heading_id = !empty($section_id) ? sanitize_title($section_id) . '-title' : '';
$should_render_section = $section_heading || $section_heading_accent || $content_items || $primary_link || $section_note || $credit_link;

if (!$should_render_section) {
    return;
}

$primary_link_url = $primary_link['url'] ?? '';
$primary_link_title = $primary_link['title'] ?? '';
$primary_link_target = ($primary_link['target'] ?? '') === '_blank' ? '_blank' : '_self';

$credit_link_url = $credit_link['url'] ?? '';
$credit_link_title = $credit_link['title'] ?? '';
$credit_link_target = ($credit_link['target'] ?? '') === '_blank' ? '_blank' : '_self';
?>

<section
    <?php echo !empty($section_id) ? 'id="' . esc_attr($section_id) . '"' : ''; ?>
    class="closing section-gold"
    <?php echo !empty($heading_id) ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : ''; ?>
>
    <div class="closing__ring closing__ring--one" aria-hidden="true"></div>
    <div class="closing__ring closing__ring--two" aria-hidden="true"></div>

    <div class="shell closing__content">
        <?php if (!empty($section_kicker)) : ?>
            <p class="kicker reveal"><?php echo esc_html($section_kicker); ?></p>
        <?php endif; ?>

        <?php if (!empty($section_heading) || !empty($section_heading_accent)) : ?>
            <h2
                <?php echo !empty($heading_id) ? 'id="' . esc_attr($heading_id) . '"' : ''; ?>
                data-split-reveal
            >
                <?php echo !empty($section_heading) ? nl2br(esc_html($section_heading)) : ''; ?>
                <?php if (!empty($section_heading_accent)) : ?>
                    <em><?php echo nl2br(esc_html($section_heading_accent)); ?></em>
                <?php endif; ?>
            </h2>
        <?php endif; ?>

        <?php if (!empty($content_items)) : ?>
            <?php foreach ($content_items as $content_item) : ?>
                <?php $item_text = $content_item['text'] ?? ''; ?>
                <?php if (!empty($item_text)) : ?>
                    <p class="reveal"><?php echo nl2br(esc_html($item_text)); ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($primary_link_url) && !empty($primary_link_title)) : ?>
            <a
                class="button button--navy magnetic reveal"
                href="<?php echo esc_url($primary_link_url); ?>"
                target="<?php echo esc_attr($primary_link_target); ?>"
                <?php echo $primary_link_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
                <?php echo strpos($primary_link_url, '#') === 0 ? 'data-scroll-link' : ''; ?>
            >
                <span><?php echo esc_html($primary_link_title); ?></span>
                <span class="button__arrow" aria-hidden="true">↑</span>
            </a>
        <?php endif; ?>

        <?php if (!empty($section_note)) : ?>
            <span class="closing__note"><?php echo esc_html($section_note); ?></span>
        <?php endif; ?>

        <?php if (!empty($credit_label) || (!empty($credit_link_url) && !empty($credit_link_title))) : ?>
            <span class="closing__credit">
                <?php echo !empty($credit_label) ? esc_html($credit_label) : ''; ?>
                <?php if (!empty($credit_link_url) && !empty($credit_link_title)) : ?>
                    <a
                        href="<?php echo esc_url($credit_link_url); ?>"
                        target="<?php echo esc_attr($credit_link_target); ?>"
                        <?php echo $credit_link_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
                    ><?php echo esc_html($credit_link_title); ?></a>
                <?php endif; ?>
            </span>
        <?php endif; ?>
    </div>
</section>
