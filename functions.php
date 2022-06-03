<?php
//Menu function activation
add_theme_support( 'menus' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'custom-logo' );
add_action( 'after_setup_theme', function() {
    register_nav_menus( [
        'main_menu'             => 'Main menu',
        'footer_main_pages'     => 'Footer Main Pages',
        'footer_casino_games'   => 'Footer Casino Games',
        'footer_casinos'        => 'Footer Casinos'
    ] );
} );


//Remove Gutenberg CSS library
function dm_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'dm_remove_wp_block_library_css' );

//jQuery integrate
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
function my_scripts_method() {
    //wp_enqueue_style( 'css-style', get_stylesheet_uri() );
    if ( is_front_page() || is_404() )
        wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/main.css' );
    elseif ( is_tax( 'casino_type' ) ) {
        wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/main.css' );
        wp_enqueue_style( 'casino-type', get_template_directory_uri() . '/assets/css/casino-type.css' );
    } elseif ( is_tax( 'game_category' ) ) {
        wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/main.css' );
        wp_enqueue_style( 'casino-games', get_template_directory_uri() . '/assets/css/casino-games.css' );
        wp_enqueue_style( 'game-category', get_template_directory_uri() . '/assets/css/game-category.css' );
    } elseif ( is_post_type_archive( 'bonus' ) || is_tax( 'bonus_category' ) ) {
        wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/main.css' );
        wp_enqueue_style( 'bonuses', get_template_directory_uri() . '/assets/css/bonuses.css' );
    } elseif ( is_category( 'news' )  || is_singular( 'post' ) ) {
        wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/main.css' );
        wp_enqueue_style( 'news', get_template_directory_uri() . '/assets/css/news.css' );
    } elseif ( is_page() ) {
        wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/main.css' );
        wp_enqueue_style( 'pages', get_template_directory_uri() . '/assets/css/pages.css' );
    } elseif ( is_singular( 'game' ) ) {
        wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/main.css' );
        wp_enqueue_style( 'game', get_template_directory_uri() . '/assets/css/game.css' );
    }

    wp_enqueue_style('slick-style', get_template_directory_uri() . '/assets/js/slick/slick.css');
    wp_enqueue_style('slick-theme-style', get_template_directory_uri() . '/assets/js/slick/slick-theme.css');
    wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/slick/slick.min.js', array( 'jquery' ), null, true );

    wp_deregister_script( 'jquery-core' );
    wp_deregister_script( 'jquery' );

    wp_register_script( 'jquery-core', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', false, null, true );
    wp_register_script( 'jquery', false, array('jquery-core'), null, true );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script("jquery-ui-core", array('jquery'), null, true );
    wp_enqueue_script( 'jquery-core', false, null, true );

    wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.min.js', array( 'jquery' ), null, true );
    wp_localize_script( 'main', 'mySite', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));

};

//Add SVG Support
add_filter( 'upload_mimes', 'svg_upload_allow' );
function svg_upload_allow( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    return $mimes;
}

add_filter( 'wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5 );
function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){
    // WP 5.1 +
    if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) )
        $dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
    else
        $dosvg = ( '.svg' === strtolower( substr($filename, -4) ) );
    if( $dosvg ){
        if( current_user_can('manage_options') ){
            $data['ext']  = 'svg';
            $data['type'] = 'image/svg+xml';
        } else {
            $data['ext'] = $type_and_ext['type'] = false;
        }
    }
    return $data;
}

/**
 * Connect to fonts googleapis
 */
//add_action('wp_enqueue_scripts', 'auscasino_google_fonts');
add_action( 'get_footer', 'auscasino_google_fonts' );
function auscasino_google_fonts() {
    if ( !is_admin() ) {
        wp_register_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap', array(), null, 'all' );
        wp_enqueue_style( 'google-fonts');
    }
}

