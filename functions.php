<?php

//Theme Initialisation

add_action( 'after_setup_theme', 'bootstrap_setup' );

function bootstrap_setup() {

    //menus
    register_nav_menu( 'main', __( 'Main Menu', 'bootstrap' ) );
    register_nav_menu( 'footer', __( 'Footer Menu', 'bootstrap' ) );

    //features
    add_theme_support( 'post-thumbnails' );

    //sidebars
    register_sidebar( array(
        'name' => __( 'Main Sidebar', 'bootstrap' ),
        'id' => 'sidebar-main',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );


}

//Menu Customisation

add_filter( 'wp_page_menu_args', 'bootstrap_page_menu_args' );
add_filter('wp_page_menu','bootstrap_page_menu_remove_container');
add_filter('wp_page_menu','bootstrap_page_menu_clear_classes');
add_filter('wp_nav_menu','bootstrap_page_menu_clear_classes');
add_filter('nav_menu_css_class', 'bootstrap_menu_add_active_class');
add_filter('nav_menu_item_id', 'bootstrap_menu_add_active_class');
add_filter('page_css_class', 'bootstrap_menu_add_active_class');

function bootstrap_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}

function bootstrap_page_menu_remove_container($text) {
    $replace = array(
        // List of classes to replace with "active"
        'current_page_item' => 'active',
        'current_page_parent' => 'active',
        'current_page_ancestor' => 'active',
    );
    $text = str_replace(array_keys($replace), $replace, $text);

    return preg_replace('#\<div(.*?)\>\<ul\>(.*?)\<\/ul\>\<\/div\>#si', "<ul$1>$2</ul>", $text, 1);
}

function bootstrap_page_menu_clear_classes($text) {
    $replace = array(
        // List of classes to replace with "active"
        'current_page_item' => 'active',
        'current_page_parent' => 'active',
        'current_page_ancestor' => 'active',
    );
    $text = str_replace(array_keys($replace), $replace, $text);
    return $text;
}

function bootstrap_menu_add_active_class($var) {
    return is_array($var) ? array_intersect($var, array(
        // List of useful classes to keep
        'current_page_item',
        'current_page_parent',
        'current_page_ancestor'
        )
    ) : '';
}


//Custom Functions

function bootstrap_posted_on() {
    printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'bootstrap' ),
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', 'bootstrap' ), get_the_author() ) ),
        get_the_author()
    );
}


