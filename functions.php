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

// Widgets

add_action( 'widgets_init', 'bootstrap_register_widgets' );  

function bootstrap_register_widgets() {  
    register_widget('TDC_Twitter');
}  

class TDC_Twitter extends WP_Widget {
    function TDC_Twitter() {
        //parent::WP_Widget(false, 'Latest Tweets (The Design Collective)');
        $widget_ops = array( 'classname' => 'twitter', 'description' => __('A widget that displays tweets for a twitter username.', 'bootstrap') );  
        $control_ops = array( 'id_base' => 'twitter-widget' );  
        $this->WP_Widget( 'twitter-widget', __('Latest Tweets (The Design Collective)', 'bootstrap'), $widget_ops, $control_ops );  

    }
    function form($instance) {
        $title = esc_attr($instance['title']);  
        print "<p><label for=\"".$this->get_field_id('title')."\">".__('Title:','bootstrap')."<input class=\"widefat\" id=\"".$this->get_field_id('title')."\" name=\"".$this->get_field_name('title')."\" type=\"text\" value=\"".$title."\" /></label></p>";
    }
    function update($new_instance, $old_instance) {
        // processes widget options to be saved
        return $new_instance;
    }
    function widget($args, $instance) { 
        extract( $args );   //this turns ['array keys'] into $variables

        $title = apply_filters('widget_title', $instance['title'] );  
        $name = $instance['name'];  
        $show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;  
        echo $before_widget;  
        // Display the widget title  
        if ( $title )  
            echo $before_title . $title . $after_title;  
        //Display the name  
        if ( $name )  
            printf( '<p>' . __('Hey their Sailor! My name is %1$s.', 'example') . '</p>', $name );  
        if ( $show_info )  
            printf( $name );  
        echo $after_widget;        

        // print $args['before_widget'];
        // print $args['before_title'] . $instance['title'] . $args['after_title'];  
        // print $args['after_widget'];
        // print "<p>Lorem ipsum dolor sit amet.</p>";
    }
}

