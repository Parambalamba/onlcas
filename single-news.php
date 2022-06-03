<?php
    $cat = get_the_category();
    $cat_id = $cat ? $cat[0]->term_id : null;
?>
<div class="news_content_section">
    <main>
        <div class="wrapper">
            <h1><?php the_title(); ?></h1>
            <div class="content_body">
                <div class="news_body">
                    <?php the_post_thumbnail(); ?>
                    <?php the_content(); ?>
                    <?php if ( have_rows( 'single_news_fc' ) ) : ?>
                        <?php while ( have_rows( 'single_news_fc' ) ) : the_row(); ?>
                            <?php $rl = get_row_layout(); ?>
                            <?php if ( $rl == 'block_image' ) : ?>
                                <img loading="lazy" src="<?= wp_get_attachment_url( get_sub_field( 'block_image' ) ); ?>" alt="">
                            <?php elseif ( $rl == 'block_text' ) : ?>
                                <div class="exp_content"><?= get_sub_field( 'block_text' ); ?></div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <div class="news_sidebar">
                    <?php get_template_part( 'template_parts/popular', 'casinos' ); ?>
                    <?php get_template_part( 'template_parts/popular', 'news' ); ?>
                </div>
            </div>
        </div>
    </main>
</div>
<?php get_template_part( 'template_parts/news', 'block', array( 'cat_id' => $cat_id ) ); ?>
