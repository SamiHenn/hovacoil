<!--?php /* Template Name: page-sami-full-width-color-5*/ ?-->
<?php
get_header();
?>
    <!-- BANNER -->
    <?php include('templates/content-header-banner.php'); ?>
    <div align="center" style="padding-left: 0px;  padding-right: 0px" class="container-fluid bg-5">
		    <!--BREADCRUMBS-->
     <div align="right" class="col-lg-12">
		<?php include "templates/content-breadcrumbs-color5.php"; ?>
		</div>
        <!-- CONTENT -->
        <div class="row justify-content-center">
            <!-- TEXT -->
            <div align="center" class="col-lg-12">
                <h1 class="text-1 color-white"><?php the_title(); ?></h1>
				<br>
                <div align="center" class="entry-content">
                    <?php the_content(); ?>
                </div>

            </div>
        </div>
    </div>


<?php get_footer() ?>