/**
 * Theme options page create
 * Medals
 */
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page( array(
        'page_title' 	=> 'Theme Options',
        'menu_title'	=> 'Theme Options',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'manage_options',
        'redirect'		=> false
    ) );

    acf_add_options_sub_page( array(
        'page_title' 	=> 'Medals',
        'menu_title'	=> 'Medals',
        'parent_slug'	=> 'theme-general-settings',
    ) );

    acf_add_options_sub_page( array(
        'page_title' 	=> 'Bonus Archive Page',
        'menu_title'	=> 'Bonus Archive Page',
        'parent_slug'	=> 'theme-general-settings',

    ) );
}

/**
 * Dynamically choices for Select Field Medal
 */
function acf_load_medal_field_choices( $field ) {

    // reset choices
    $field['choices'] = array();


    // if has rows
    if( have_rows('medals_type', 'option') ) {
        // while has rows
        while( have_rows('medals_type', 'option') ) {
            // instantiate row
            the_row();

            // vars
            $value = get_sub_field( 'title' );
            $label = get_sub_field( 'title' );


            // append to choices
            $field['choices'][$value] = $label;

        }

    }
    // return the field
    return $field;
}
add_filter('acf/load_field/name=medal', 'acf_load_medal_field_choices');

/**
 * Get Medal Image by its title from option page Medals
 */
function get_medal_image( $medal_type ) {
    reset_rows( 'medals_type', 'option' );
    while ( have_rows( 'medals_type', 'option' ) ) {
        the_row();
        if ( get_sub_field( 'title' ) == $medal_type ) {
            // will get here if this is our row
            $medal_image_id = get_sub_field( 'medal_image' );
            $medal_image = wp_get_attachment_url( $medal_image_id );
            return $medal_image;
        }
    }
    return null;
}

/**
 * Custom Post Type for Subscribers
 */
add_action( 'init', 'register_subscriber_post_type' );
function register_subscriber_post_type() {
    register_post_type('subscriber', [
        'label' => 'Subscribers',
        'labels' => array(
            'name' => 'Subscribers',
            'singular_name' => 'Subscriber',
            'menu_name' => "Subscribers",
            'all_items' => 'All Subscribers',
            'add_new' => 'Add Subscriber',
            'add_new_item' => 'Add New Subscriber',
            'edit' => 'Edit',
            'edit_item' => 'Edit Subscriber',
            'new_item' => 'New Subscriber',
        ),
        'description' => "Collect Subscriber's emails",
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_rest' => false,
        'rest_base' => '',
        'show_in_menu' => true,
        'exclude_from_search' => false,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        //'rewrite' => array('slug' => '', 'with_front' => true),
        'has_archive' => false,
        'query_var' => true,
        'supports' => array('title'),
    ]);
}

/**
 * Adding column for All Subscribers
 */
// создаем новую колонку
add_filter( 'manage_'.'subscriber'.'_posts_columns', 'add_surname_column', 4 );
function add_surname_column( $columns ){
    $num = 2; // после какой по счету колонки вставлять новые

    $new_columns = array(
        'names' => 'Names',
    );

    return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}

// заполняем колонку данными
// wp-admin/includes/class-wp-posts-list-table.php
add_action('manage_'.'subscriber'.'_posts_custom_column', 'fill_surname_column', 5, 2 );
function fill_surname_column( $colname, $post_id ){
    if( $colname === 'names' ){
        echo get_post_meta( $post_id, 'names', 1 );
    }
}

/**
 * Save subscribers to All Subcribers
 */
