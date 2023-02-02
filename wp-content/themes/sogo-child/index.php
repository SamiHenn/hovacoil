<?php

get_header();
?>

    <!--BREADCRUMBS-->
<?php include "templates/content-breadcrumbs.php"; ?>
    <div class="container-fluid bg-8">
        <div class="container">
        <!-- CONTENT -->
		<h1 class="text-1 color-4 mb-1">מידע שימושי</h1>
		<h2 class="text-4 color-3 mb-3">כתבות, טיפים ומידע מקצועי</h2>
        <div class="row justify-content-center">
            <!-- TEXT -->
			<?php while ( have_posts() ): the_post(); ?>
                <div style="border-radius: 25px; border: 1px solid #c0c0c0" class="col-lg-10 mb-4 bg-white my-3 p-2">

                    <h2 class="text-2 mb-2 color-<?php echo(rand(3,5));?> mb-1"><?php the_title() ?></h2>
                    <div class="text-5 color-6 mb-1"><?php the_date() ?></div>
                    <div class="entry-content">
						<?php the_excerpt(); ?>
                    </div>
                    <div class="text-right">
						<?php $randButtonColor = rand(2,5);?>
                        <a href="<?php the_permalink(); ?>"
                           class="s-button s-button-2 border-color-<?php echo $randButtonColor;?> bg-<?php echo $randButtonColor;?>">
			                <?php get_field('_sogo_read_more_btn') ? the_field('_sogo_read_more_btn') : _e('Continue Reading', 'sogoc');?>
                        </a>
                    </div>
                </div>

			<?php endwhile; ?>
        </div>
        </div>

        <div class="row justify-content-between align-items-end border-bottom border-width-x2 border-color-6">
            <div class="bottom-right-image p-relative">
				<?php echo wp_get_attachment_image( get_field( '_sogo_bottom_right_image', 'option' ), 'full' ); ?>
            </div>

            <div class="bottom-left-image p-relative hidden-md-down">
				<?php echo wp_get_attachment_image( get_field( '_sogo_bottom_left_image', 'option' ), 'full' ); ?>
            </div>
        </div>
    </div>

<?php get_footer() ?>