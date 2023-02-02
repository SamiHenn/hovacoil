<!--?php /* Template Name: page-sami-full-width*/ ?-->
<?php
get_header();
?>
    <!-- BANNER -->
    <?php include('templates/content-header-banner.php'); ?>
    <div align="center" style="padding-left: 0px;  padding-right: 0px" class="container-fluid bg-3">
		    <!--BREADCRUMBS-->
     <div align="right" class="col-lg-12">
		<?php include "templates/content-breadcrumbs-color3.php"; ?>
		</div>
        <!-- CONTENT -->
        <div class="row justify-content-center">
            <!-- TEXT -->
            <div align="center" class="col-lg-12">
                <h1 class="text-1 color-4"><?php the_title(); ?></h1>
                <div align="center" class="entry-content">
                    <?php the_content(); ?>
                </div>

            </div>
        </div>
    </div>


<?php get_footer() ?>