if (wp_doing_ajax()) {
    add_action('wp_ajax_subscribe_user', 'subscribe_user');
    add_action('wp_ajax_nopriv_subscribe_user', 'subscribe_user');
    function subscribe_user() {
        $email = $_POST['email'];
        $posts = get_posts( array(
            'numberposts'    => -1,
            'post_type'         => 'subscriber',
            'fields'            => 'title'
        ) );
        if ( $posts ) {
            foreach ( $posts as $post ) {
                if ( $email == $post->post_title ) {
                    echo json_encode(array(
                        'result' => 'exists',
                        'email' => $email
                    ));
                    wp_die();
                }
            }
        }
        $name = $_POST['name'];
        $post_data = array(
            'post_title'    => $email,
            'post_type'     => 'subscriber',
            'post_status'   => 'publish'
        );
        $post_id = wp_insert_post( wp_slash( $post_data ), true );
        if ( is_wp_error( $post_id ) ) {
            echo json_encode( array(
                'result'    => $post_id->get_error_message()
            ) );
        } else {
            if ( $name )
                update_field( 'name', $name, $post_id );
            echo json_encode( array(
                'result'    => 'success',
            ) );
        }
        wp_die();
    }

    /**
     * Send message from Contact Form
     */
    add_action('wp_ajax_nopriv_send_msg_from_guest', 'send_msg_from_guest');
    add_action('wp_ajax_send_msg_from_guest', 'send_msg_from_guest');
    function send_msg_from_guest() {
        $name = $_POST['sub_name'];
        $email = $_POST['sub_email'];
        $msg = $_POST['sub_message'];
        $to = get_field( 'contact_email', 'option' );
        $subject = 'Letter from Onlineauscasino.com';
        $headers  = "Content-type: text/html; \r\n";
        $headers .= 'From: ' . $name . ' <' . $email . '>' . "\r\n";
        $msg = 'Name: ' . $name . '<br>From: ' . $email . '<br>Message: ' . $msg;
        $status = mail($to, $subject, $msg, $headers);
        if ( $status )
            echo json_encode( array( 'result' => 'success', 'status' => $status ) );
        else
            echo json_encode( array( 'result' => 'failure', 'status' => $status ) );
        wp_die();
    }
}

/**
 * Customized separator for yoast breadcrumbs
 */
add_filter( 'wpseo_breadcrumb_separator', function( $separator ) {
    return '</span><span class="bread_separator"></span>';
} );

/**
 * Adding custom rule Taxonomy Term for acf fields
 */
add_filter('acf/location/rule_types', 'acf_location_rules_types');

function acf_location_rules_types( $choices ) {

    $choices['Forms']['taxonomy_term'] = 'Taxonomy Term';
    $choices['Forms']['category_id'] = 'Category';

    return $choices;

}

/**
 * Adding Taxonomy Term to acf rules
 */
add_filter('acf/location/rule_values/taxonomy_term', 'acf_location_rule_values_taxonomy_term');
function acf_location_rule_values_taxonomy_term( $choices ) {
    $terms = get_terms( array(
                'taxonomy'      => array( 'game_category', 'casino_type', 'bonus_category' ),
                'hide_empty'    => false
    ) );

    if( $terms ) {
        foreach( $terms as $term ) {
            $choices[ $term->term_id ] = $term->name;
        }
    }
    return $choices;
}

add_filter('acf/location/rule_match/taxonomy_term', 'acf_location_rule_match_taxonomy_term', 10, 4);
function acf_location_rule_match_taxonomy_term( $match, $rule, $options, $field_group ) {

    $term_id       = $_GET['tag_ID'];
    $selected_term = $rule['value'];

    if ( $rule['operator'] == '==' ) {
        $match = ( $selected_term == $term_id );
    } elseif ( $rule['operator'] == '!=' ) {
        $match = ( $selected_term != $term_id );
    }

    return $match;

}

/**
 * Adding Category to rules of acf fields
 */
add_filter( 'acf/location/rule_values/category_id', 'acf_location_rules_values_category' );
function acf_location_rules_values_category( $choices ) {
    $terms = get_terms( 'category', [ 'hide_empty' => false ] );

    if ( $terms && is_array( $terms ) ) {
        foreach ( $terms as $term ) {
            $choices[ $term->term_id ] = $term->name;
        }
    }

    return $choices;
}

add_filter( 'acf/location/rule_match/category_id', 'acf_location_rules_match_category', 10, 3 );
function acf_location_rules_match_category( $match, $rule, $options ) {

    $term_id       = $_GET['tag_ID'];
    $selected_term = $rule['value'];

    if ( $rule['operator'] == '==' ) {
        $match = ( $selected_term == $term_id );
    } elseif ( $rule['operator'] == '!=' ) {
        $match = ( $selected_term != $term_id );
    }

    return $match;
}

/**
 * Ajax loading posts of type Game, News and Casino Bonus
 */
