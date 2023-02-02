<?php

/**
 * Master theme class
 *
 * @package Bolts
 * @since   1.0
 */
class My_Theme_Options
{

    private $sections;
    private $checkboxes;
    private $settings;

    function theme_add_scripts()
    {
        wp_enqueue_script('media-upload');
        add_thickbox();
    }

    /**
     * Construct
     *
     * @since 1.0
     */
    public function __construct()
    {

        // This will keep track of the checkbox options for the validate_settings function.
        $this->checkboxes = array();
        $this->settings = array();
        $this->get_settings();

        $this->sections['general'] = __('General Settings','sogo');
        $this->sections['forms'] = __('Forms');
        $this->sections['categories'] = __('Categories');
        $this->sections['google'] = __('Google');

        $this->sections['social'] = __('Social Connections');
//		$this->sections['footer']       			= __( 'Footer Options' );
//		$this->sections['about']       				= __( 'About' );

        add_action('admin_menu', array(&$this, 'add_pages'));
        add_action('admin_init', array(&$this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'theme_add_scripts'));
        if (!get_option('mytheme_options'))
            $this->initialize_settings();

    }


    /**
     * Settings and defaults
     *
     * @since 1.0
     */
    public function get_settings()
    {

        /* General Settings
        ===========================================*/
        $this->settings['logo'] = array(
            'title' => __('Logo', 'sogo'),
            'std' => __('if removed the default logo will be used', 'sogoc'),
            'type' => 'upload_image',
            'section' => 'general'
        );
        $this->settings['masooda'] = array(
            'title' => __('Masooda Category', 'sogo'),
            'std' => __('Please use category ID', 'sogoc'),
            'type' => 'text',
            'section' => 'general'
        );
        $this->settings['city-category'] = array(
            'title' => __('city Category', 'sogo'),
            'std' => __('Please use category ID', 'sogoc'),
            'type' => 'text',
            'section' => 'general'
        );
        $this->settings['recipe-category'] = array(
            'title' => __('Recipe Category', 'sogo'),
            'std' => __('Please use category ID', 'sogoc'),
            'type' => 'text',
            'section' => 'general'
        );
        $this->settings['business-page-banner'] = array(
            'title' => __('Business Page Banner', 'sogo'),
            'std' => __('Please add Image to Business Page', 'sogoc'),
            'type' => 'upload_image',
            'section' => 'general'
        );
        $this->settings['events-page-banner'] = array(
            'title' => __('Events Page Banner', 'sogo'),
            'std' => __('Please add Image to Events Page', 'sogoc'),
            'type' => 'upload_image',
            'section' => 'general'
        );
        $this->settings['event-page-banner'] = array(
            'title' => __('Event Page Banner', 'sogo'),
            'std' => __('Please add Image to Event Page', 'sogoc'),
            'type' => 'upload_image',
            'section' => 'general'
        );
        $this->settings['survey-text'] = array(
            'title' => __('Survey Text', 'sogo'),
            'std' => __('Please add Text to Survey Page', 'sogoc'),
            'type' => 'textarea',
            'section' => 'general'
        );
        $this->settings['page-red-mail'] = array(
            'title' => __('Page Red Mail'),
            'std' => '',
            'type' => 'pg_list',
            'section' => 'general'
        );
        $this->settings['page-videos'] = array(
            'title' => __('Page Videos'),
            'std' => '',
            'type' => 'pg_list',
            'section' => 'general'
        );
        $this->settings['page-mivzakim'] = array(
            'title' => __('Page mivzakim'),
            'std' => '',
            'type' => 'pg_list',
            'section' => 'general'
        );
        $this->settings['page-events'] = array(
            'title' => __('Page Events'),
            'std' => '',
            'type' => 'pg_list',
            'section' => 'general'
        );
        $this->settings['business-form'] = array(
            'title' => __('Business-form'),
            'std' => '',
            'type' => 'pg_list',
            'section' => 'general'
        );
        $this->settings['page-naim-form'] = array(
            'title' => __('Page Naim Form'),
            'std' => '',
            'type' => 'pg_list',
            'section' => 'general'
        );

        $this->settings['contact-us-to'] = array(
            'title' => __('Title fo Contact us to'),
            'desc' => __('Title fo Contact us to'),
            'std' => '',
            'type' => 'text',
            'section' => 'general'
        );

        $this->settings['survey-declaimer'] = array(
            'title' => __('Survey Declaimer', 'sogoc'),
            'type' => 'textarea',
            'section' => 'general'
        );
        $this->settings['dover-text'] = array(
            'title' => __('Dover Text', 'sogoc'),
            'type' => 'textarea',
            'section' => 'general'
        );
        $this->settings['dover-thankyou-title'] = array(
            'title' => __('Dover Thank you Title', 'sogoc'),
            'type' => 'text',
            'section' => 'general'
        );
        $this->settings['dover-thankyou-text'] = array(
            'title' => __('Dover Thank you Text', 'sogoc'),
            'type' => 'textarea',
            'section' => 'general'
        );
        $this->settings['footer-text-rights'] = array(
            'title' => __('Footer Text Rights'),
            'desc' => __('Footer Text Right'),
            'std' => '',
            'type' => 'text',
            'section' => 'general'
        );
        $this->settings['footer-text-dedicated'] = array(
            'title' => __('Footer Text Dedicated'),
            'desc' => __('Footer Text Dedicated'),
            'std' => '',
            'type' => 'text',
            'section' => 'general'
        );


        /* Categories
        ===========================================*/
        $this->settings['hide_categories'] = array(
            'section' => 'categories',
            'title' => __('Select which categories to hide', 'sogoc'),
            'desc' => '',
            'type' => 'categories',
            'std' => ''
        );

        /* Google
        ===========================================*/

        $this->settings['google_site_verification'] = array(
            'section' => 'google',
            'title' => __('Google Site Verification'),
            'desc' => __('to be used with google web master tools.'),
            'type' => 'text',
            'std' => ''
        );

        $this->settings['google_analytics'] = array(
            'section' => 'google',
            'title' => __('Google Analytics code'),
            'desc' => __('paste the google analytics code'),
            'type' => 'textarea',
            'std' => ''
        );
        $this->settings['google_tag'] = array(
            'section' => 'google',
            'title' => __('Google Tag Manager code'),
            'desc' => __('paste the google tag manager code'),
            'type' => 'textarea',
            'std' => ''
        );
        $this->settings['google_remarketing'] = array(
            'section' => 'google',
            'title' => __('Google Re-Marketing code'),
            'desc' => __('paste the google re-marketing code'),
            'type' => 'textarea',
            'std' => ''
        );

        /* Special Translation (to be controlled by user)
        ===========================================*/

        $this->settings['read'] = array(
            'section' => 'tranlation',
            'title' => __('read more'),
            'desc' => __('read more string'),
            'type' => 'text',
            'std' => ''
        );

        /* Social
        ===========================================*/
        $this->settings['social-title'] = array(
            'section' => 'social',
            'title' => __('Social Title'),
            'type' => 'text',
            'std' => 'Get In Touch'
        );
        $this->settings['facebook'] = array(
            'section' => 'social',
            'title' => __('Facebook link'),
            'desc' => __('enter the link to your facebook page'),
            'type' => 'text',
            'std' => ''
        );
        $this->settings['linkedin'] = array(
            'section' => 'social',
            'title' => __('linkedin link'),
            'desc' => __('enter the link to your Linkedin page'),
            'type' => 'text',
            'std' => ''
        );
        $this->settings['youtube'] = array(
            'section' => 'social',
            'title' => __('Youtube link'),
            'desc' => __('enter the link to your Youtube page'),
            'type' => 'text',
        );
        $this->settings['twitter'] = array(
            'section' => 'social',
            'title' => __('Twitter link'),
            'desc' => __('enter the link to your twitter page'),
            'type' => 'text',
        );
        $this->settings['googleplus'] = array(
            'section' => 'social',
            'title' => __('Google Plus link'),
            'desc' => __('enter the link to your Google plus page'),
            'type' => 'text',
        );

        $this->settings['call'] = array(
            'section' => 'social',
            'title' => __('call me link'),
            'desc' => __('enter the link to call me'),
            'type' => 'text',
        );
        $this->settings['waze'] = array(
            'section' => 'social',
            'title' => __('waze link'),
            'desc' => __('enter the link waze'),
            'type' => 'text',
        );
        $this->settings['contact'] = array(
            'section' => 'social',
            'title' => __('contact link'),
            'desc' => __('enter the link to contact'),
            'type' => 'text',
        );

    }


