<?php
/**
 * Flexible layout: Resources: Video Cards Grid
 */

$section_id = get_sub_field('section_id');

$section_kicker = get_sub_field('section_kicker');
$section_heading = get_sub_field('section_heading');
$section_heading_accent = get_sub_field('section_heading_accent');
$section_intro = get_sub_field('section_intro');

$cards = get_sub_field('cards');

$heading_id = !empty($section_id) ? sanitize_title($section_id) . '-title' : '';
$should_render_section = $section_heading || $section_heading_accent || $section_intro || $cards;

if (!$should_render_section) {
    return;
}

$allowed_card_classes = [
    'one' => 'tutorial-card--one',
    'two' => 'tutorial-card--two',
    'three' => 'tutorial-card--three',
];
?>

<section
    <?php echo !empty($section_id) ? 'id="' . esc_attr($section_id) . '"' : ''; ?>
    class="tutorials section-cream"
    <?php echo !empty($heading_id) ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : ''; ?>
>
    <div class="shell tutorials__heading">
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
            <p class="reveal"><?php echo nl2br(esc_html($section_intro)); ?></p>
        <?php endif; ?>
    </div>

    <?php if (!empty($cards)) : ?>
        <div class="shell tutorial-grid">
            <?php foreach ($cards as $card) : ?>
                <?php
                $card_meta = $card['meta'] ?? '';
                $card_heading = $card['heading'] ?? '';
                $video_url = $card['video_url'] ?? '';
                $card_variant = $card['variant'] ?? '';
                $card_class = $allowed_card_classes[$card_variant] ?? '';
                ?>
                <?php if (!empty($video_url) && !empty($card_class)) : ?>
                    <a
                        class="tutorial-card <?php echo esc_attr($card_class); ?> tutorial-lightbox tilt-card tilt-reveal"
                        href="<?php echo esc_url($video_url); ?>"
                        data-type="video"
                        data-tilt-card
                    >
                        <?php if (!empty($card_meta)) : ?>
                            <span class="tutorial-card__meta"><?php echo esc_html($card_meta); ?></span>
                        <?php endif; ?>
                        <span class="tutorial-card__play" aria-hidden="true">▶</span>
                        <?php if (!empty($card_heading)) : ?>
                            <strong><?php echo esc_html($card_heading); ?></strong>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
