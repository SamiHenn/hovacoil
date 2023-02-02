<?php
$title = get_field('_sogo_section_posts_1_title');
$bg = get_field('_sogo_section_posts_1_bg');
?>

<section class="section-posts-1 pt-4 pt-lg-5"
         style="background-color: <?php echo $bg; ?>">

    <div class="container-fluid">

        <!-- SECTION-POSTS-1 TITLE -->
        <div class="row text-center mb-3 mb-lg-4">
            <div class="col-12 mb-lg-2">
                <h3 class="text-2 color-4"><?php echo $title; ?> </h3>
            </div>
        </div>

        <div class="row justify-content-center">

	        <?php global $post ; foreach(get_option('sticky_posts') as $post) : setup_postdata($post);?>
                <div class="col-lg-8 mb-3">
                    <!-- QUESTION  -->
                    <div class="collapsed question" data-toggle="collapse"
                         data-target="#posts-accordion<?php echo $index; ?>">
                        <span class="icon"></span>
                        <span class="text-4"><?php the_title() ?></span>
                    </div>

                    <!-- ANSWER -->
                    <div id="posts-accordion<?php echo $index; ?>"
                         class="collapse answer text-main bg-white">
                        <div class="answer-inner">
                            <div class="entry-content">
						        <?php   the_excerpt(); ?>
                            </div>
                            <div class="text-center">
                                <a href="<?php the_permalink(); ?>"
                                   class="s-button s-button-2">
	                                <?php get_field('_sogo_read_more_btn') ? the_field('_sogo_read_more_btn') : _e('Continue Reading', 'sogoc');?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
		        <?php
		        $index++;
		        ?>
	        <?php endforeach; ?>
	        <?php wp_reset_postdata(); ?>



	        <?php
	        $sticky = get_option( 'sticky_posts' );
	        $args = [
		        'post_type' => 'post',
		        'posts_per_page' => '4',
		        'ignore_sticky_posts' => 1,
		        'post__not_in' => $sticky,
		        'orderby' => 'date',
		        'order' => 'DESC'

	        ];
	        $query = new WP_Query($args);

	        ?>
	        <?php if ($query->have_posts()) : ?>
		        <?php
		        $index = 1;
		        ?>
		        <?php while ($query->have_posts()) : $query->the_post() ?>
                    <div class="col-lg-8 mb-3">
                        <!-- QUESTION  -->
                        <div class="collapsed question" data-toggle="collapse"
                             data-target="#posts-accordion_sticky_<?php echo $index; ?>">
                            <span class="icon"></span>
                            <span class="text-4"><?php the_title() ?></span>
                        </div>

                        <!-- ANSWER -->
                        <div id="posts-accordion_sticky_<?php echo $index; ?>"
                             class="collapse answer text-main bg-white">
                            <div class="answer-inner">
                                <div class="entry-content">
							        <?php the_excerpt(); ?>
                                </div>
                                <div class="text-center">
                                    <a href="<?php the_permalink(); ?>"
                                       class="s-button s-button-2">
								        <?php get_field('_sogo_read_more_btn') ? the_field('_sogo_read_more_btn') : _e('Continue Reading', 'sogoc');?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
			        <?php
			        $index++;
			        ?>
		        <?php endwhile; ?>
		        <?php wp_reset_postdata(); ?>
	        <?php endif; ?>


        </div>

        <div class="row justify-content-between align-items-start">
            <div class="bottom-right-image p-relative data-animation-4" data-animation>
                <?php echo wp_get_attachment_image(get_field('_sogo_bottom_right_image'), 'full', false, array('class' => '')); ?>
            </div>

            <div class="bottom-left-image p-relatve hidden-md-down">
                <?php echo wp_get_attachment_image(get_field('_sogo_bottom_left_image'), 'full'); ?>
            </div>
        </div>

    </div>






</section>