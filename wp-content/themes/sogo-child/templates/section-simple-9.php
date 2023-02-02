<?php
$bg_color        = get_field( '_sogo_section_simple_9_bg' );
$circle_justify  = wp_is_mobile() ? 'justify-content-center' : 'justify-content-center';
$circle_margin_x = wp_is_mobile() ? '' : 'mx-4';
$circle_margin_b = wp_is_mobile() ? 'mb-3' : 'mb-5';
$circle_col      = wp_is_mobile() ? 'col-auto' : 'col-auto';
$check_size      = wp_is_mobile() ? 'icon-x1' : 'icon-x2';
$title_margin_b  = wp_is_mobile() ? 'mb-2' : 'mb-5';
$facts_margin_b  = wp_is_mobile() ? 'mb-2' : 'mb-4';
?>

<section class="section-simple-9 p-relative pt-4"
         style="background-color: <?php echo $bg_color; ?>; ">

    <div class="container-fluid px-0">
        <!-- SECTION SIMPLE 9 CIRCLES -->
		<?php if ( have_rows( '_sogo_section_simple_9_circles' ) ) : ?>
            <div style="align: center" class="row <?php echo $circle_justify; ?> <?php echo $circle_margin_b; ?> ">
				<?php while ( have_rows( '_sogo_section_simple_9_circles' ) ) : the_row() ?>
					<?php $circle_color = get_sub_field( 'color' ); ?>
                    <div class="<?php echo $circle_col; ?> <?php echo $circle_margin_x; ?> ">
                        <a href="<?php the_sub_field( 'url' ); ?>">
                        <div class="section-simple-9__circle b-radius-50 rotate-y-360-on-hover"
                             style="background-color: <?php echo $circle_color ?>; margin-left: -3px; margin-right: -3px">
                            <span class="text-3 color-white"><?php the_sub_field( 'text' ); ?></span>
                        </div>
                        </a>
                    </div>
				<?php endwhile; ?>
            </div>
		<?php endif; ?>

        <!-- SECTION SIMPLE 9 TITLE -->
		<?php if ( get_field( '_sogo_section_simple_9_title' ) ) : ?>
            <div class="row <?php echo $title_margin_b; ?> ">
                <div class="col-12 text-center">
                    <h3 class="color-4 text-2"><?php echo get_field( '_sogo_section_simple_9_title' ); ?></h3>
                </div>
            </div>
		<?php endif; ?>

        <!-- SECTION SIMPLE 9 FACTS -->
		<?php if ( have_rows( '_sogo_section_simple_9_facts' ) ) : ?>
            <div class="row mx-15 <?php echo $facts_margin_b; ?> justify-content-center">
                <div class="col-xl-8">
                    <div class="row justify-content-md-center">
						<?php while ( have_rows( '_sogo_section_simple_9_facts' ) ) : the_row() ?>
                            <div class="col-auto col-6 px-md-15 my-3 text-center">
                                <span class="text-3 color-4 align-right"><?php the_sub_field( 'fact-title' ); ?></span><br>
								<span class="text-4 color-6 align-middle"><?php the_sub_field( 'text' ); ?></span>
								<div class="mt-2"><?php the_sub_field( 'svg' ); ?></div>
                            </div>
						<?php endwhile; ?>
                    </div>
                </div>
            </div>
		<?php endif; ?>

        <div class="section-simple-9__object-wrapper w-100 b-0">
            <img height="<?php echo $carHeight; ?>" width="<?php echo $carWidth; ?>" src="<?php echo get_field( '_sogo_main_section_1_object_img' )['url']; ?>" class="data-animation-2"
                 data-animation
                 alt="<?php echo get_field( '_sogo_main_section_1_object_img' )['alt']; ?>">
        </div>

    </div>

</section>
