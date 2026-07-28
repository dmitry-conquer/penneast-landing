<?php
/**
 * Flexible layout: Features: Media List
 */

$section_id = get_sub_field('section_id');

$section_kicker = get_sub_field('section_kicker');
$section_heading = get_sub_field('section_heading');
$section_heading_accent = get_sub_field('section_heading_accent');
$section_intro = get_sub_field('section_intro');
$media_label = get_sub_field('media_label');
$media_heading = get_sub_field('media_heading');
$badge_label = get_sub_field('badge_label');
$badge_value = get_sub_field('badge_value');

$media_image = absint(get_sub_field('media_image'));
$features = get_sub_field('features');

$heading_id = !empty($section_id) ? sanitize_title($section_id) . '-title' : '';
$should_render_section = $section_heading || $section_heading_accent || $section_intro || $media_image || $features;

if (!$should_render_section) {
    return;
}
?>

<section
    <?php echo !empty($section_id) ? 'id="' . esc_attr($section_id) . '"' : ''; ?>
    class="features section-light"
    <?php echo !empty($heading_id) ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : ''; ?>
>
    <div class="shell features__heading">
        <div>
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

        <?php if (!empty($section_intro)) : ?>
            <p class="features__intro reveal"><?php echo nl2br(esc_html($section_intro)); ?></p>
        <?php endif; ?>
    </div>

    <?php if (!empty($media_image)) : ?>
        <div class="shell product-stage reveal" data-product-stage>
            <?php if (!empty($media_label) || !empty($media_heading)) : ?>
                <div class="product-stage__copy">
                    <?php if (!empty($media_label)) : ?>
                        <span><?php echo esc_html($media_label); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($media_heading)) : ?>
                        <strong><?php echo esc_html($media_heading); ?></strong>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php echo wp_get_attachment_image($media_image, 'full'); ?>

            <?php if (!empty($badge_label) || !empty($badge_value)) : ?>
                <div class="product-stage__badge" aria-hidden="true">
                    <?php if (!empty($badge_label)) : ?>
                        <span><?php echo esc_html($badge_label); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($badge_value)) : ?>
                        <strong><?php echo esc_html($badge_value); ?></strong>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($features)) : ?>
        <div class="shell features__list">
            <?php foreach ($features as $feature_index => $feature) : ?>
                <?php
                $feature_heading = $feature['heading'] ?? '';
                $feature_description = $feature['description'] ?? '';
                ?>
                <?php if (!empty($feature_heading) || !empty($feature_description)) : ?>
                    <article class="feature-row reveal-row">
                        <span class="feature-row__number"><?php echo esc_html(str_pad((string) ($feature_index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                        <?php if (!empty($feature_heading)) : ?>
                            <h3><?php echo esc_html($feature_heading); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($feature_description)) : ?>
                            <p><?php echo nl2br(esc_html($feature_description)); ?></p>
                        <?php endif; ?>
                        <span class="feature-row__mark" aria-hidden="true">↗</span>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
