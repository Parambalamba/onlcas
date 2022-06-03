<?php
	get_header();
    $game_id = get_queried_object_id();

/**
 * Game Categories
 */
    $terms = wp_get_post_terms( $game_id, 'game_category', array( 'fields' => 'names', 'parent' => 5 ) );

/**
 * Games from Yoast SEO primary category for slider
 */
    $t = '';
    if ( class_exists('WPSEO_Primary_Term' ) ) {
        $wpseo_primary_term = new WPSEO_Primary_Term( 'game_category', $game_id );
        $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
        $t = get_term( $wpseo_primary_term );
        $args = array(
            'post_type'     => 'game',
            'posts_per_page'   => -1,
            'exclude'       => $game_id,
            'tax_query' => [
                [
                    'taxonomy' => 'game_category',
                    'field'    => 'term_id', // тут можно указать slug и ниже вписать ярлыки нужных рубрик
                    'terms'    => $t->term_id,
                ]
            ],
        );
        $games = get_posts( $args );
    }
?>
<section class="main_game">
    <div class="wrapper">
        <h1 class="title_h1"><?= get_the_title(); ?></h1>
        <div class="main_game_content">
            <div class="game_left">
                <div class="game" style="background: url('<?= wp_get_attachment_url( get_field( 'single_game_image' ) ); ?>'); background-size: cover; background-repeat: no-repeat;">
                    <div class="game_block provider">
                        <span class="title">Game Provider:</span>
                        <img loading="lazy" src="<?= wp_get_attachment_url( get_field( 'game_provider_logo' ) ); ?>" alt="">
                    </div>
                    <div class="game_block rate">
                        <span class="title">Game Rating:</span>
                        <div class="rating_block <?= get_rating_class(); ?>"><?= file_get_contents( get_template_directory_uri() . '/assets/img/stars.svg' ); ?><span><?= get_field( 'game_rating' ); ?></span></div>
                    </div>
                    <div class="game_block cats">
                        <span class="title">Game Categories:</span>
                        <?php if ( $terms ) : ?>
                            <div class="game_cats">
                            <?php foreach ( $terms as $term ) : ?>
                                <a href="<?= get_term_link( $term, 'game_category' ); ?>"><?= $term; ?></a>
                            <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <a href="#?" class="link_to_play">Play Now</a>
                </div>
                <?php if ( $games ) : ?>
                    <div class="games_slider_wrapper">
                        <div class="slider_game">
                        <?php foreach ( $games as $g ) : ?>
                            <div class="item">
                                <img loading="lazy" src="<?= wp_get_attachment_url( get_field( 'game_image', $g->ID ) ); ?>" alt="">
                                <a href="<?= get_permalink( $g ); ?>"><?= get_the_title( $g ); ?></a>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="game_details">
                <h3>Game Details</h3>
                <div class="details_block">
                    <div class="block_item">
                        <img loading="lazy" src="<?= get_template_directory_uri() ?>/assets/img/icons/info-icon.png" alt="">
                        <span class="item_title">Title:</span>
                        <span class="item_val"><?= get_the_title(); ?></span>
                    </div>
                    <div class="block_item">
                        <img loading="lazy" src="<?= get_template_directory_uri() ?>/assets/img/icons/type-icon.png" alt="">
                        <span class="item_title">Type:</span>
                        <a href="<?= get_term_link( $t->term_id, 'game_category' ); ?>"><?= $t->name; ?></a>
                    </div>
                    <?php if ( have_rows( 'game_details' ) ) : ?>
                    <?php while ( have_rows( 'game_details' ) ) : the_row(); ?>
                    <div class="block_item">
                        <img loading="lazy" src="<?= wp_get_attachment_url( get_sub_field( 'icon' ) ); ?>" alt="">
                        <span class="item_title"><?= get_sub_field( 'title' ); ?></span>
                        <?php $type = get_sub_field( 'type' ); ?>
                        <?php if ( $type == 'Text' ) : ?>
                            <span class="item_val"><?= get_sub_field( 'value' ); ?></span>
                        <?php elseif ( $type == 'Link' ) : ?>
                            <a href="<?= get_sub_field( 'link' ); ?>"><?= get_sub_field( 'value' ); ?></a>
                        <?php else : ?>
                            <?php $casinos = get_sub_field( 'casino' ); ?>
                            <?php if ( $casinos ) : ?>
                                <?php $count = count( $casinos ); ?>
                                <?php $i = 1; ?>
                                <div class="item_cas">
                                    <span class="many_links">
                                    <?php foreach ( $casinos as $cas ) : ?>
                                        <a class="cas_link" href="<?= get_permalink( $cas ); ?>"><?= get_the_title( $cas ); ?><?= $i < $count ? ',' : ''; ?></a>

                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                    </span>
                            <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>

                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="provider_info"><?= get_field( 'game_provider_info' ); ?></div>
    </div>
