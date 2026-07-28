<?php
/**
 * Flexible layout: Hero: Media Overlap
 */

$section_id = get_sub_field('section_id');

$section_eyebrow = get_sub_field('section_eyebrow');
$section_kicker = get_sub_field('section_kicker');
$section_heading = get_sub_field('section_heading');
$section_heading_accent = get_sub_field('section_heading_accent');
$section_intro = get_sub_field('section_intro');
$section_text = get_sub_field('section_text');
$date_label = get_sub_field('date_label');
$date_value = get_sub_field('date_value');

$brand_logo = absint(get_sub_field('brand_logo'));
$product_image = absint(get_sub_field('product_image'));

$brand_link = get_sub_field('brand_link');
$primary_link = get_sub_field('primary_link');
$secondary_link = get_sub_field('secondary_link');
$scroll_link = get_sub_field('scroll_link');

$product_chips = get_sub_field('product_chips');

$heading_id = !empty($section_id) ? sanitize_title($section_id) . '-title' : '';
$should_render_section = $section_heading || $section_heading_accent || $section_intro || $section_text || $brand_logo || $product_image;

if (!$should_render_section) {
    return;
}

$brand_link_url = $brand_link['url'] ?? '';
$brand_link_title = $brand_link['title'] ?? '';
$brand_link_target = ($brand_link['target'] ?? '') === '_blank' ? '_blank' : '_self';

$primary_link_url = $primary_link['url'] ?? '';
$primary_link_title = $primary_link['title'] ?? '';
$primary_link_target = ($primary_link['target'] ?? '') === '_blank' ? '_blank' : '_self';

$secondary_link_url = $secondary_link['url'] ?? '';
$secondary_link_title = $secondary_link['title'] ?? '';
$secondary_link_target = ($secondary_link['target'] ?? '') === '_blank' ? '_blank' : '_self';

$scroll_link_url = $scroll_link['url'] ?? '';
$scroll_link_title = $scroll_link['title'] ?? '';
$date_segments = !empty($date_value) ? explode('.', $date_value) : [];
$date_aria_label = trim((string) $date_label . ' ' . (string) $date_value);
?>

<section
    <?php echo !empty($section_id) ? 'id="' . esc_attr($section_id) . '"' : ''; ?>
    class="hero section-dark"
    <?php echo !empty($heading_id) ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : ''; ?>
