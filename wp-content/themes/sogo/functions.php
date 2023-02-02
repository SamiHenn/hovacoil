<?php
/**
 * Inlucde the TGM for plugins
 */
require_once get_template_directory() . '/TGM/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'sogo_register_required_plugins' );
function sogo_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin bundled with a theme.
        array(
            'name'               => 'ACF', // The plugin name.
            'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/TGM/plugins/advanced-custom-fields-pro.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),
        // Duplicate post
        array(
            'name'        => 'Contact Form 7',
            'slug'        => 'contact-form-7',
            'is_callable' => '',

        ),
        // Duplicate post
        array(
            'name'        => 'Smushit',
            'slug'        => 'wp-smushit',
            'is_callable' => '',

        ),
  // Duplicate post
        array(
            'name'        => 'WP-PageNavi',
            'slug'        => 'wp-pagenavi',
            'is_callable' => '',

        ),

        // YOAST
        array(
            'name'        => 'WordPress SEO by Yoast',
            'slug'        => 'wordpress-seo',
            'is_callable' => 'wpseo_init',
            'required'           => true,
        ),
        // Duplicate post
        array(
            'name'        => 'Duplicate Post',
            'slug'        => 'duplicate-post',
            'is_callable' => '',

        ),

    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id'           => 'sogoc',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.


    );

    tgmpa( $plugins, $config );
}

/*
 * debug a given object in a nice way
 *
 * */
function debug($obj)
{
	echo "<pre dir='rtl' style='text-align:left'>";
    print_r( $obj );
    echo "</pre>";
}




$sogo_includes = array(
    'admin/admin.php',                              // Admin functions
    'lib/init.php',                                 // register items
    'lib/tinymce/tinymce-buttons.php',                                 // register items
    'lib/enqueue.php',                              // load scripts
    'lib/post-types.php',                           // register post type
    'lib/extras.php',                               // Sogo custom functions
    'lib/excerpt.php',                              // Initial theme setup and constants
    'lib/widget.php',                               // Initial theme setup and constants
);
sogo_include($sogo_includes);

function sogo_include($sogo_includes)
{

    foreach ($sogo_includes as $file) {
        if (!$filepath = locate_template($file)) {
            trigger_error(sprintf(__('Error locating %s for include', 'sogo'), $file), E_USER_ERROR);
        }
        require_once $filepath;
    }
    unset($file, $filepath);
}

function sogo_main_class_autoload($sogo_includes)
{

  foreach (glob(dirname(__FILE__) . "/lib/class/*.php") as $filename) {
    $sogo_includes[] = "lib/class/" . basename($filename);
  }
  // parent function.
  return $sogo_includes;
}


function sogo_theme_setup()
{
    // load text domain
    load_theme_textdomain('sogo', get_template_directory() . '/languages');

}

add_action('after_setup_theme', 'sogo_theme_setup');

// home slider
function sogo_get_slider( $slider_key = '_sogo_slider' ) {
    if(function_exists('have_rows')){
        $slider = new sogo\slider( $slider_key );

        return $slider -> get_slider();
    }

}

/**
 * Replace mvc
 * only var like varname or array value like arrname.varname
 * short if like varname==8?hhhh output be hhhh if varname eq to 8
 * @param string $mvc html template
 * @param mixed $vars array or object with all mvc usage params
 * @return string
*/
function sogo_parse_template( $mvc, $vars = null ) {
  $vars = empty($vars) ? $GLOBALS : $vars;

  if (preg_match_all('#{{(.+)([=|!]=(.*)\?(.+)|\((.*)\))?}}#Uuims', $mvc, $checks)) {
    $replacesIn = array();
    $replacesOut = array();


    foreach ($checks[1] as $key => $var) {
      $var = explode('.', $var);
      $value = '';

      if (is_array($var)) {
        $isArr = is_array($vars);
        foreach ($var as $idx => $subvar) {
          if (strpos($checks[2][$key], '(') === 0) {
            if ($value == '') {
              if (empty($var[$idx + 1]))
                $value = $isArr ? $vars[$subvar]($checks[5][$key]) : $vars->$subvar($checks[5][$key]);
              else
                $value = $isArr ? $vars[$subvar] : $vars->$subvar;
            }
            else {
              if (empty($var[$idx + 1]))
                $value = $isArr ? $value[$subvar]($checks[5][$key]) : $value->$subvar($checks[5][$key]);
              else
                $value = $isArr ? $value[$subvar] : $value->$subvar;
            }
          }
          else {

            if ($value == '') {
              $value = $isArr ? $vars[$subvar] : $vars->$subvar;
            } else {
              $isArr = is_array($value);
              if (($isArr && isset($value[$subvar])) || (is_object($value) && isset($value->$subvar)))
                $value = $isArr ? $value[$subvar] : $value->$subvar;
            }
          }
        }
      } else
        $value = $vars[$var];

      if (empty($checks[2][$key])) {
        $replacesIn[] = $checks[0][$key];
        $replacesOut[] = $value;
      } else {
        if ((is_array($value) && in_array($checks[4][$key], $value)) || $checks[3][$key] == $value) {
          $replacesIn[] = $checks[0][$key];
          $replacesOut[] = $checks[4][$key];
        } else if (!empty($value)) {
          $replacesIn[] = $checks[0][$key];
          $replacesOut[] = $value;
        } else {
          $replacesIn[] = $checks[0][$key];
          $replacesOut[] = '';
        }
      }
    }
    $mvc = str_replace($replacesIn, $replacesOut, $mvc);
  }
  return $mvc;
}

