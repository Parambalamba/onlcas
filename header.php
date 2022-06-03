<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OnlineAusCasino</title>
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favs/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favs/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favs/favicon-16x16.png">
    <?php wp_head(); ?>
    <?php
        $menu = wp_nav_menu(array(
            'theme_location' => 'main_menu',
            'menu_class'     => 'main_menu',
            'depth'          => 2,
            'echo'           => false
        ));
        $mobile_menu = wp_nav_menu(array(
            'theme_location' => 'main_menu',
            'menu_class'     => 'main_menu',
            'menu_id'        => 'mobile-header-menu',
            'depth'          => 2,
            'echo'           => false
        ));
    ?>
</head>
<body <?= body_class(); ?>>

    <div class="overlay"></div>
    <header>
        <div class="wrapper">
            <div class="header_block">
                <div class="logo_block">
                    <?= the_custom_logo(); ?>
                </div>
                <div class="menu_block">
                    <?= $menu; ?>
                </div>
                <div class="burger_menu"></div>
            </div>
            <div class="mobile_menu">
                <?= $mobile_menu; ?>
            </div>
        </div>
    </header>
    <?php if ( !is_front_page() && !is_404() ) : ?>
        <div class="header_bottom_block">
            <div class="wrapper">
                <?php if ( function_exists('yoast_breadcrumb') ) {
                    yoast_breadcrumb();
                } ?>
            </div>
        </div>
    <?php endif; ?>



