<?php
get_header();
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>
<?php get_template_part( 'template_parts/main', 'content-block', array( 'term_id' => 'game_category_' . $term->term_id ) ); ?>
<?php $pg = get_field( 'popular_games', 'game_category_' . $term->term_id ); ?>
<?php if ( $pg ) : ?>
    <section class="popular_games">
        <div class="wrapper">
            <div class="popular_games_block">
                <h2 class="title_h2"><?= $pg['title']; ?></h2>
                <?php $games = $pg['games']; ?>
                <?php if ( $games ) : ?>
                    <div class="pg_items">
                    <?php foreach ( $games as $game_id ) : ?>
                        <?php $game = get_post( $game_id ); ?>
                        <div class="pg_item">
                            <a href="<?= get_field( 'referal_link', $game_id ); ?>" class="playnow_link">
                                <img loading="lazy" src="<?= wp_get_attachment_url( get_field( 'game_image', $game_id ) ); ?>" alt="">
                                <div class="pl_link">
                                    <span class="game_name"><?= $game->post_title; ?></span>
                                    <span class="play_link">Play Now</span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php get_template_part( 'template_parts/game', 'category-block', array( 'page_id' => 'game_category_' . $term->term_id ) ); ?>
        </div>
    </section>
<?php endif; ?>
    <section class="casinos_block">
        <div class="wrapper">
            <?php get_template_part( 'template_parts/casino', 'block', array( 'page_id' => $term->term_id ) ); ?>
        </div>
    </section>
    <?php $pokies = get_field( 'pokies_block', 'game_category_' . $term->term_id ); ?>
    <?php if ( $pokies ) : ?>
    <section class="pokies_block">
        <div class="wrapper">
            <div class="about_content">
                <img loading="lazy" src="<?= wp_get_attachment_url( $pokies['image'] ); ?>" alt="">
                <div class="text_block">
                    <h2 class="title_h2"><?= $pokies['title']; ?></h2>
                    <span><?= $pokies['desc']; ?></span>
                    <a href="<?= get_term_link( 6, 'game_category' ); ?>" class="about_link">Learn More</a>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php if ( get_field( 'faq_block_title', 'game_category_' . $term->term_id ) ) : ?>
        <?php get_template_part( 'template_parts/faq', 'block', array( 'page_id' => 'game_category_' . $term->term_id ) ); ?>
    <?php endif; ?>

<?php get_footer(); ?>