<?php
/**
 * Register sidebars
 */
if (!function_exists('sogo_widgets_init')) {
    function sogo_widgets_init()
    {
        register_sidebar(array(
            'name' => __('Primary', 'roots'),
            'id' => 'sidebar-primary',
            'before_widget' => '<aside class="widget %1$s %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Notification', 'roots'),
            'id' => 'sidebar-notification',
            'before_widget' => '<section class="widget %1$s %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Recent Posts', 'roots'),
            'id' => 'sidebar-home-recent-posts',
            'before_widget' => '<section class="widget %1$s %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="roof-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer', 'roots'),
            'id' => 'sidebar-footer',
            'before_widget' => '<section class="widget %1$s %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
    }

    add_action('widgets_init', 'sogo_widgets_init');
}
