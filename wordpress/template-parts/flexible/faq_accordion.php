<?php
/**
 * Flexible layout: FAQ: Accordion
 */

$section_id = get_sub_field('section_id');

$section_kicker = get_sub_field('section_kicker');
$section_heading = get_sub_field('section_heading');
$section_heading_accent = get_sub_field('section_heading_accent');

$categories = get_sub_field('categories');

$heading_id = !empty($section_id) ? sanitize_title($section_id) . '-title' : '';
$should_render_section = $section_heading || $section_heading_accent || $categories;

if (!$should_render_section) {
    return;
}
?>

<section
    <?php echo !empty($section_id) ? 'id="' . esc_attr($section_id) . '"' : ''; ?>
    class="faq section-light"
    <?php echo !empty($heading_id) ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : ''; ?>
>
    <div class="shell faq__layout">
        <div class="faq__heading">
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

        <?php if (!empty($categories)) : ?>
            <div class="faq__items">
                <?php foreach ($categories as $category) : ?>
                    <?php
                    $category_heading = $category['heading'] ?? '';
                    $category_items = $category['items'] ?? [];
                    ?>
                    <?php if (!empty($category_heading)) : ?>
                        <p class="faq-category"><?php echo esc_html($category_heading); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($category_items)) : ?>
                        <?php foreach ($category_items as $accordion_item) : ?>
                            <?php
                            $item_question = $accordion_item['question'] ?? '';
                            $item_answer = $accordion_item['answer'] ?? '';
                            $is_open = !empty($accordion_item['is_open']);
                            ?>
                            <?php if (!empty($item_question) || !empty($item_answer)) : ?>
                                <details class="faq-item reveal-row" <?php echo $is_open ? 'open' : ''; ?>>
                                    <?php if (!empty($item_question)) : ?>
                                        <summary><?php echo esc_html($item_question); ?><span aria-hidden="true"></span></summary>
                                    <?php endif; ?>
                                    <?php if (!empty($item_answer)) : ?>
                                        <p><?php echo nl2br(esc_html($item_answer)); ?></p>
                                    <?php endif; ?>
                                </details>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
