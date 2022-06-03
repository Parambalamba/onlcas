<?php get_header(); ?>
<?php
    global $wp_query;
    $mnp = $wp_query->max_num_pages;
    $terms = get_terms( array(
        'taxonomy'      => 'bonus_category',
        'hide_empty'    => false,
        'order'         => 'DESC'
    ) );
?>
<?php get_template_part( 'template_parts/main', 'content-block', array( 'term_id' => 'option' ) ); ?>
<?php get_template_part( 'template_parts/bonuses', 'block', array( 'page_id' => 'option' ) ); ?>
<section class="bonus_cats">
    <div class="wrapper">
        <div class="bonus_cats_content">
            <h2 class="title_h2"><?= get_field( 'bonus_categories_title', 'option' ); ?></h2>
            <?php if ( get_field( 'bonus_categories_description', 'option' ) ) : ?>
                <p class="desc"><?php the_field( 'bonus_categories_description', 'option' ); ?></p>
            <?php endif; ?>
            <?php if ( $terms ) : ?>
                <div class="items">
                    <?php foreach ( $terms as $term ) : ?>
                        <div class="item">
                            <img loading="lazy" src="<?= wp_get_attachment_url( get_field( 'bonus_cats_icon', 'bonus_category_' . $term->term_id ) ); ?>" alt="">
                            <h3 class="title_h3"><?= $term->name; ?></h3>
                            <div class="desc"><?= $term->description; ?></div>
                            <a href="<?= get_term_link( $term, 'bonus_category' ); ?>" class="bcat_link">Learn More</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="all_bonuses_block">
    <div class="wrapper">
        <div class="all_bonuses_content">
            <h2 class="title_h2"><?= get_field( 'bonus_block_title', 'option' ); ?></h2>
            <p class="desc"><?= get_field( 'bonus_block_desc', 'option' ); ?></p>
            <?php if (have_posts() ) : ?>
                <?php $i = 1; ?>
                <div class="items">
                    <div class="bonus_modal"></div>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php
                            $bonus_id = get_the_ID();
                            get_template_part( 'template_parts/loop', 'bonus', array( 'bonus_id' => $bonus_id, 'increm' => $i ) );
                            $i++;
                        ?>
                    <?php endwhile; ?>
                </div>
                <?php if ( (int) $mnp > 1 ) { ?>
                    <div class="btn-loadmore" title="Load More"
                         data-param-posts='<?= serialize($wp_query->query_vars); ?>'
                         data-max-pages='<?= $mnp; ?>'
                         data-tpl='bonuses'>More Bonuses</div>
                <?php } ?>
            <?php endif; ?>
        </div>
        <?php if ( have_rows( 'bonus_block_fc', 'option' ) ) : ?>
            <div class="bonus_info_block">
            <?php while ( have_rows( 'bonus_block_fc', 'option' ) ) : the_row(); ?>
                <?php $row_layout = get_row_layout(); ?>
                <?php if ( $row_layout == 'block_title_h2' ) : ?>
                    <h2 class="title_h2 text_left"><?= get_sub_field( 'block_title_h2' ); ?></h2>
                <?php elseif ( $row_layout == 'block_title_h3' ) : ?>
                    <h3 class="title_h2 text_left"><?= get_sub_field( 'block_title_h3' ); ?></h3>
                <?php elseif ( $row_layout == 'block_text' ) : ?>
                    <div class="bonus_info_text"><?= get_sub_field( 'block_text' ); ?></div>
                <?php endif; ?>
            <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php if ( get_field( 'faq_block_title', 'option' ) ) : ?>
    <?php get_template_part( 'template_parts/faq', 'block', array( 'page_id' => 'option' ) ); ?>
<?php endif; ?>

<?php get_footer(); ?>