</section>
<section class="prons_cons">
    <div class="wrapper">
        <div class="prons_cons_block">
            <div class="prons_items">
                <h2 class="title">Pros & Cons <?= get_the_title(); ?></h2>
                <?php
                    $pros = get_field( 'prons_block' );
                    $pr_plus = array();
                    $pr_minus = array();
                    foreach ( $pros as $pr ) {
                        if ( $pr['is_have'] )
                            $pr_plus[] = $pr;
                        else
                            $pr_minus[] = $pr;
                    }
                ?>
                <?php if ( $pr_plus ) : ?>
                    <div class="items_plus">
                    <?php foreach ( $pr_plus as $pr ) : ?>
                        <div class="plus">
                            <img loading="lazy" src="<?= get_template_directory_uri() ?>/assets/img/icons/checked.svg" alt="">
                            <span><?= $pr['pluses']; ?></span>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if ( $pr_minus ) : ?>
                    <div class="items_minus">
                    <?php foreach ( $pr_minus as $pr ) : ?>
                        <div class="minus">
                            <img loading="lazy" src="<?= get_template_directory_uri() ?>/assets/img/icons/not-checked.svg" alt="">
                            <span><?= $pr['pluses']; ?></span>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="pros_img">
                <img loading="lazy" src="<?= wp_get_attachment_url( get_field( 'prons_image' ) ); ?>" alt="">
            </div>
        </div>
    </div>
</section>
<section class="casinos_block">
    <div class="wrapper">
        <?php get_template_part( 'template_parts/casino', 'block', array( 'page_id' => $game_id ) ); ?>

        <?php if ( have_rows( 'best_casinos_info_fc' ) ) : ?>
        <?php $is_readmore = false; ?>
        <div class="category_info_block">
            <?php while ( have_rows( 'best_casinos_info_fc' ) ) : the_row(); ?>
        <?php $best_row_layout = get_row_layout(); ?>
        <?php if ( $best_row_layout == 'best_block_title_h2' ) : ?>
            <?php $best_is_hide = get_sub_field( 'best_is_hide' ); ?>
            <?php $is_readmore = $best_is_hide ?? true; ?>
            <h2 class="title_h2 text_left <?= $best_is_hide ? 'toggler hide' : ''; ?>"><?= get_sub_field( 'best_block_title_h2' ); ?></h2>
        <?php elseif ( $best_row_layout == 'best_block_title_h3' ) : ?>
            <?php $best_is_hide = get_sub_field( 'best_is_hide' ); ?>
            <?php $is_readmore = $best_is_hide ?? true; ?>
            <h3 class="title_h2 text_left <?= $best_is_hide ? 'toggler hide' : ''; ?>"><?= get_sub_field( 'best_block_title_h3' ); ?></h3>
        <?php elseif ( $best_row_layout == 'best_block_text' ) : ?>
            <?php $best_is_hide = get_sub_field( 'best_is_hide' ); ?>
            <?php $is_readmore = $best_is_hide ?? true; ?>
            <div class="category_info_text <?= $best_is_hide ? 'toggler hide' : ''; ?>"><?= get_sub_field( 'best_block_text' ); ?></div>
        <?php elseif ( $best_row_layout == 'block_table_cols') : ?>
        <?php $quantity = get_sub_field( 'quantity' ); ?>
        <?php $content = get_sub_field( 'block_table_content_' . $quantity ); ?>
        <?php $is_hide = get_sub_field( 'is_hide' ); ?>
        <?php $is_readmore = $is_hide ?? true; ?>
        <?php $header_row = get_sub_field( 'header_row' ); ?>
        <?php if ( $content ) : ?>
        <?php $i = 1; ?>
        <?php $count = count( $content ); ?>
            <div class="content_table <?= $is_hide ? 'toggler hide' : ''; ?>">
                <?php foreach ( $content as $row ) : ?>
            <?php $is_unite = $row['is_unite']; ?>
            <?php if ( $header_row ) : ?>
                <div class="row row<?= $i == 1 ? 'header' : $i; ?>">
                    <?php else : ?>
                    <div class="row row<?= $i == $count ? 'last' : $i; ?>">
                        <?php endif; ?>
                        <?php if ( $is_unite ) : ?>
                            <div class="row_col1 row_col_last">
                                <?php for ( $j = 1; $j <= $quantity; $j++ ) : ?>
                                    <?= $row['col_' . $j] ?? $row['col_' . $j]; ?>
                                <?php endfor; ?>
                            </div>
                        <?php else : ?>
                            <?php for ( $j = 1; $j <= $quantity; $j++ ) : ?>
                                <div class="row_col<?= $j == $quantity ? '_last' : $j; ?>">
                                    <?= $row['col_' . $j]; ?>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                <?php endwhile; ?>
            </div>
            <?php if ( $is_readmore ) : ?>
                <div class="btn_more">Read More</div>
            <?php endif; ?>
            <?php endif; ?>
    </div>
