<?php // Template Name: About page
get_header();
the_post();

//BANNER
	include( 'templates/content-header-banner.php' );

//BREADCRUMBS
get_template_part( 'templates/content', 'breadcrumbs' );
?>


    <div class="page-about">




    </div>


<?php get_footer() ?>