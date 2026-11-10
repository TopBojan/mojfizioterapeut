<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="utf-8" />
    <title><?php wp_title(''); ?><?php if (wp_title('', false)) {
                                        echo ' :';
                                    } ?> <?php bloginfo('name'); ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="<?php bloginfo('description'); ?>" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <div class="page-wrapper">

        <?php
        $logo = function_exists('get_field') ? get_field('header_logo', 'option') : null;
        $brand = function_exists('get_field') ? get_field('header_brand', 'option') : '';
        $header_link = function_exists('get_field') ? get_field('header_link', 'option') : null;
        $brand = $brand ? $brand : 'MOJ FIZIOTERAPEUT';

        if (empty($header_link['url']) && is_page_template('page-templates/template-flexible.php')) {
            $header_link = array(
                'url'    => '#paketi',
                'title'  => 'Vodič i LIVE podrška',
                'target' => '',
            );
        }
        ?>

        <header class="header" role="banner">
            <div class="container">
                <div class="header-inner">
                    <a class="header-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr($brand); ?>">
                        <?php if (!empty($logo['url'])) : ?>
                            <?php mf_image($logo, 'header-brand-logo', 'medium'); ?>
                        <?php endif; ?>
                        <span class="header-brand-name"><?php echo esc_html($brand); ?></span>
                    </a>

                    <?php
                    $guide_url = mf_guide_page_url();
                    $booking_url = mf_booking_page_url();
                    $show_guide_link = $guide_url && (!is_user_logged_in() || mf_user_can_access_guide());
                    $show_booking_link = $booking_url && (!is_user_logged_in() || mf_user_can_access_booking());
                    $show_header_link = !empty($header_link['url']) && !empty($header_link['title']);
                    ?>
                    <?php if ($show_header_link || $show_guide_link || $show_booking_link) : ?>
                        <nav class="header-nav" aria-label="Glavni meni">
                            <?php if ($show_header_link) : ?>
                                <a class="header-link" href="<?php echo esc_url($header_link['url']); ?>" <?php echo !empty($header_link['target']) ? 'target="' . esc_attr($header_link['target']) . '" rel="noopener"' : ''; ?>>
                                    <?php echo esc_html($header_link['title']); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ($show_guide_link) : ?>
                                <a class="header-guide" href="<?php echo esc_url($guide_url); ?>">Video i PDF</a>
                            <?php endif; ?>

                            <?php if ($show_booking_link) : ?>
                                <a class="header-link" href="<?php echo esc_url($booking_url); ?>">Zakazivanje</a>
                            <?php endif; ?>
                        </nav>
                    <?php endif; ?>

                    <?php $account_label = is_user_logged_in() ? 'Profil' : 'Prijava'; ?>
                    <a class="header-account" href="<?php echo esc_url(mf_header_account_url()); ?>" aria-label="<?php echo esc_attr($account_label); ?>">
                        <svg class="header-account-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <circle cx="12" cy="8" r="3.25"></circle>
                            <path d="M5.75 19.25a6.25 6.25 0 0 1 12.5 0"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </header>
        <div class="brand-line" aria-hidden="true"></div>

        <main class="main" role="main">