</section>
<?php if ( have_rows( 'game_desc' ) ) : ?>
<section class="desc_block">
    <div class="wrapper">
        <div class="desc_wrapper">
        <?php while ( have_rows( 'game_desc' ) ) : the_row(); ?>
            <?php $img_align = get_sub_field( 'img_align' ); ?>
            <?php $fl_cont = get_sub_field( 'info_block' ); ?>
            <?php if ( $img_align == 'right' ) : ?>
                <div class="desc_item right_img">
            <?php elseif ( $img_align == 'left' ) : ?>
                <div class="desc_item left_img">
            <?php else : ?>
                <div class="desc_item">
            <?php endif; ?>
                <?php if ( have_rows( 'info_block' ) ) : ?>
                    <div class="desc_content">
                    <?php while ( have_rows( 'info_block' ) ) : the_row(); ?>
                        <?php $row_layout = get_row_layout(); ?>
                        <?php if ( $row_layout == 'block_title_h2' ) : ?>
                            <h2 class="title"><?= get_sub_field( 'block_title_h2' ); ?></h2>
                        <?php elseif ( $row_layout == 'block_title_h3' ) : ?>
                            <h3 class="title_h3"><?= get_sub_field( 'block_title_h3' ); ?></h3>
                        <?php elseif ( $row_layout == 'block_text' ) : ?>
                            <div class="block_text"><?= get_sub_field( 'block_text' ); ?></div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                    </div>
                    <?php if ( $img_align != 'none' ) : ?>
                        <img loading="lazy" src="<?= wp_get_attachment_url( get_sub_field( 'block_image' ) ); ?>" alt="">
                    <?php endif; ?>
                <?php endif; ?>
                </div>
        <?php endwhile; ?>
        </div>
        <?php $rev = get_field( 'selected_review' ); ?>
        <?php if ( $rev ) : ?>
            <div class="selected_review">
                <img loading="lazy" src="<?= get_the_post_thumbnail_url( $rev ); ?>" alt="">
                <div class="review_content">
                    <div class="first_line">
                        <span class="review_date"><?= get_the_date( 'F j, Y', $rev ); ?></span>
                        <img loading="lazy" src="<?= get_template_directory_uri() ?>/assets/img/kavychki.svg" alt="">
                    </div>
                    <div class="review_author">Author: <?= get_the_title( $rev ); ?></div>
                    <div class="review_desc"><?= get_post( $rev )->post_content; ?></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
<?php get_template_part( 'template_parts/reviews', 'block', array( 'game_id' => $game_id ) ); ?>
<?php if ( get_field( 'faq_block_title', $game_id ) ) : ?>
    <?php get_template_part( 'template_parts/faq', 'block', array( 'page_id' => $game_id ) ); ?>
<?php endif; ?>

<?php get_footer(); ?>
