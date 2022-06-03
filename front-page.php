<?php
get_header();
$bonus_id = get_field( 'main_bonus' );
$casino_id = get_post( $bonus_id )->post_parent;
$tms = wp_get_post_terms( $bonus_id, 'bonus_category', array( 'fields' => 'names' ) );
$bonus_cat = $tms ? $tms[0] : '';
$reflink = get_posts( array(
    'numberposts'       => 1,
    'post_type'         => 'reflink',
    'post_parent'       => $casino_id
) );
$rep = get_field('main_links', $reflink[0]->ID);
$bonus_link = '';
if ($rep) {
    foreach ($rep as $r) {
        if ($r['title'] == 'bonus_link')
            $bonus_link = $r['referal_link'];
    }
}
?>
<main id="main">
    <section class="banner">
        <div class="back_imgs">
            <div class="chip1 lazy" data-src="<?= get_template_directory_uri() ?>/assets/img/chip1.png"></div>
            <div class="chip3 lazy" data-src="<?= get_template_directory_uri() ?>/assets/img/chip3.png"></div>
            <div class="chip4 lazy" data-src="<?= get_template_directory_uri() ?>/assets/img/chip4.png"></div>
        </div>
        <div class="wrapper">
            <div class="banner_content">
                <div class="chip2" data-src="<?= get_template_directory_uri() ?>/assets/img/chip2.png"></div>
                <div class="title_block">
                    <h1><span><?= the_field( 'yellow_part' ); ?></span> <?= the_field( 'white_part' ); ?></h1>
                    <p><?= the_field( 'title_description' ); ?></p>
                </div>
                <div class="bonus_block">
                    <div class="bonus_card">
                        <div class="card_header">
                            <img loading="lazy" src="<?= wp_get_attachment_url( get_field( 'casino_logo', $casino_id ) ); ?>" alt="">
                        </div>
                        <div class="card_footer">
                            <?php

                            ?>
                            <img loading="lazy" src="<?= get_template_directory_uri() ?>/assets/img/rating.png" alt=""/>
                            <p><?= get_field( 'rating', $casino_id ); ?></p>
                            <div class="bonus_title">
                                <?= get_field( 'bonus_size', $bonus_id ) ? get_field( 'bonus_size', $bonus_id ) . ' AUD' : ''; ?>
                                <?= ( get_field( 'bonus_size', $bonus_id ) && get_field( 'free_spins', $bonus_id ) ) ? ' + ' : ''; ?>
                                <?= get_field( 'free_spins', $bonus_id ) ? get_field( 'free_spins', $bonus_id ) . ' FS' : ''; ?>
                            </div>
                            <a class="bonus_link" href="<?= $bonus_link; ?>">Get Bonus</a>
                        </div>
                    </div>
                    <img class="cup_img" loading="lazy" src="<?= wp_get_attachment_url( get_field( 'cup_image', $casino_id ) ); ?>" alt=""/>
                </div>
            </div>
        </div>
    </section>
</main>
<section class="info_content">
    <div class="wrapper">
        <?php get_template_part( 'template_parts/casino', 'block', array( 'page_id' => get_queried_object_id() ) ); ?>
        <?php get_template_part( 'template_parts/game', 'category-block' ); ?>
    </div>
</section>
<?php $about = get_field( 'about_us_block' ); ?>
<?php if ( $about ) : ?>
<section class="about_us_block">
    <div class="wrapper">
        <div class="about_content">
            <img loading="lazy" src="<?= wp_get_attachment_url( $about['image'] ); ?>" alt="">
            <div class="text_block">
                <h2 class="title_h2"><?= $about['question']; ?></h2>
                <span><?= $about['answer']; ?></span>
                <a href="<?= get_permalink( 102 ); ?>" class="about_link">About Us</a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php $reviews = get_field( 'casino_reviews_block' ); ?>
<?php if ( $reviews ) : ?>
<section class="casino_reviews_block">
    <div class="wrapper">
        <div class="casino_reviews_content">
            <h2 class="title_h2"><?= $reviews['title']; ?></h2>
            <div class="cr_desc"><?= $reviews['desc'] ?></div>
            <?php if ( $reviews['cards'] ) : ?>
                <div class="items">
                <?php foreach ( $reviews['cards'] as $item ) : ?>
                <div class="item">
                    <div class="first_line">
                        <img loading="lazy" src="<?= wp_get_attachment_url( $item['icon'] ); ?>" alt="">
                        <h3><?= $item['title']; ?></h3>
                    </div>
                    <span><?= $item['desc']; ?></span>
                </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php if ( get_field( 'faq_block_title' ) ) : ?>
    <?php get_template_part( 'template_parts/faq', 'block' ); ?>
<?php endif; ?>
<!--<?php get_template_part( 'template_parts/news', 'block' ); ?>-->
<?php get_footer(); ?>