    /*	DOP NOT EDIT BELOW
    =============================================*/


    /**
     * Add options page
     *
     * @since 1.0
     */
    public function add_pages()
    {

        $admin_page = add_menu_page(__('Theme Options'), __('Theme Options'), 'manage_options', 'mytheme-options',
            array(&$this, 'display_page'));

        add_action('admin_print_scripts-' . $admin_page, array(&$this, 'scripts'));
        add_action('admin_print_styles-' . $admin_page, array(&$this, 'styles'));

    }

    /**
     * Create settings field
     *
     * @since 1.0
     */
    public function create_setting($args = array())
    {

        $defaults = array(
            'id' => 'default_field',
            'title' => __('Default Field'),
            'desc' => __('This is a default description.'),
            'std' => '',
            'type' => 'text',
            'section' => 'general',
            'choices' => array(),
            'class' => ''
        );

        extract(wp_parse_args($args, $defaults));

        $field_args = array(
            'type' => $type,
            'id' => $id,
            'desc' => $desc,
            'std' => $std,
            'choices' => $choices,
            'label_for' => $id,
            'class' => $class
        );

        if ($type == 'checkbox')
            $this->checkboxes[] = $id;

        add_settings_field($id, $title, array($this, 'display_setting'), 'mytheme-options', $section, $field_args);
    }