>
    <div class="hero__ambient hero__ambient--one" data-pointer-parallax data-depth="-34" aria-hidden="true"></div>
    <div class="hero__ambient hero__ambient--two" data-pointer-parallax data-depth="24" aria-hidden="true"></div>
    <div class="hero__grid" data-pointer-parallax data-depth="-7" aria-hidden="true"></div>
    <div class="hero__orbit hero__orbit--one" data-pointer-parallax data-depth="42" aria-hidden="true"></div>
    <div class="hero__orbit hero__orbit--two" data-pointer-parallax data-depth="-22" aria-hidden="true"></div>
    <div class="hero__spark" data-pointer-parallax data-depth="58" aria-hidden="true"></div>

    <?php if (!empty($product_image)) : ?>
        <div class="hero__product" data-pointer-parallax data-depth="16" aria-hidden="true">
            <span class="hero__product-halo"></span>
            <?php echo wp_get_attachment_image($product_image, 'full'); ?>

            <?php if (!empty($product_chips)) : ?>
                <?php
                $allowed_chip_classes = [
                    'primary' => 'hero__product-chip--one',
                    'credit' => 'hero__product-chip--credit',
                    'snapshot' => 'hero__product-chip--snapshot',
                    'accounts' => 'hero__product-chip--accounts',
                    'secondary' => 'hero__product-chip--two',
                ];
                ?>
                <?php foreach ($product_chips as $product_chip) : ?>
                    <?php
                    $chip_label = $product_chip['label'] ?? '';
                    $chip_position = $product_chip['position'] ?? '';
                    $chip_class = $allowed_chip_classes[$chip_position] ?? '';
                    ?>
                    <?php if (!empty($chip_label) && !empty($chip_class)) : ?>
                        <span class="hero__product-chip <?php echo esc_attr($chip_class); ?>"><?php echo esc_html($chip_label); ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="hero__top shell">
        <?php if (!empty($brand_logo) && !empty($brand_link_url)) : ?>
            <a
                class="brand-mark"
                href="<?php echo esc_url($brand_link_url); ?>"
                target="<?php echo esc_attr($brand_link_target); ?>"
                <?php echo $brand_link_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
                <?php echo !empty($brand_link_title) ? 'aria-label="' . esc_attr($brand_link_title) . '"' : ''; ?>
            >
                <?php echo wp_get_attachment_image($brand_logo, 'full'); ?>
            </a>
        <?php endif; ?>

        <?php if (!empty($section_eyebrow)) : ?>
            <span class="hero__eyebrow"><?php echo esc_html($section_eyebrow); ?></span>
        <?php endif; ?>
    </div>

    <div class="hero__content shell">
        <div class="hero__copy" data-pointer-parallax data-depth="5">
            <?php if (!empty($section_kicker)) : ?>
                <p class="kicker hero__kicker"><?php echo esc_html($section_kicker); ?></p>
            <?php endif; ?>

            <?php if (!empty($section_heading) || !empty($section_heading_accent)) : ?>
                <h1
                    <?php echo !empty($heading_id) ? 'id="' . esc_attr($heading_id) . '"' : ''; ?>
                    class="hero__title"
                    data-hero-title
                >
                    <?php if (!empty($section_heading)) : ?>
                        <?php echo nl2br(esc_html($section_heading)); ?>
                    <?php endif; ?>
                    <?php if (!empty($section_heading_accent)) : ?>
                        <em><?php echo esc_html($section_heading_accent); ?></em>
                    <?php endif; ?>
                </h1>
            <?php endif; ?>

            <?php if (!empty($section_intro)) : ?>
                <p class="hero__lead" data-hero-lead><?php echo nl2br(esc_html($section_intro)); ?></p>
            <?php endif; ?>

            <?php if (!empty($section_text)) : ?>
                <p class="hero__detail"><?php echo nl2br(esc_html($section_text)); ?></p>
            <?php endif; ?>

            <?php if ((!empty($primary_link_url) && !empty($primary_link_title)) || (!empty($secondary_link_url) && !empty($secondary_link_title))) : ?>
                <div class="hero__actions" data-hero-actions>
                    <?php if (!empty($primary_link_url) && !empty($primary_link_title)) : ?>
                        <a
                            class="button button--gold magnetic"
                            href="<?php echo esc_url($primary_link_url); ?>"
                            target="<?php echo esc_attr($primary_link_target); ?>"
                            <?php echo $primary_link_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
                            <?php echo strpos($primary_link_url, '#') === 0 ? 'data-scroll-link' : ''; ?>
                        >
                            <span><?php echo esc_html($primary_link_title); ?></span>
                            <span class="button__arrow" aria-hidden="true">↘</span>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($secondary_link_url) && !empty($secondary_link_title)) : ?>
                        <a
                            class="text-link"
                            href="<?php echo esc_url($secondary_link_url); ?>"
                            target="<?php echo esc_attr($secondary_link_target); ?>"
                            <?php echo $secondary_link_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
                            <?php echo strpos($secondary_link_url, '#') === 0 ? 'data-scroll-link' : ''; ?>
                        >
                            <?php echo esc_html($secondary_link_title); ?> <span aria-hidden="true">↗</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="hero__bottom shell">
        <?php if (!empty($date_label) || !empty($date_value)) : ?>
            <div
                class="hero__date"
                <?php echo !empty($date_aria_label) ? 'aria-label="' . esc_attr($date_aria_label) . '"' : ''; ?>
                data-hero-date
            >
                <?php if (!empty($date_label)) : ?>
                    <span class="hero__date-label"><?php echo esc_html($date_label); ?></span>
                <?php endif; ?>
                <?php if (!empty($date_value)) : ?>
                    <span class="hero__date-number">
                        <?php foreach ($date_segments as $date_segment_index => $date_segment) : ?>
                            <?php echo esc_html($date_segment); ?>
                            <?php if ($date_segment_index < count($date_segments) - 1) : ?>
                                <span>.</span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($scroll_link_url)) : ?>
            <a
                class="scroll-cue"
                href="<?php echo esc_url($scroll_link_url); ?>"
                <?php echo strpos($scroll_link_url, '#') === 0 ? 'data-scroll-link' : ''; ?>
            >
                <?php if (!empty($scroll_link_title)) : ?>
                    <span><?php echo esc_html($scroll_link_title); ?></span>
                <?php endif; ?>
                <i aria-hidden="true"></i>
            </a>
        <?php endif; ?>
    </div>
</section>
