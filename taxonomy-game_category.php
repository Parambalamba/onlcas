<?php
	get_header();
    $tax = get_query_var('taxonomy' );
    $t = get_query_var('term' );

	$term = get_term_by( 'slug', $t, $tax );
?>
    <?php get_template_part( 'template_parts/main', 'content-block', array( 'term_id' => 'game_category_' . $term->term_id ) ); ?>
	<section class="casinos_block">
		<div class="wrapper">
			<?php get_template_part( 'template_parts/casino', 'block', array( 'page_id' => $term->term_id ) ); ?>

            <?php if ( have_rows( 'best_casinos_info_fc', 'game_category_' . $term->term_id ) ) : ?>
                <?php $is_readmore = false; ?>
                <div class="category_info_block">
                    <?php while ( have_rows( 'best_casinos_info_fc', 'game_category_' . $term->term_id ) ) : the_row(); ?>
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
    <section class="games_block">
        <div class="wrapper">
            <div class="games_content">
                <h2 class="title_h2"><?= get_field( 'games_block_title', 'game_category_' . $term->term_id ); ?></h2>
                <p class="desc"><?= the_field( 'games_block_description', 'game_category_' . $term->term_id ); ?></p>
                <?php
                $loop = new WP_Query( array(
                    'tax_query' => array(
                        array(
                            'terms' => $t,
                            'taxonomy' => $tax,
                            'field' => 'slug',
                            'posts_per_page' => 10
                        )
                    )
                )); ?>
                <?php if ( $loop->have_posts() ) : ?>
                    <div class="games_items">
                    <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                        <?php get_template_part( 'template_parts/loop', 'game' ); ?>
                    <?php endwhile; ?>
                    </div>
                <?php endif; ?>
                <?php if ( $loop->max_num_pages > 1 ) { ?>
                    <div class="btn-loadmore" title="Load More"
                         data-param-posts='<?= serialize($loop->query_vars); ?>'
                         data-max-pages='<?= $loop->max_num_pages; ?>'
                         data-tpl='game'>More games</div>
                <?php } ?>
            </div>
            <?php if ( have_rows( 'category_info_fc', 'game_category_' . $term->term_id ) ) : ?>
                <?php $is_readmore = false; ?>
                <div class="category_info_block">
                    <?php while ( have_rows( 'category_info_fc', 'game_category_' . $term->term_id ) ) : the_row(); ?>
                        <?php $row_layout = get_row_layout(); ?>
                        <?php if ( $row_layout == 'block_title_h2' ) : ?>
                            <?php $is_hide = get_sub_field( 'is_hide' ); ?>
                            <?php $is_readmore = $is_hide ?? true; ?>
                            <h2 class="title_h2 <?= $is_hide ? 'toggler hide' : ''; ?>"><?= get_sub_field( 'block_title_h2' ); ?></h2>
                        <?php elseif ( $row_layout == 'block_title_h3' ) : ?>
                            <?php $is_hide = get_sub_field( 'is_hide' ); ?>
                            <?php $is_readmore = $is_hide ?? true; ?>
                            <h3 class="title_h2 <?= $is_hide ? 'toggler hide' : ''; ?>"><?= get_sub_field( 'block_title_h3' ); ?></h3>
                        <?php elseif ( $row_layout == 'block_text' ) : ?>
                            <?php $is_hide = get_sub_field( 'is_hide' ); ?>
                            <?php $is_readmore = $is_hide ?? true; ?>
                            <div class="category_info_text <?= $is_hide ? 'toggler hide' : ''; ?>"><?= get_sub_field( 'block_text' ); ?></div>
                        <?php elseif ( $row_layout == 'block_table_cols') : ?>
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
                                                    <?= $row['col_' . $j] ?? esc_html($row['col_' . $j]); ?>
                                                <?php endfor; ?>
                                            </div>
                                        <?php else : ?>
                                            <?php for ( $j = 1; $j <= $quantity; $j++ ) : ?>
                                                <div class="row_col<?= $j == $quantity ? '_last' : $j; ?>">
                                                    <?= esc_html($row['col_' . $j]); ?>
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
    <?php if ( get_field( 'casino_reviews_block_-_title', 'game_category_' . $term->term_id ) ) : ?>
        <?php get_template_part( 'template_parts/casino', 'review-block', array( 'page_id' => $term->term_id ) ); ?>
    <?php endif; ?>

    <?php if ( get_field( 'slider_title', 'game_category_' . $term->term_id ) ) : ?>
        <?php get_template_part( 'template_parts/slider', 'block', array( 'page_id' => 'game_category_ ' . $term->term_id ) ); ?>
    <?php endif; ?>

    <?php if ( get_field( 'left_title', 'game_category_' . $term->term_id ) ) : ?>
        <?php get_template_part( 'template_parts/image', 'text-block', array( 'page_id' => 'game_category_ ' . $term->term_id ) ); ?>
    <?php endif; ?>

    <?php if ( get_field( 'faq_block_title', 'game_category_' . $term->term_id ) ) : ?>
        <?php get_template_part( 'template_parts/faq', 'block', array( 'page_id' => 'game_category_' . $term->term_id ) ); ?>
    <?php endif; ?>

<?php get_footer(); ?>