if ( wp_doing_ajax() ) {
    add_action( 'wp_ajax_loadmore', 'load_posts' );
    add_action( 'wp_ajax_nopriv_loadmore', 'load_posts' );
    function load_posts()
    {
        $args = unserialize( stripslashes( $_POST['query'] ) );
        $args['paged'] = $_POST['page'] + 1; // следующая страница

        query_posts( $args );
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();

                if ( $_POST['tpl'] === 'game' ) {
                    get_template_part( 'template_parts/loop', 'game' );
                }
                if ( $_POST['tpl'] === 'news' ) {
                    get_template_part( 'template_parts/loop', 'news' );
                }
                if ( $_POST['tpl'] === 'bonuses' ) {
                    get_template_part( 'template_parts/loop', 'bonus', array( 'bonus_id' => get_the_ID() ) );
                }
            }
            die();
        }
    }

    /**
     * Modal window for Bonus details
     */
    add_action('wp_ajax_nopriv_bonus_details', 'bonus_details');
    add_action('wp_ajax_bonus_details', 'bonus_details');
    function bonus_details()
    {
        $bonus_id = $_POST['bonus'];
        include_once('template_parts/bonus-modal.php');
        wp_die();
    }
}

// Подсчет количества посещений страниц
add_action( 'wp_head', 'kama_postviews' );

/**
 * @param array $args
 * Calculate views of posts
 * @return null
 */
function kama_postviews( $args = [] ){
    global $user_ID, $post, $wpdb;

    if( ! $post || ! is_singular() )
        return;

    $rg = (object) wp_parse_args( $args, [
        // Ключ мета поля поста, куда будет записываться количество просмотров.
        'meta_key' => 'views',
        // Чьи посещения считать? 0 - Всех. 1 - Только гостей. 2 - Только зарегистрированных пользователей.
        'who_count' => 1,
        // Исключить ботов, роботов? 0 - нет, пусть тоже считаются. 1 - да, исключить из подсчета.
        'exclude_bots' => true,
    ] );

    $do_count = false;
    switch( $rg->who_count ){

        case 0:
            $do_count = true;
            break;
        case 1:
            if( ! $user_ID )
                $do_count = true;
            break;
        case 2:
            if( $user_ID )
                $do_count = true;
            break;
    }

    if( $do_count && $rg->exclude_bots ){

        $notbot = 'Mozilla|Opera'; // Chrome|Safari|Firefox|Netscape - все равны Mozilla
        $bot = 'Bot/|robot|Slurp/|yahoo';
        if(
            ! preg_match( "/$notbot/i", $_SERVER['HTTP_USER_AGENT'] ) ||
            preg_match( "~$bot~i", $_SERVER['HTTP_USER_AGENT'] )
        ){
            $do_count = false;
        }

    }

    if( $do_count ){

        $up = $wpdb->query( $wpdb->prepare(
            "UPDATE $wpdb->postmeta SET meta_value = (meta_value+1) WHERE post_id = %d AND meta_key = %s", $post->ID, $rg->meta_key
        ) );

        if( ! $up )
            add_post_meta( $post->ID, $rg->meta_key, 1, true );

        wp_cache_delete( $post->ID, 'post_meta' );
    }

}

// создаем новую колонку
add_filter( 'manage_'.'post'.'_posts_columns', 'add_views_column', 4 );
function add_views_column( $columns ){
    $num = 2; // после какой по счету колонки вставлять новые

    $new_columns = array(
        'views' => 'Visits',
    );

    return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}

// заполняем колонку данными
// wp-admin/includes/class-wp-posts-list-table.php
add_action('manage_'.'post'.'_posts_custom_column', 'fill_views_column', 5, 2 );
function fill_views_column( $colname, $post_id ){
    if( $colname === 'views' ){
        echo get_post_meta( $post_id, 'views', 1 );
    }
}

/**
 * Change main query at bonus archive page
 * Set posts_per_page
 */
add_action( 'pre_get_posts', 'change_quantity' );
function change_quantity( $query ){

    if( ( $query->is_main_query() && is_post_type_archive( 'bonus' ) ) || ( $query->is_main_query() && is_tax( 'bonus_category' ) ) ) {
        $query->set( 'posts_per_page', '10' );
    }
}

/**
 * Change breadcrumb title for bonus archive page
 */
