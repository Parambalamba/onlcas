<?php get_header(); ?>
<?php
    if ( in_category( 'news' ) ) {
        include(get_template_directory() . '/single-news.php');
    }
?>
<?php get_footer(); ?>
