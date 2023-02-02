<?php
if(class_exists('Sogo_Admin')){
    return ;
}
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class Sogo_Admin
{
    /**
     * Option key, and option page slug
     * @var string
     */
    private $key = 'sogo_options';
    /**
     * Options page metabox id
     * @var string
     */
    private $metabox_id = 'sogo_option_metabox';
    /**
     * Options Page title
     * @var string
     */
    protected $title = '';
    /**
     * Options Page hook
     * @var string
     */
    protected $options_page = '';
    /**
     * Options sections
     * @var array
     */
    private $sections = array();
    private $settings = array();

    /**
     * Constructor
     * @since 0.1.0
     */
    public function __construct()
    {
        // Set our title
        $this->title = __('Site Options', 'sogo');
        $this->sections['general'] = __('General Settings', 'sogo');
        $this->sections['google'] = __('Google Settings', 'sogo');


      //  $this->set_settings();
    }

    /**
     * Initiate our hooks
     * @since 0.1.0
     */
    public function hooks()
    {
        add_action('admin_init', array($this, 'init'));
        add_action('admin_menu', array($this, 'add_options_page'));
        add_action('cmb2_init', array($this, 'add_options_page_metabox'));
    }

    /**
     * add Stylesheet
     * @since 0.1.0
     */
    public function styles()
    {

        wp_register_style('sogo-options', get_stylesheet_directory_uri() . '/admin/sogo-options.css');
        wp_enqueue_style('sogo-options');

    }
    /**
     * add scripts
     * @since 0.1.0
     */
    public function scripts()
    {

        wp_print_scripts('jquery-ui-tabs');

    }
    /**
     * Register our setting to WP
     * @since  0.1.0
     */
    public function init()
    {
        register_setting($this->key, $this->key);
    }

    /**
     * Add menu options page
     * @since 0.1.0
     */
    public function add_options_page()
    {
        $this->options_page = add_menu_page($this->title, $this->title, 'manage_options', $this->key, array($this, 'admin_page_display'));
        // Include CMB CSS in the head to avoid FOUT
        add_action("admin_print_styles-{$this->options_page}", array('CMB2_hookup', 'enqueue_cmb_css'));
        add_action("admin_print_scripts-{$this->options_page}", array(&$this, 'scripts'));
        add_action("admin_print_styles-{$this->options_page}", array(&$this, 'styles'));
    }


    public function set_settings()
    {
        $this->settings['general']['logo'] = array(
            'title' => __('Logo', 'sogo'),
            'default' => '',
            'desc' => __('if removed the default logo will be used', 'sogoc'),
            'type' => 'file',
        );

        $this->settings['general']['favorite-text'] = array(
            'title' => __('Favorite text', 'sogo'),
            'type' => 'text',
        );
    }

    /**
     * Admin page markup. Mostly handled by CMB2
     * @since  0.1.0
     */
    public function admin_page_display()
    {
        ?>
        <div class="wrap cmb2-options-page <?php echo $this->key; ?>">
            <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

            <div class="ui-tabs">
                <ul class="ui-tabs-nav">
                    <?php
                    foreach ($this->sections as $section_slug => $section) : ?>
                        <li><a href="#<?php echo $section_slug ?>"> <?php echo $section ?> </a></li>
                    <?php endforeach; ?>
                </ul>
                <?php cmb2_metabox_form($this->metabox_id, $this->key, array('cmb_styles' => false)); ?>
            </div>

        </div>
        <script>
            jQuery(".ui-tabs").tabs({
                fx: { opacity: "toggle", duration: "fast" }
            });
        </script>
        <?php
    }

    /**
     * Add the options metabox to the array of metaboxes
     * @since  0.1.0
     */
    function add_options_page_metabox()
    {

        $cmb = new_cmb2_box(array(
            'id' => $this->metabox_id,
            'hookup' => false,
            'show_on' => array(
                // These are important, don't remove
                'key' => 'options-page',
                'value' => array($this->key,)
            ),
        ));

//        // Set our CMB2 fields
        $cmb->add_field(array(
            'name' => __('Logo', 'sogo'),
            'desc' => __('Logo (optional)', 'sogo'),
            'id' => 'logo',
            'type' => 'file',
            'default' => '',
            'before_row' => '<div id="general">',
        ));

        $cmb->add_field(array(
            'name' => __('Test Color Picker', 'sogo'),
            'desc' => __('field description (optional)', 'sogo'),
            'id' => 'test_colorpicker',
            'type' => 'colorpicker',
            'default' => '#bada55',

            'after_row' => '</div>',
        ));

        $cmb->add_field(array(
            'name' => __('Analytics', 'sogo'),
            'desc' => __('Logo (optional)', 'sogo'),
            'id' => 'google-ana',
            'type' => 'textarea',
            'default' => '',
            'before_row' => '<div id="google">',
        ));

        $cmb->add_field(array(
            'name' => __('asdf', 'sogo'),
            'desc' => __('asfd (optional)', 'sogo'),
            'id' => 'logo3',
            'type' => 'file',
            'default' => '',
            'after_row' => '</div>',
        ));
    }

    /**
     * Public getter method for retrieving protected/private variables
     * @since  0.1.0
     * @param  string $field Field to retrieve
     * @return mixed          Field value or exception is thrown
     */
    public function __get($field)
    {
        // Allowed fields to retrieve
        if (in_array($field, array('key', 'metabox_id', 'title', 'options_page'), true)) {
            return $this->{$field};
        }
        throw new Exception('Invalid property: ' . $field);
    }

}

/**
 * Helper function to get/return the Myprefix_Admin object
 * @since  0.1.0
 * @return Myprefix_Admin object
 */
function Sogo_admin()
{
    static $object = null;
    if (is_null($object)) {
        $object = new Sogo_Admin();
        $object->hooks();
    }
    return $object;
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key Options array key
 * @return mixed        Option value
 */
function sogo_option($key = '')
{
    return cmb2_get_option(Sogo_admin()->key, $key);
}

// Get it started
Sogo_admin();