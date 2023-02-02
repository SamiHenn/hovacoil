<?php
function sogo_blog_load_more($page){


    $args = array(
        'post_type' => 'post',
        'paged' => $page,
        'posts_per_page' => 4,

    );
    $the_query = new WP_Query($args);
    $max_pages  = $the_query->max_num_pages > $page;
    if (!$the_query->have_posts()) {
        return false;
    }
    ?>
    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
       <?php get_template_part('templates/content', 'post');?>
    <?php endwhile; ?>
    <?php wp_reset_postdata();
    return $max_pages;
}


function ajax_load_more()
{
    ob_start();
    $max = sogo_blog_load_more($_POST['page']);
    echo json_encode(array(
        'max' => $max,
        'html' => ob_get_clean()
    ));
    die();
}
add_action('wp_ajax_ajax_load_more', 'ajax_load_more');
add_action('wp_ajax_nopriv_ajax_load_more', 'ajax_load_more');