    /**
     * Display options page
     *
     * @since 1.0
     */
    public function display_page()
    {

        echo '<div class="wrap">
	<div class="icon32" id="icon-options-general"></div>
	<h2>' . __('Theme Options') . '</h2>';

        if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == true)
            echo '<div class="updated fade"><p>' . __('Theme options updated.') . '</p></div>';

        echo '<form action="options.php" method="post">';

        settings_fields('mytheme_options');
        echo '<div class="ui-tabs">
			<ul class="ui-tabs-nav">';

        foreach ($this->sections as $section_slug => $section)
            echo '<li><a href="#' . $section_slug . '">' . $section . '</a></li>';

        echo '</ul>';
        do_settings_sections($_GET['page']);

        echo '</div>
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="' . __('Save Changes') . '" /></p>
		
	</form>';

        echo '<script type="text/javascript">
		jQuery(document).ready(function($) {
			var sections = [];';

        foreach ($this->sections as $section_slug => $section)
            echo "sections['$section'] = '$section_slug';";

        echo 'var wrapped = $(".wrap h3").wrap("<div class=\"ui-tabs-panel\">");
			wrapped.each(function() {
				$(this).parent().append($(this).parent().nextUntil("div.ui-tabs-panel"));
			});
			$(".ui-tabs-panel").each(function(index) {
				$(this).attr("id", sections[$(this).children("h3").text()]);
				//if (index > 0)
				//	$(this).addClass("ui-tabs-hide");
			});
			$(".ui-tabs").tabs({
				fx: { opacity: "toggle", duration: "fast" }
			});
			
			$("input[type=text], textarea").each(function() {
				if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "")
					$(this).css("color", "#999");
			});
			
			$("input[type=text], textarea").focus(function() {
				if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "") {
					$(this).val("");
					$(this).css("color", "#000");
				}
			}).blur(function() {
				if ($(this).val() == "" || $(this).val() == $(this).attr("placeholder")) {
					$(this).val($(this).attr("placeholder"));
					$(this).css("color", "#999");
				}
			});
			
