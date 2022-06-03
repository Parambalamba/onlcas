<?php
    get_header();
    $term_id = get_queried_object_id();
    global $wp_query;
    $mnp = $wp_query->max_num_pages;
?>
<?php get_template_part( 'template_parts/main', 'content-block', array( 'term_id' => 'bonus_category_' . $term_id ) ); ?>
<section class="bonus_category_block">
    <div class="wrapper">
        <div class="bonus_category_content">
            <h2 class="title_h2"><?= get_field( 'bonus_block_title', 'bonus_category_' . $term_id ); ?></h2>
            <p class="desc"><?= get_field( 'bonus_block_desc', 'bonus_category_' . $term_id ); ?></p>
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
        <?php if ( have_rows( 'bonus_block_fc', 'bonus_category_' . $term_id ) ) : ?>
            <div class="bonus_info_block">
                <?php while ( have_rows( 'bonus_block_fc', 'bonus_category_' . $term_id ) ) : the_row(); ?>
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
<?php if ( get_field( 'faq_block_title', 'bonus_category_' . $term_id ) ) : ?>
    <?php get_template_part( 'template_parts/faq', 'block', array( 'page_id' => 'bonus_category_' . $term_id ) ); ?>
<?php endif; ?>
<?php get_footer(); ?>