add_filter( 'wpseo_breadcrumb_single_link' ,'wpseo_change_breadcrumb_link', 10 ,2);
function wpseo_change_breadcrumb_link( $link_output , $link ){
    $text_to_change = 'Casino Bonus';
    if ( is_post_type_archive( 'bonus' ) ) {
        if ($link['text'] == $text_to_change) {
            $link_output = '<span class="breadcrumb_last" aria-current="page">Bonuses</span></span>';
        }
    }

    return $link_output;
}

/**
 * Adding to breadcrumb bonus categories page link to bonus archive page
 */
add_filter( 'wpseo_breadcrumb_links', 'wpseo_breadcrumb_add_bonus_cat_link' );
function wpseo_breadcrumb_add_bonus_cat_link( $links ) {
    global $post;
    if ( is_tax( 'bonus_category' ) ) {
        $breadcrumb[] = array(
            'url' => get_post_type_archive_link( 'bonus' ),
            'text' => 'Bonuses',
        );
        array_splice( $links, 1, -2, $breadcrumb );
    }
    return $links;
}

/**
 * Remove type=javascript from scripts
 */
add_action( 'template_redirect', function(){
    ob_start( function( $buffer ){
        $buffer = str_replace( array( ' type="text/javascript"', " type='text/javascript'" ), '', $buffer );
        $buffer = str_replace( array( ' type="text/css"', " type='text/css'" ), '', $buffer );
        return $buffer;
    });
});

/**
 * Adding manifest json for favicons
 */
add_action( 'wp_head', 'inc_manifest_link' );
function inc_manifest_link() {
    echo '<link rel="manifest" href="'.get_template_directory_uri().'/manifest.json" crossorigin="use-credentials">';
}

/**
 * Dynamically choices for Select Field Medal
 */
function acf_load_referal_link_field_choices( $field ) {

    // reset choices
    $field['choices'] = array();

    $args = array(
      'numberposts'     => -1,
      'post_type'       => 'thirstylink'
    );
    $posts = get_posts( $args );
    if ( $posts ) {
        foreach ( $posts as $post ) {
            $label = $post->post_title;
            $value = get_permalink( $post->ID ) ;
            $field['choices'][$value] = $label;
        }
    }
    // return the field
    return $field;
}
add_filter('acf/load_field/name=referal_link', 'acf_load_referal_link_field_choices');

// Изменение canonical (страницы с плагина)
add_filter( 'wpseo_canonical', 'new_canonical_filter', 10, 1 );
function new_canonical_filter( $new_canonical ) {
    $new_canonical = ''; // Тут новое значение canonical
    if ( is_post_type_archive( 'bonus' ) )
        return site_url() . '/casino-bonuses/';
}

add_filter( 'wp_img_tag_add_loading_attr', 'lazy', $image, $context );

/**
 * CSS class for for filling stars in Game Rating
 */
function get_rating_class() {
    $game_rating = (int)get_field( 'game_rating', get_the_ID() );
    $rating_class = 'rating_block_0';
    if ($game_rating >= 10 && $game_rating < 20)
        $rating_class = 'rating_block_0_5';
    elseif ($game_rating >= 20 && $game_rating < 30)
        $rating_class = 'rating_block_1';
    elseif ($game_rating >= 30 && $game_rating < 40)
        $rating_class = 'rating_block_1_5';
    elseif ($game_rating >= 40 && $game_rating < 50)
        $rating_class = 'rating_block_2';
    elseif ($game_rating >= 50 && $game_rating < 60)
        $rating_class = 'rating_block_2_5';
    elseif ($game_rating >= 60 && $game_rating < 70)
        $rating_class = 'rating_block_3';
    elseif ($game_rating >= 70 && $game_rating < 80)
        $rating_class = 'rating_block_3_5';
    elseif ($game_rating >= 80 && $game_rating < 90)
        $rating_class = 'rating_block_4';
    elseif ($game_rating >= 90 && $game_rating < 100)
        $rating_class = 'rating_block_4_5';
    elseif ($game_rating >= 100)
        $rating_class = 'rating_block_5';
    return $rating_class;
}

?>
