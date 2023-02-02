<?php
get_header();
the_post();

//BANNER
	include( 'templates/content-header-banner.php' );


//BREADCRUMBS
get_template_part( 'templates/content', 'breadcrumbs' );
?>

<div class="page-search">

    <section class="page-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h1 class="page-title  color-red padding-y-md2">
						<?php _e( 'Search Result For', 'sogoc' ) ?> "<?php echo the_search_query(); ?>"
                    </h1>
                </div>
                <!-- /col-lg-10 offset-1 -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container-fluid -->
    </section>
    <!-- /page-header -->

    <section class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-8 col-lg-push-3 padding-top-md">
                            <div class="row">

								<?php if ( have_posts() ): ?>
									<?php while ( have_posts() ): the_post(); ?>

                                        <div class="col-lg-12 padding-bottom-md">
                                            <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                                        </div>

									<?php endwhile; ?>
								<?php else : ?>
                                    <div class="col-lg-12">
                                        <h2 class="homepage-subtitles padding-y-md">
											<?php _e( 'no results found, please try another search', 'sogoc' ) ?>
                                        </h2>
                                        <!-- /col-lg-12 -->

                                    </div>
                                    <!-- /row -->
								<?php endif; ?>
                            </div>
                            <!-- /col-lg-8 -->
                        </div>
                        <div class="col-lg-2 col-lg-offset-1 col-lg-pull-8">
                            <div class="search-articles">

								<?php echo get_search_form() ?>

                            </div>

                            <!-- sidebar categories -->
							<?php include 'templates/sidebar-categories.php'; ?>
                            <!-- / sidebar categories -->

                        </div>
                        <!-- /col-lg-2 -->

                    </div>
                    <!-- /col-lg-10 offset-1 -->
                </div>
                <!-- /col-lg-12 -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container-fluid -->
    </section>

</div>
<?php get_footer(); ?>
