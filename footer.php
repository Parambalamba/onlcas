<footer>
    <div class="wrapper">
        <div class="footer_top">
            <div class="footer_1">
                <?php the_custom_logo(); ?>
                <span><?= get_field( 'footer_main_text', 'option' ); ?></span>
            </div>
            <div class="footer_2">
                <div class="footer_heading">Main Pages</div>
                <?php wp_nav_menu( array(
                    'theme_location'    => 'footer_main_pages',
                    'menu_class'        => 'footer_menu',
                ) ); ?>
            </div>
            <div class="footer_3">
                <div class="footer_heading">Casino Games</div>
                <?php wp_nav_menu( array(
                    'theme_location'    => 'footer_casino_games',
                    'menu_class'        => 'footer_menu',
                ) ); ?>
            </div>
            <div class="footer_4">
                <div class="footer_heading">Casinos</div>
                <?php wp_nav_menu( array(
                    'theme_location'    => 'footer_casinos',
                    'menu_class'        => 'footer_menu',
                ) ); ?>
            </div>
            <div class="footer_5">
                <div class="footer_heading">Subscribe</div>
                <form id="subscribers" class="subscribers" name="subscribers" method="post" novalidate>
                    <input type="email" name="email" value="" placeholder="Type Your Email" required/>
                    <input type="hidden" name="action" value="subscribe_user">
                    <input type="submit" name="footer_send" value="">
                </form>
                <p class="subscribe_message"></p>
                <?php get_template_part( 'template_parts/social', 'links-block' ); ?>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="wrapper">
            <div class="rights">Copyright © 2020-2022 OnlineAusCasino. All rights reserved.</div>
            <div class="addon_links">
                <span>Terms and Conditions</span>
                <span>Privacy Policy</span>
                <span>Sitemap</span>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

