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

    <link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/koto/assets/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/koto/assets/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/koto/assets/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/wp-content/themes/koto/assets/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="/wp-content/themes/koto/assets/images/favicons/safari-pinned-tab.svg" color="#2e2af6">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <div class="page-wrapper">

        <!-- header -->
        <header class="header" role="banner">
            <a href="/" class="header-logo"></a>

            <ul class="navigation-list">
                <li>
                    <a href="#">Nav 1</a>
                </li>
                <li>
                    <a href="#">Nav 2</a>
                </li>
            </ul>
        </header>
        <!-- /header -->

        <!-- main -->
        <main class="main" role="main">