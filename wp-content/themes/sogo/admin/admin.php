<?php
/* 
This file handles the admin area and functions.
You can use this file to make changes to the
dashboard. Updates to this page are coming soon.
It's turned off by default, but you can call it
via the functions file.

Developed by: Eddie Machado
URL: http://themble.com/bones/

Special Thanks for code & inspiration to:
@jackmcconnell - http://www.voltronik.co.uk/
Digging into WP - http://digwp.com/2010/10/customize-wordpress-dashboard/

*/

/************* DASHBOARD WIDGETS *****************/

// disable default dashboard widgets
function disable_default_dashboard_widgets()
{
    // remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

    remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
    remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

    // removing plugin dashboard boxes
    remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget

    /*
    have more plugin widgets you'd like to remove?
    share them with us so we can get a list of
    the most commonly used. :D
    https://github.com/eddiemachado/bones/issues
    */
}

/*
For more information on creating Dashboard Widgets, view:
http://digwp.com/2010/10/customize-wordpress-dashboard/
*/

// RSS Dashboard Widget 
function ohav_rss_dashboard_widget()
{
    if (function_exists('fetch_feed')) {
        include_once(ABSPATH . WPINC . '/feed.php');               // include the required file
        $feed = fetch_feed('http://sogo.co.il/feed/rss/');         // specify the source feed
        $limit = $feed->get_item_quantity(7);                      // specify number of items
        $items = $feed->get_items(0, $limit);                      // create an array of items
    }
    if ($limit == 0) echo '<div>The RSS Feed is either empty or unavailable.</div>';   // fallback message
    else foreach ($items as $item) : ?>

        <h4 style="margin-bottom: 0;">
            <a href="<?php echo $item->get_permalink(); ?>" title="<?php echo $item->get_date('j F Y @ g:i a'); ?>"
               target="_blank">
                <?php echo $item->get_title(); ?>
            </a>
        </h4>

    <?php endforeach;
}


function oh_help_dashboard_widget()
{
    echo "ברוכים הבאים לאתר";
}

// calling all custom dashboard widgets
function bones_custom_dashboard_widgets()
{
    add_meta_box('ohav_rss_dashboard_widget', __('Recent Sites'), 'ohav_rss_dashboard_widget', 'dashboard', 'normal', 'core');
    add_meta_box('oh_help_dashboard_widget', __('Updates'), 'oh_help_dashboard_widget', 'dashboard', 'side', 'core');
}


// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');
// adding any custom widgets
add_action('wp_dashboard_setup', 'bones_custom_dashboard_widgets');

//
///************* CUSTOM LOGIN PAGE *****************/
//
//// calling your own login css so you can style it
//function ohav_login_css() {
//	/* i couldn't get wp_enqueue_style to work :( */
//	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/library/css/login.css">';
//}
//
//// changing the logo link from wordpress.org to your site
//function ohav_login_url() { echo bloginfo('url'); }
//
//// changing the alt text on the logo to show your site name
//function ohav_login_title() { echo get_option('blogname'); }
//
//// calling it only on the login page
//add_action('login_head', 'ohav_login_css');
//add_filter('login_headerurl', 'ohav_login_url');
//add_filter('login_headertitle', 'ohav_login_title');


/************* CUSTOMIZE ADMIN *******************/


// Custom Backend Footer
function sogo_custom_admin_footer()
{
    echo '<span id="footer-thank-you">Developed by: <a href="http://sogo.co.il" target="_blank">SOGO, </a></span>.';
}

// adding it to the admin area
add_filter('admin_footer_text', 'sogo_custom_admin_footer');

