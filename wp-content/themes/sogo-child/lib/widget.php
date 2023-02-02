<?php
/**
 * Register sidebars
 */
function sogo_widgets_init() {

//	register_sidebar( array(
//		'name'          => __( 'Post right', 'sogoc' ),
//		'id'            => 'post_right_sidebar',
//		'before_widget' => '<aside class="widget">',
//		'after_widget'  => '</aside>',
//		'before_title'  => '<h3 class="widget-title">',
//		'after_title'   => '</h3>',
//	) );
//
//	register_sidebar( array(
//		'name'          => __( 'Post left', 'sogoc' ),
//		'id'            => 'post_left_sidebar',
//		'before_widget' => '<aside class="widget">',
//		'after_widget'  => '</aside>',
//		'before_title'  => '<h2 class="widget-title mb-4">',
//		'after_title'   => '</h3>',
//	) );
//
//	register_sidebar( array(
//		'name'          => __( 'About us right', 'sogoc' ),
//		'id'            => 'about_us_right_sidebar',
//		'before_widget' => '<aside class="widget">',
//		'after_widget'  => '</aside>',
//		'before_title'  => '<h3 class="widget-title">',
//		'after_title'   => '</h3>',
//	) );
//
//	register_sidebar( array(
//		'name'          => __( 'About us left', 'sogoc' ),
//		'id'            => 'about_us_left_sidebar',
//		'before_widget' => '<aside class="widget">',
//		'after_widget'  => '</aside>',
//		'before_title'  => '<h3 class="widget-title">',
//		'after_title'   => '</h3>',
//	) );
//
//	register_sidebar( array(
//		'name'          => __( 'Install center', 'sogoc' ),
//		'id'            => 'install_center_sidebar',
//        'before_widget' => '<aside class="sidebar %1$s %2$s">',
//        'after_widget'  => '</aside>',
//        'before_title'  => '<div class="title-wrapper mb-3 ">
//    <div class="row">
//        <div class="col">
//            <h2 class="widget-title  ">
//
//            ',
//        'after_title'   => '</h2>
//
//        </div>
//    </div>
//</div>',
//    ) );
//
//
//    register_sidebar( array(
//        'name'          => __( 'Filters', 'sogoc' ),
//        'id'            => 'filters_sidebar',
//        'before_widget' => '<aside class="sidebar %1$s %2$s">',
//        'after_widget'  => '</aside>',
//        'before_title'  => '<div class="title-wrapper mb-3 ">
//    <div class="row">
//        <div class="col">
//            <h2 class="widget-title  ">
//
//            ',
//        'after_title'   => '</h2>
//
//        </div>
//    </div>
//</div>',
//    ) );
//
//
//	register_sidebar( array(
//		'name'          => __( 'Articles', 'sogoc' ),
//		'id'            => 'articles_sidebar',
//		'before_widget' => '<aside class="sidebar %1$s %2$s">',
//		'after_widget'  => '</aside>',
//		'before_title'  => '<div class="title-wrapper mb-3 ">
//    <div class="row">
//        <div class="col">
//            <h2 class="widget-title  ">
//
//            ',
//		'after_title'   => '</h2>
//
//        </div>
//    </div>
//</div>',
//	) );

//	$mobile_arrow = wp_is_mobile() ? '<i class="icon-arrowdown icon-x1"></i>' : '';

//	register_sidebar( array(
//		'name'          => __( 'Footer 1', 'sogoc' ),
//		'id'            => 'footer1',
//		'before_widget' => '<aside class="widget">',
//		'after_widget'  => '</aside>',
//		'before_title'  => '<h3 class="widget-title color-white medium text-6">',
//		'after_title'   => '</h3>',
//	) );
//	register_sidebar( array(
//		'name'          => __( 'Footer 2', 'sogoc' ),
//		'id'            => 'footer2',
//		'before_widget' => '<aside class="widget">',
//		'after_widget'  => '</aside>',
//		'before_title'  => '<h3 class="widget-title color-white medium text-6">',
//		'after_title'   => "</h3>" ,
//	) );
//	register_sidebar( array(
//		'name'          => __( 'Footer 3', 'sogoc' ),
//		'id'            => 'footer3',
//		'before_widget' => '<aside class="widget">',
//		'after_widget'  => '</aside>',
//		'before_title'  => '<h3 class="widget-title color-white medium text-6">',
//		'after_title'   => "</h3>",
//	) );
//	register_sidebar( array(
//		'name'          => __( 'Footer 4', 'sogoc' ),
//		'id'            => 'footer4',
//		'before_widget' => '<aside class="widget">',
//		'after_widget'  => '</aside>',
//		'before_title'  => '<h3 class="widget-title color-white medium text-6">',
//		'after_title'   => "</h3>",
//	) );
	register_sidebar( array(
		'name'          => __( 'Left sidebar image -hova', 'sogoc' ),
		'id'            => 'left_sidebar',
		'before_widget' => '<aside class="widget">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title color-white medium text-6">',
		'after_title'   => "</h3>",
	) );
	register_sidebar( array(
		'name'          => __( 'Bottom sidebar image -hova', 'sogoc' ),
		'id'            => 'bottom_sidebar',
		'before_widget' => '<aside class="widget">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title color-white medium text-6">',
		'after_title'   => "</h3>",
	) );
	register_sidebar( array(
		'name'          => __( 'Left sidebar image -zad 3', 'sogoc' ),
		'id'            => 'left_sidebar_zad3',
		'before_widget' => '<aside class="widget">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title color-white medium text-6">',
		'after_title'   => "</h3>",
	) );
	register_sidebar( array(
		'name'          => __( 'Bottom sidebar image  - zad 3', 'sogoc' ),
		'id'            => 'bottom_sidebar_zad3',
		'before_widget' => '<aside class="widget">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title color-white medium text-6">',
		'after_title'   => "</h3>",
	) );

	register_sidebar( array(
		'name'          => __( 'Left sidebar image - mekif', 'sogoc' ),
		'id'            => 'left_sidebar_mekif',
		'before_widget' => '<aside class="widget">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title color-white medium text-6">',
		'after_title'   => "</h3>",
	) );
	register_sidebar( array(
		'name'          => __( 'Bottom sidebar image - mekif', 'sogoc' ),
		'id'            => 'bottom_sidebar_mekif',
		'before_widget' => '<aside class="widget">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title color-white medium text-6">',
		'after_title'   => "</h3>",
	) );



}

add_action( 'widgets_init', 'sogo_widgets_init' );

