<?php
/**
 * Flexible layout: CTA: Media Split
 */

$section_id = get_sub_field('section_id');

$section_kicker = get_sub_field('section_kicker');
$section_heading = get_sub_field('section_heading');
$section_heading_accent = get_sub_field('section_heading_accent');
$section_intro = get_sub_field('section_intro');
$media_caption = get_sub_field('media_caption');

$media_image = absint(get_sub_field('media_image'));
$links = get_sub_field('links');

$heading_id = !empty($section_id) ? sanitize_title($section_id) . '-title' : '';
$should_render_section = $section_heading || $section_heading_accent || $section_intro || $media_image || $links;

if (!$should_render_section) {
    return;
}
?>

<section
    <?php echo !empty($section_id) ? 'id="' . esc_attr($section_id) . '"' : ''; ?>
    class="help section-dark"
    <?php echo !empty($heading_id) ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : ''; ?>
>
    <div class="shell help__grid">
        <?php if (!empty($media_image)) : ?>
            <div class="help__image reveal-media">
                <?php echo wp_get_attachment_image($media_image, 'full'); ?>
                <?php if (!empty($media_caption)) : ?>
                    <span><?php echo esc_html($media_caption); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="help__content">
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
                <p class="help__lead reveal"><?php echo nl2br(esc_html($section_intro)); ?></p>
            <?php endif; ?>

            <?php if (!empty($links)) : ?>
                <div class="help__links">
                    <?php foreach ($links as $link_item) : ?>
                        <?php
                        $link_eyebrow = $link_item['eyebrow'] ?? '';
                        $item_link = $link_item['link'] ?? null;
                        $item_link_url = $item_link['url'] ?? '';
                        $item_link_title = $item_link['title'] ?? '';
                        $item_link_target = ($item_link['target'] ?? '') === '_blank' ? '_blank' : '_self';
                        ?>
                        <?php if (!empty($item_link_url) && !empty($item_link_title)) : ?>
                            <a
                                class="help-link reveal-row"
                                href="<?php echo esc_url($item_link_url); ?>"
                                target="<?php echo esc_attr($item_link_target); ?>"
                                <?php echo $item_link_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
                                <?php echo strpos($item_link_url, '#') === 0 ? 'data-scroll-link' : ''; ?>
                            >
                                <span>
                                    <?php if (!empty($link_eyebrow)) : ?>
                                        <small><?php echo esc_html($link_eyebrow); ?></small>
                                    <?php endif; ?>
                                    <?php echo esc_html($item_link_title); ?>
                                </span>
                                <i aria-hidden="true">↗</i>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