			$(".wrap h3, .wrap table").show();
			
			// This will make the "warning" checkbox class really stand out when checked.
			// I use it here for the Reset checkbox.
			$(".warning").change(function() {
				if ($(this).is(":checked"))
					$(this).parent().css("background", "#c00").css("color", "#fff").css("fontWeight", "bold");
				else
					$(this).parent().css("background", "none").css("color", "inherit").css("fontWeight", "normal");
			});
			
			// Browser compatibility
			if ($.browser.mozilla) 
			         $("form").attr("autocomplete", "off");
		});

	</script>
</div>';
        echo "<script>


            jQuery(document).ready(function() {
                var original_send_to_editor = window.send_to_editor;
                jQuery('.upload_image_button').click(function() {
                    formfield =  jQuery(this).prev('.upload_image');
                    //post_id = jQuery('#post_ID').val();
                    tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
                    window.send_to_editor = function(html) {
                        imgurl = jQuery('img',html).attr('src');
                        formfield.val(imgurl);
                        tb_remove();
                        window.send_to_editor = original_send_to_editor;

                    }
                    return false;
                });

            });

    </script>";
    }

    /**
     * Description for section
     *
     * @since 1.0
     */
    public function display_section()
    {
        // code
    }

    /**
     * Description for About section
     *
     * @since 1.0
     */
    public function display_about_section()
    {

        // This displays on the "About" tab. Echo regular HTML here, like so:
        echo '<p>Copyright 2011 ohav.co.il</p>';

    }

    /**
     * HTML output for text field
     *
     * @since 1.0
     */
    public function display_setting($args = array())
    {

        extract($args);

        $options = get_option('mytheme_options');

        if (!isset($options[$id]) && $type != 'checkbox')
            $options[$id] = $std;
        elseif (!isset($options[$id]))
            $options[$id] = 0;

        $field_class = '';
        if ($class != '')
            $field_class = ' ' . $class;

        switch ($type) {

            case 'heading':
                echo '</td></tr><tr valign="top"><td colspan="2"><h4>' . $desc . '</h4>';
                break;

            case 'checkbox':

                echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="mytheme_options[' . $id . ']" value="1" ' . checked($options[$id],
                        1, false) . ' /> <label for="' . $id . '">' . $desc . '</label>';

                break;

            case 'select':
                echo '<select class="select' . $field_class . '" name="mytheme_options[' . $id . ']">';

                foreach ($choices as $value => $label)
                    echo '<option value="' . esc_attr($value) . '"' . selected($options[$id], $value,
                            false) . '>' . $label . '</option>';

                echo '</select>';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'radio':
                $i = 0;
                foreach ($choices as $value => $label) {
                    echo '<input class="radio' . $field_class . '" type="radio" name="mytheme_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr($value) . '" ' . checked($options[$id],
                            $value, false) . '> <label for="' . $id . $i . '">' . $label . '</label>';
                    if ($i < count($options) - 1)
                        echo '<br />';
                    $i++;
                }

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'textarea':
                echo '<textarea class="' . $field_class . '" id="' . $id . '" name="mytheme_options[' . $id . ']" placeholder="' . $std . '" rows="5" cols="30">' . wp_htmledit_pre($options[$id]) . '</textarea>';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;
            case 'categories':


                $selected_cats = oh_option('hide_categories');
                $cats = get_categories('hide_empty=0');
                echo "<ul>";
                foreach ($cats as $cat) {
                    $select = in_array($cat->term_id , $selected_cats) ? ' checked ': '';
                    echo '<li><input value="' . $cat->term_id . '" type="checkbox" name="' . 'mytheme_options[' . $id . '][]' . '"'. $select .' >';
                    echo '<label for ="">'.$cat->name.'</label></li>';
                }
                echo "</ul>";
                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'pg_list':

                $args = array(
                    'depth' => 0,
                    'show_date' => '',
                    'date_format' => get_option('date_format'),
                    'child_of' => 0,
                    'exclude' => '',
                    'name' => 'mytheme_options[' . $id . ']',
                    'include' => '',
                    'selected' => (isset($options[$id])) ? $options[$id] : '',//$value['id'],
                    'title_li' => __('Pages'),
                    'echo' => 1,
                    'authors' => '',
                    'sort_column' => 'menu_order, post_title',
                    'link_before' => '',
                    'link_after' => '',
                    'walker' => '',
                    'post_type' => 'page',
                    'post_status' => 'publish'
                );
                wp_dropdown_pages($args);

                break;
            case "ddl":
                echo '<select name="mytheme_options[' . $id . ']"  id="page_id">';
                $args = array('numberposts' => -1, 'post_type' => $post_type);
                $posts = get_posts($args);
                foreach ($posts as $p) :
                    echo '<option value="' . $p->ID . '" ' . selected($options[$id],
                            $p->ID) . '>' . get_the_title($p) . '</option>';
                endforeach;
                echo '</select>';

                break;

            case 'password':
                echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="mytheme_options[' . $id . ']" value="' . esc_attr($options[$id]) . '" />';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;
            case "upload_image":
                $img = ($options[$id] != '') ? esc_attr($options[$id]) : get_template_directory_uri() . "/images/logo.jpg";
                echo '<img style="margin:5px;max-width:90px;max-height:90px;display:block"  src="' . $img . '"/>
                      <input class="upload_image" type="text" size="36" name="mytheme_options[' . $id . ']" value="' . esc_attr($options[$id]) . '" />
                      <input class="upload_image_button" type="button" value="Upload Image" /></p>';

                break;
            case 'text':
            default:
                echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="mytheme_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr($options[$id]) . '" />';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

        }

    }


    /**
     * Initialize settings to their default values
     *
     * @since 1.0
     */
    public function initialize_settings()
    {

        $default_settings = array();
        foreach ($this->settings as $id => $setting) {
            if ($setting['type'] != 'heading')
                $default_settings[$id] = $setting['std'];
        }

        update_option('mytheme_options', $default_settings);

    }

    /**
     * Register settings
     *
     * @since 1.0
     */
    public function register_settings()
    {

        register_setting('mytheme_options', 'mytheme_options', array(&$this, 'validate_settings'));

        foreach ($this->sections as $slug => $title) {
            if ($slug == 'about')
                add_settings_section($slug, $title, array(&$this, 'display_about_section'), 'mytheme-options');
            else
                add_settings_section($slug, $title, array(&$this, 'display_section'), 'mytheme-options');
        }

        $this->get_settings();

        foreach ($this->settings as $id => $setting) {
            $setting['id'] = $id;
            $this->create_setting($setting);
        }

    }

    /**
     * jQuery Tabs
     *
     * @since 1.0
     */
    public function scripts()
    {

        wp_print_scripts('jquery-ui-tabs');

    }

    /**
     * Styling for the theme options page
     *
     * @since 1.0
     */
    public function styles()
    {

        wp_register_style('mytheme-admin', get_bloginfo('template_url') . '/includes/admin/ohav-options.css');
        wp_enqueue_style('mytheme-admin');

    }

    /**
     * Validate settings
     *
     * @since 1.0
     */
    public function validate_settings($input)
    {

        if (!isset($input['reset_theme'])) {
            $options = get_option('mytheme_options');

            foreach ($this->checkboxes as $id) {
                if (isset($options[$id]) && !isset($input[$id]))
                    unset($options[$id]);
            }

            return $input;
        }

        return false;

    }

}

$theme_options = new My_Theme_Options();

function oh_option($option)
{
    $options = get_option('mytheme_options');
    if (isset($options[$option]))
        return $options[$option];
    else
        return false;
}

?>