<?php
    get_header();
    $category_id = get_queried_object_id();
?>
<?php get_template_part( 'template_parts/main', 'content-block', array( 'term_id' => 'category_' . $category_id ) ); ?>
<?php get_template_part( 'template_parts/bonuses', 'block', array( 'page_id' => 'category_' . $category_id ) ); ?>
<section class="news_block">
    <div class="wrapper">
        <div class="news_content">
            <h2 class="title_h2"><?= get_field( 'news_block_title', 'category_' . $category_id ); ?></h2>
            <p class="desc"><?= get_field( 'news_block_desc', 'category_' . $category_id ); ?></p>
            <?php
                $loop = new WP_Query( array(
                    'cat'               => $category_id,
                    'posts_per_page'    => 8,
                    'order'             => 'DESC'
                ) );
            ?>
            <?php if ( $loop->have_posts() ) : ?>
                <div class="news_items">
                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <?php get_template_part( 'template_parts/loop', 'news' ); ?>
                <?php endwhile; ?>
                </div>
            <?php endif; ?>
            <?php if ( $loop->max_num_pages > 1 ) { ?>
                <div class="btn-loadmore" title="Load More"
                     data-param-posts='<?= serialize($loop->query_vars); ?>'
                     data-max-pages='<?= $loop->max_num_pages; ?>'
                     data-tpl='news'>More News</div>
            <?php } ?>
        </div>
        <div class="news_content_bottom">
            <?php if ( get_field( 'news_block_bottom_title', 'category_' . $category_id ) ) : ?>
                <h2 class="title_h2 text_left"><?= get_field( 'news_block_bottom_title', 'category_' . $category_id ); ?></h2>
            <?php endif; ?>
            <?php if( get_field( 'news_block_bottom_text', 'category_' . $category_id ) ) :  ?>
                <div class="text_left"><?= get_field( 'news_block_bottom_text', 'category_' . $category_id ); ?></div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>
