<?php

/**
 * Template Name: Digital Banking Landing
 * Template Post Type: page
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&family=Manrope:wght@400;500;600;700&display=swap"
    rel="stylesheet">
  <?php wp_head(); ?>
</head>

<body <?php body_class('is-loading'); ?>>
  <?php wp_body_open(); ?>

  <a class="skip-link" href="#main-content"><?php esc_html_e('Skip to content', 'penneast'); ?></a>

  <div class="page-progress" aria-hidden="true"><span></span></div>

  <main id="main-content">
    <?php if (function_exists('have_rows') && have_rows('content')) : ?>
      <?php while (have_rows('content')) : ?>
        <?php
        the_row();
        get_template_part('template-parts/flexible/' . get_row_layout());
        ?>
      <?php endwhile; ?>
    <?php endif; ?>
  </main>

  <noscript>
    <style>
      body.is-loading .reveal,
      body.is-loading .reveal-row,
      body.is-loading .reveal-media,
      body.is-loading .tilt-reveal,
      body.is-loading [data-split-reveal],
      body.is-loading [data-hero-title],
      body.is-loading [data-hero-lead],
      body.is-loading [data-hero-actions],
      body.is-loading [data-hero-date],
      body.is-loading .hero__top,
      body.is-loading .hero__kicker,
      body.is-loading .hero__bottom {
        opacity: 1 !important;
        visibility: visible !important;
        transform: none !important;
        clip-path: none !important;
      }

      body.is-loading {
        cursor: auto;
      }
    </style>
  </noscript>

  <?php wp_footer(); ?>
</body>

</html>