/**
 * Verify insurance discount
 * @param $insurance_company_array
 * @param $insurance_company
 * @param $youngest_driver
 * @param $lowest_seniority
 * @param $insurance_1_year
 * @param $insurance_2_year
 * @param $insurance_3_year
 *
 * @return bool|int
 */
function sogo_verify_discount($insurance_company_array, $insurance_company, $youngest_driver, $lowest_seniority, $law_suites_3_year, $insurance_1_year, $insurance_2_year, $insurance_3_year){
//	$new_total_price = (int) $insurance_company_array['mandatory'] + (int) $insurance_company_array['comprehensive'];

	$comprehensive = (int) $insurance_company_array['comprehensive'];
	if ( !empty($comprehensive) ) {
		$comp_id = $insurance_company['company_id'];
		$limited_in_amount = $insurance_company['limited_in_amount'];

		$insurance_years = 0;

		if ( $insurance_1_year != 3 ) {
			$insurance_years ++;
		}

		if ( $insurance_2_year != 3 ) {
			$insurance_years ++;
		}

		if ( $insurance_3_year != 3 ) {
			$insurance_years ++;
		}

		global $wpdb;

		$table = $wpdb->prefix . 'insurance_discount';

	//	$query = "SELECT * FROM {$table} WHERE company_id = {$comp_id} AND young_driver_age >= {$youngest_driver} AND driving_seniority = {$lowest_seniority} AND insurance_num_years = {$insurance_years} AND num_claims = {$law_suites_3_year}";
		$query = "SELECT * FROM {$table} WHERE 
											company_id = {$comp_id} AND
											young_driver_age <= {$youngest_driver} AND 
											driving_seniority <= {$lowest_seniority} AND 
											insurance_num_years <= {$insurance_years} AND 
											num_claims <= {$law_suites_3_year} 
											order by young_driver_age desc limit 1";
//		var_dump($query); die();
		//get discount from db
		$db_discount = $wpdb->get_row($query);

		// reset total price to what we got from the api
		$total_price = $comprehensive ;
		// found discount calc it.
		if($db_discount){
				$percentage = $db_discount->discount_prcent;
				$discount_value = $comprehensive - ((int) ceil((float) $percentage * $comprehensive ));
				$total_price = $comprehensive - (int)$discount_value;
		}

		/**
		 * calc the price based on what we have in the ACF
		 */
		$fixed_discount = $insurance_company['fixed_discount'];

		//verify if set fixed discount
		if(!empty($fixed_discount)){
			if(strpos($fixed_discount, '+') !== false){
				$splited_discount = explode('+', $fixed_discount);
				$total_price = $total_price + (int)$splited_discount[1];
			}

			if(strpos($fixed_discount, '-') !== false){
				$splited_discount = explode('-', $fixed_discount);
				$total_price = $total_price - (int)$splited_discount[1];
			}
		}

		//check if total price is less than limit discount price
		//total equal to limit price
		if($total_price < (int)$limited_in_amount){
			$total_price = (int)$limited_in_amount;
		}

		return $total_price;
	}
	else{
		return false;
	}
}