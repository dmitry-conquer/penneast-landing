<?php
/**
 * Flexible layout: Showcase: Media Pinned
 */

$section_id = get_sub_field('section_id');

$top_label = get_sub_field('top_label');
$scroll_label = get_sub_field('scroll_label');

$background_video = absint(get_sub_field('background_video'));
$slides = get_sub_field('slides');

$heading_id = !empty($section_id) ? sanitize_title($section_id) . '-title' : '';
$background_video_url = !empty($background_video) ? wp_get_attachment_url($background_video) : '';
$should_render_section = $background_video_url || $slides;

if (!$should_render_section) {
    return;
}

$allowed_product_classes = [
    'phone' => 'film-product--phone',
    'devices' => 'film-product--devices',
    'experience' => 'film-product--experience',
    'member' => 'film-product--member',
];

$normalize_media_variant = static function ($media_variant) {
    if (is_array($media_variant)) {
        $media_variant = $media_variant['value'] ?? $media_variant['label'] ?? '';
    }

    return sanitize_key((string) $media_variant);
};

$showcase_slides = array_values(array_filter($slides ?: [], static function ($slide) use ($allowed_product_classes, $normalize_media_variant) {
    $media_image = absint($slide['media_image'] ?? 0);
    $media_variant = $normalize_media_variant($slide['media_variant'] ?? '');

    return $media_image && isset($allowed_product_classes[$media_variant]);
}));
?>

<section
    <?php echo !empty($section_id) ? 'id="' . esc_attr($section_id) . '"' : ''; ?>
    class="scroll-film"
    data-scroll-film
    <?php echo !empty($heading_id) ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : ''; ?>
>
    <div class="scroll-film__sticky">
        <?php if (!empty($background_video_url)) : ?>
            <video class="scroll-film__video" autoplay muted loop playsinline preload="metadata" aria-hidden="true">
                <source src="<?php echo esc_url($background_video_url); ?>" type="video/mp4" />
            </video>
        <?php endif; ?>

        <div class="scroll-film__scrim" aria-hidden="true"></div>
        <div class="scroll-film__noise" aria-hidden="true"></div>

        <?php if (!empty($showcase_slides)) : ?>
            <div class="film-products" aria-hidden="true">
                <?php foreach ($showcase_slides as $slide_index => $slide) : ?>
                    <?php
                    $media_image = absint($slide['media_image'] ?? 0);
                    $media_variant = $normalize_media_variant($slide['media_variant'] ?? '');
                    $product_class = $allowed_product_classes[$media_variant] ?? '';
                    ?>
                    <?php if (!empty($media_image) && !empty($product_class)) : ?>
                        <?php
                        echo wp_get_attachment_image(
                            $media_image,
                            'full',
                            false,
                            [
                                'class' => 'film-product ' . $product_class . ($slide_index === 0 ? ' is-active' : ''),
                                'data-film-product' => '',
                                'alt' => '',
                            ]
                        );
                        ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($top_label) || !empty($scroll_label)) : ?>
            <div class="film-top shell">
                <?php if (!empty($top_label)) : ?>
                    <span><?php echo esc_html($top_label); ?></span>
                <?php endif; ?>
                <?php if (!empty($scroll_label)) : ?>
                    <span><?php echo esc_html($scroll_label); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($showcase_slides)) : ?>
            <div class="film-chapters shell">
                <?php foreach ($showcase_slides as $slide_index => $slide) : ?>
                    <?php
                    $slide_kicker = $slide['kicker'] ?? '';
                    $slide_heading = $slide['heading'] ?? '';
                    $slide_heading_accent = $slide['heading_accent'] ?? '';
                    $slide_description = $slide['description'] ?? '';
                    ?>
                    <?php if (!empty($slide_kicker) || !empty($slide_heading) || !empty($slide_heading_accent) || !empty($slide_description)) : ?>
                        <div class="film-chapter<?php echo $slide_index === 0 ? ' is-active' : ''; ?>" data-film-chapter>
                            <?php if (!empty($slide_kicker)) : ?>
                                <p class="kicker"><?php echo esc_html($slide_kicker); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($slide_heading) || !empty($slide_heading_accent)) : ?>
                                <h2 <?php echo $slide_index === 0 && !empty($heading_id) ? 'id="' . esc_attr($heading_id) . '"' : ''; ?>>
                                    <?php echo !empty($slide_heading) ? nl2br(esc_html($slide_heading)) : ''; ?>
                                    <?php if (!empty($slide_heading_accent)) : ?>
                                        <em><?php echo nl2br(esc_html($slide_heading_accent)); ?></em>
                                    <?php endif; ?>
                                </h2>
                            <?php endif; ?>

                            <?php if (!empty($slide_description)) : ?>
                                <p><?php echo nl2br(esc_html($slide_description)); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="film-progress shell" aria-hidden="true">
                <span>01</span>
                <div><i data-film-progress></i></div>
                <span><?php echo esc_html(str_pad((string) count($showcase_slides), 2, '0', STR_PAD_LEFT)); ?></span>
            </div>
        <?php endif; ?>
    </div>
</section>
