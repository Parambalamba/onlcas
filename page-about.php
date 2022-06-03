<?php
    get_header();
    $term_id = get_queried_object_id();
?>
<?php get_template_part( 'template_parts/main', 'content-block', array( 'term_id' => $term_id ) ); ?>
<section class="types_block">
    <div class="wrapper">
        <div class="types_content">
            <h2 class="title_h2 text_left"><?= get_field( 'types_block_title' ); ?></h2>
            <p class="desc"><?= get_field( 'types_block_desc' ); ?></p>
            <?php if ( have_rows( 'types_block' ) ) : ?>
                <div class="types_items">
                    <?php while ( have_rows( 'types_block' ) ) : the_row(); ?>
                        <div class="item">
                            <img loading="lazy" src="<?= wp_get_attachment_url( get_sub_field( 'image' ) ); ?>" alt="">
                            <div class="right_content">
                                <h3 class="title_h3"><?= get_sub_field( 'title' ); ?></h3>
                                <span class="desc"><?= get_sub_field( 'description' ); ?></span>
                                <?php if ( get_sub_field( 'title' ) == 'Casino Software' ) : ?>
                                    <span class="link_button">Learn More</span>
                                <?php else : ?>
                                    <a href="<?= get_sub_field( 'link_to' ); ?>" class="link_button">Learn More</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="form_block">
    <div class="wrapper">
        <div class="form_content">
            <img loading="lazy" src="<?= wp_get_attachment_url( get_field( 'form_image' ) ); ?>" alt="">
            <div class="form_wrapper">
                <h2 class="title_h2 text_left"><?= get_field( 'form_title' ); ?></h2>
                <p class="desc"><?= get_field( 'form_desc' ); ?></p>
                <form class="form_question" name="form_question" method="post" novalidate>
                    <textarea placeholder="Your Message*" name="sub_message"></textarea>
                    <input type="text" class="name_input" name="sub_name" placeholder="Your Name*">
                    <input type="email" name="sub_email" placeholder="Your Email*">
                    <label for="sub_something">
                        <input type="checkbox" id="sub_something" name="sub_something" value="" checked>
                        <span>Save my name, email, and website in this browser for the next time I comment.</span>
                    </label>
                    <input type="hidden" name="action" value="send_msg_from_guest">
                    <p class="subscribe_message"></p>
                    <input type="submit" value="Send Message">
                </form>
            </div>
        </div>
    </div>
</section>
<!--<?php get_template_part( 'template_parts/news', 'block' ); ?>-->
<?php get_footer(); ?>
