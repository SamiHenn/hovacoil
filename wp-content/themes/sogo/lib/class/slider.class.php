<?php
/**
 * Created by PhpStorm.
 * User: mmh15
 * Date: 28/11/2016
 * Time: 16:04
 */

namespace sogo;

/**
 * Class slider
 * @package sogo
 * @param string $slider_key key of acf slider
 */
class slider
{

    public $slides = array();
    static $vendor_dir;
    private $ver = '2.0.0';

    public function __construct($slider_key = '_sogo_slider')
    {

        // check if the slider repeater field has rows of data
        if (have_rows($slider_key)):

            // Start a loop for get all slides data
            while (have_rows($slider_key)) : the_row();

                $slide['bg'] = get_sub_field('background');
                $slide['btn']['text'] = get_sub_field('btn_text');
                $slide['btn']['href'] = get_sub_field('btn_link');
                $slide['btn']['target'] = get_sub_field('open_blank') ? '_blank' : 'self';
                $slide['txt']['title'] = get_sub_field('title');
                $slide['txt']['subtitle'] = get_sub_field('subtitle');
                $slide['txt']['paragraph'] = get_sub_field('paragraph');

                $this->slides[] = $slide;

            endwhile;

        endif;

        // Get vendor dir
        if (empty($this::$vendor_dir)) {
            $this::$vendor_dir = \get_template_directory_uri() . '/assets/vendor/owl-carousel/';
        }

    }

    /*
     * Add assets to wp enqueue
     */
    private function enqueue_assets()
    {
        // Register and Add js file
        wp_register_script('owl-carousel-js', $this::$vendor_dir . 'owl.carousel.min.js', array('jquery'), $this->ver, true);
        wp_enqueue_script('owl-carousel-js');

        // Register and Add css file
        wp_register_style('owl-carousel', $this::$vendor_dir . 'owl.carousel.css', null, $this->ver);
        wp_enqueue_style('owl-carousel');

        // Add inline script for set slider settings
        $settings = array(
            'items' => get_field('_sogo_slider_items'),
            'loop' => get_field('_sogo_slider_loop'),
            'nav' => get_field('_sogo_slider_nav'),
            'dots' => get_field('_sogo_slider_dots'),
            'lazyLoad' => get_field('_sogo_slider_lazyload'),
            'autoplay' => get_field('_sogo_slider_autoplay'),
            'autoplayTimeout' => get_field('_sogo_slider_timeout') ? get_field('_sogo_slider_timeout') : '5000',
            'autoplayHoverPause' => get_field('_sogo_slider_pause_hover') ? get_field('_sogo_slider_pause_hover') : true,
            'rtl' => true
        );
        wp_add_inline_script('owl-carousel-js', '
      (function( $ ){
        $(".owl-carousel").owlCarousel(' . json_encode($settings) . ');
      })( jQuery );
    ');

    }

    /**
     * Get html code of slider
     * @return string
     */
    public function get_slider()
    {
        $this->enqueue_assets();

        $slides = '';

        // Load templates
        $slider_template = file_get_contents(get_template_directory() . '/templates/content-slider.php');
        $slide_template_img = file_get_contents(get_template_directory() . '/templates/content-slide-img.php');
        $slide_template_video = file_get_contents(get_template_directory() . '/templates/content-slide-video.php');
//        $htmlIn = '';

        foreach ($this->slides as $key => $slide) {

            $slide_type = $slide['bg']['type'] == 'image' ? 'img' : 'video';

            $slides .= \sogo_parse_template(${'slide_template_' . $slide_type}, array('slide' => $slide));

//            $type = ${'slide_template_' . $slide_type};

//            debug($type);

//            if ($type == 'slider_template') {
//                include('../../templates/content-slider.php');
//            } elseif ($type == 'slider_template_img') {
//                include('../../templates/content-slide-img.php');
//            } elseif ($type == 'slider_template_video') {
//                include('../../templates/content-slide-video.php');
//            }
        }

        $html = \sogo_parse_template($slider_template, array('slides' => $slides));

        return $html;
    }

}