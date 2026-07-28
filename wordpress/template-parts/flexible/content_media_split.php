<?php
/**
 * Flexible layout: Content: Media Split
 */

$section_id = get_sub_field('section_id');

$section_kicker = get_sub_field('section_kicker');
$section_heading = get_sub_field('section_heading');
$section_heading_accent = get_sub_field('section_heading_accent');
$media_tag_label = get_sub_field('media_tag_label');
$media_tag_heading = get_sub_field('media_tag_heading');

$media_image = absint(get_sub_field('media_image'));
$content_items = get_sub_field('content_items');

$heading_id = !empty($section_id) ? sanitize_title($section_id) . '-title' : '';
$should_render_section = $section_heading || $section_heading_accent || $media_image || $content_items;

if (!$should_render_section) {
    return;
}
?>

<section
    <?php echo !empty($section_id) ? 'id="' . esc_attr($section_id) . '"' : ''; ?>
    class="story section-light"
    <?php echo !empty($heading_id) ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : ''; ?>
>
    <div class="shell story__intro">
        <?php if (!empty($section_kicker)) : ?>
            <p class="kicker reveal"><?php echo esc_html($section_kicker); ?></p>
        <?php endif; ?>

        <?php if (!empty($section_heading) || !empty($section_heading_accent)) : ?>
            <h2
                <?php echo !empty($heading_id) ? 'id="' . esc_attr($heading_id) . '"' : ''; ?>
                class="display-title display-title--wide"
                data-split-reveal
            >
                <?php echo !empty($section_heading) ? nl2br(esc_html($section_heading)) : ''; ?>
                <?php if (!empty($section_heading_accent)) : ?>
                    <span><?php echo nl2br(esc_html($section_heading_accent)); ?></span>
                <?php endif; ?>
            </h2>
        <?php endif; ?>
    </div>

    <div class="shell story__grid">
        <?php if (!empty($media_image)) : ?>
            <div class="story__image-wrap reveal-media">
                <?php echo wp_get_attachment_image($media_image, 'full'); ?>

                <?php if (!empty($media_tag_label) || !empty($media_tag_heading)) : ?>
                    <div class="story__image-tag">
                        <?php if (!empty($media_tag_label)) : ?>
                            <span><?php echo esc_html($media_tag_label); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($media_tag_heading)) : ?>
                            <strong><?php echo esc_html($media_tag_heading); ?></strong>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($content_items)) : ?>
            <div class="story__copy">
                <?php foreach ($content_items as $content_item) : ?>
                    <?php
                    $item_text = $content_item['text'] ?? '';
                    $is_lead = !empty($content_item['is_lead']);
                    ?>
                    <?php if (!empty($item_text)) : ?>
                        <p class="<?php echo $is_lead ? 'story__lead reveal' : 'reveal'; ?>"><?php echo nl2br(esc_html($item_text)); ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
