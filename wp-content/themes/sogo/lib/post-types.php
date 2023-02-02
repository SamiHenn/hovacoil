<?php
add_action('init', 'sogo_register_all');



function sogo_register_all(){
    $types =  function_exists('sogo_get_post_types') ? sogo_get_post_types() : array();
    $taxs =  function_exists('sogo_get_taxonomies') ? sogo_get_taxonomies() : array();

    foreach ((array)$types as $type){
        sogo_register_post_type( $type  );
    }

    foreach ((array)$taxs as $tax){
        sogo_register_taxonomy( $tax );
    }
}




// keep the child theme text domain
function sogo_register_post_type($args, $label = '') {

    $labels = array(
        'name'               => __($args['label'], 'sogoc'),
        'menu_name'          => __($args['label'], 'sogoc')
    );

    $defaults = array(
        'public'  => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
        'has_archive' => true,
        'rewrite' =>array(
            'slug'         =>  '',
            'with_front'   => true
        ),
        'hierarchical' => true,
        'menu_icon'    => get_template_directory_uri() . '/admin/images/workers.png',
        'supports'     =>  array('title','editor','thumbnail','author'),
        'labels'     =>  $labels
    ) ;

    $args = wp_parse_args($args,$defaults);
    register_post_type( $args['type'],$args);



}


function sogo_register_taxonomy( $tax ) {
    $labels = array(
        'name'          => _x( $tax['label'],'sogoc' ),
        'singular_name' => _x( $tax['label'] ,'sogoc' ),
        'search_items'  => __( "Search {$tax['label']}" ,'sogoc'),
        'popular_items' => __( "Popular {$tax['label']}" ,'sogoc'),
        'all_items'     => __( "All {$tax['label']}" ,'sogoc'),
        'edit_item'     => __( "Edit {$tax['label']}" ,'sogoc'),
        'update_item'   => __( "Update {$tax['label']}" ,'sogoc'),
        'add_new_item'  => __( "Add {$tax['label']}",'sogoc' )

    );
	$defaults = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,

	);

	$args = wp_parse_args($tax,$defaults);


    register_taxonomy( $tax['tax'], array($tax['post_type']) , $args );

}




