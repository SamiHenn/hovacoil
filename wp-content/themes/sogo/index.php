<?php
/**
 * The template for main file
 *
 * @package SOGO
 * @since sogo 2.0
 */
?>
<?php get_header(); ?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-3 col-lg-3">
            <div id="sidebar" class="sidebar">
                <?php get_sidebar(); ?>
            </div><!-- .sidebar -->
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-8 col-lg-8">
            <div id="content" class="site-content">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">
                        <header class="page-header">
                            <h1 class="page-title"><?php the_title() ?></h1>

                        </header><!-- .page-header -->
                        <?php
                        // Start the loop.
                        while (have_posts()) : the_post();
                            the_content();

                            // End the loop.
                        endwhile;

                        // Previous/next page navigation.
                        the_posts_pagination(array(
                            'prev_text' => __('Previous page', 'sogo'),
                            'next_text' => __('Next page', 'sogo'),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'sogo') . ' </span>',
                        ));
                        ?>
                    </main><!-- .main -->
                </div><!-- .content-area -->
            </div><!-- .site-content -->
        </div><!-- .col-lg-12 -->
    </div><!-- .row -->
</div><!-- .container -->
<?php get_footer(); ?>

