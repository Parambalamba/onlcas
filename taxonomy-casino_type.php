<?php
	get_header();
	$term_id = get_queried_object_id();
?>

<?= get_field( 'seo_text', 'casino_type_' . $term_id ); ?>

<?php get_template_part( 'template_parts/main', 'content-block', array( 'term_id' => 'casino_type_' . $term_id ) ); ?>

<section class="info_content pb_0">
    <div class="wrapper">
        <?php get_template_part( 'template_parts/casino', 'block', array( 'page_id' => $term_id ) ); ?>

        <?php if ( get_field( 'benefits_-_title', 'casino_type_' . $term_id ) ) : ?>
            <?php get_template_part( 'template_parts/benefits', 'block', array( 'page_id' => $term_id ) ); ?>
        <?php endif; ?>

    </div>
    <div class="games_block_white_wrapper">
        <div class="wrapper">
            <?php get_template_part( 'template_parts/game', 'category-block', array('page_id' => 'casino_type_' .$term_id )); ?>
        </div>
    </div>
</section>

<?php if ( get_field( 'casino_reviews_block_-_title', 'casino_type_' . $term_id ) ) : ?>
<?php get_template_part( 'template_parts/casino', 'review-block', array( 'page_id' => $term_id ) ); ?>
<?php endif; ?>

<?php if ( get_field( 'casino_bonuses_-_text_block_-_title', 'casino_type_' . $term_id ) ) : ?>
    <?php get_template_part( 'template_parts/casino', 'bonuses-text', array( 'page_id' => $term_id ) ); ?>
<?php endif; ?>

<?php if ( get_field( 'faq_block_title', 'casino_type_' . $term_id ) ) : ?>
    <?php get_template_part( 'template_parts/faq', 'block', array( 'page_id' => 'casino_type_' .$term_id ) ); ?>
<?php endif; ?>

<?php get_footer(); ?>