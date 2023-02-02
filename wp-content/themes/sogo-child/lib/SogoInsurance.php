<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10/10/2018
 * Time: 1:41 PM
 */

class SogoInsurance
{
    private $data = array(); // hold the $_POST params after verification
    private $tmpArrHova = array();//hold data for api requests
    private $arr_hova = array();//hova companies results from DB

    private $arr_zad_g = array();//zad_g companies results from DB
    private $arr_zad_g_temp = array();//zad_g companies results from DB
    public $ins_type_Arr = array(//allowed insurances
        'MAKIF',
        //'HOVA',
        'ZAD_G',
    );
    private $ins_type = null;//insurance type
    private $ins_order = null;//insurance order id from insurance results page
    private $companies = array();//insurance companies
    private $percent;
    private $codeLevi;// unique code of car
    private $defaultTimeZone;

    public $tmp_mix_array_zad_g = [];

    public function __construct(array $data)
    {
        libxml_use_internal_errors(true);

        $this->set_companies();//setting up insurance companies array
        $this->defaultTimeZone = new DateTime('Asia/Jerusalem');
        $this->parse($data);// setting up default setting array for api`s and db requests

    }

    /**
     * setting up required parameters for Misrad Haozar API
     *
     * @return array
     */
    private function set_params_for_mandatory_insurance()
    {

//		echo '<pre style="direction: ltr;">';
//		var_dump($this->data['body-claims']);
//		echo '</pre>';
        $params_temp = array(
            'hdnForCaptcha' => '',
            // always empty
            'code_owner' => $this->data['ownership'] == 1 ? '1001' : '1002',
            // always
            'insurance_date' => $this->data['insurance_period'],
            //'01/05/2018',
            'parameters[0].parameter' => 'D',
            'parameters[0].value' => $this->data['gender'],
            //'1',  // gender ////1: private, 2: motorcycle, 3: bus , 4: taxi, 5: van, 7: special
            'parameters[1].parameter' => 'D2',
            'parameters[1].value' => $this->data['youngest-driver'],
            //'34', // age
            'parameters[2].parameter' => 'E',
            'parameters[2].value' => $this->data['lowest-seniority'],
            //'0',
            'parameters[3].parameter' => 'F',
            'parameters[3].value' => $this->data['body-claims'] == 1 ? '0' : $this->data['body-claims'] == 2 ? '1' : '0',
            //'0', // number of accident
            'parameters[4].parameter' => 'G',
            'parameters[4].value' => $this->data['license-suspensions'],
            //'parameters[4].value'     => $this->data['law-suites-3-year'],
            //'0', // number of psilot
            'parameters[8].parameter' => 'J',
            'parameters[8].value' => $this->data['abs'] == '1' ? '1' : '2',
            'parameters[9].parameter' => 'K',
            'parameters[9].value' => $this->data['esp'] == '1' ? '1' : '2'
        );

        //verify if vehicle type is private
        if ($this->data['vehicle-type'] == '1') {
            $params_temp['sheet_id'] = '1';
            $params_temp['parameters[5].parameter'] = 'N';
            $params_temp['parameters[5].value'] = $this->data['delek_cd'] != '' ? $this->get_sug_delek($this->data['delek_cd']) : '1';
            $params_temp['parameters[6].parameter'] = 'A';
            $params_temp['parameters[6].value'] = $this->data['engine_capacity']; //'1800', // engine capacity
            $params_temp['parameters[7].parameter'] = 'O';
            $params_temp['parameters[7].value'] = $this->data['koah_sus'] != '' ? $this->data['koah_sus'] : '300';
            $params_temp['parameters[10].parameter'] = 'H';
            $params_temp['parameters[10].value'] = $this->data['air_bags'];
            $params_temp['parameters[11].parameter'] = 'L';
            $params_temp['parameters[11].value'] = $this->data['fcw'] == '1' ? '1' : '2';
            $params_temp['parameters[12].parameter'] = 'M';
            $params_temp['parameters[12].value'] = $this->data['ldw'] == '1' ? '1' : '2';
            $params_temp['parameters[13].parameter'] = 'B';
            $params_temp['parameters[13].value'] = '6';
        } else {
            $params_temp['sheet_id'] = '5';
            $params_temp['parameters[5].parameter'] = 'A';
            $params_temp['parameters[5].value'] = '1';
            $params_temp['parameters[6].parameter'] = 'N';
            $params_temp['parameters[6].value'] = '1';
            $params_temp['parameters[7].parameter'] = 'B';
            $params_temp['parameters[7].value'] = '9';
            $params_temp['parameters[10].parameter'] = 'L';
            $params_temp['parameters[10].value'] = $this->data['fcw'] == '1' ? '1' : '2';
            $params_temp['parameters[11].parameter'] = 'M';
            $params_temp['parameters[11].value'] = $this->data['ldw'] == '1' ? '1' : '2';
            $params_temp['parameters[12].parameter'] = 'H';
            $params_temp['parameters[12].value'] = '4';
        }

        return $params_temp;
    }


    function get_sug_delek($sug_delek){

        switch ($sug_delek) {
            case '1':
                $delek = '1';
            break;
            case '2':
                $delek = '5';
            break;
            case '7':
                $delek = '3';
            break;
            case '4':
                $delek = '6';
            break;
            case '6':
                $delek = '2';
            break;
            case '8':
                $delek = '3';
            break;
            default:
                $delek = '1';
        }
        return $delek;
    }

    /**
     *
     */
    public function mandatory_insurance_prices_results_from_ozar()
    {
        $this->get_data_for_mandatory_insurance_from_ozar();
    }

    function set_companies()
    {
        $companies_settings = array();
        $comp_repeater = get_field('_sogo_insurance_companies', 'option');

        foreach ($comp_repeater as $comp) {

            $companies_settings[$comp['company_id']] = array(
                'company_id' => $comp['company_id'],
                'mf_company_name' => $comp['mf_company_name'],
                'crm_company_name' => $comp['crm_company_name'],
                'company_name' => $comp['company_name'],
                'mandatory_num_payments' => $comp['mandatory_num_payments'],
                'other_num_payments' => $comp['other_num_payments'],
                'other_num_payments_no_percents' => $comp['other_num_payments_no_percents'],
                'use_makif' => $comp['use_makif'],
                'use_zad_g' => $comp['use_zad_g'],
                'use_hova' => $comp['use_hova'],
                'use_comprehensive_package' => $comp['use_comprehensive_package'],
                'comprehensive_package_price' => $comp['comprehensive_package_price'],
                'limited_in_amount' => $comp['limited_in_amount'],
                'fixed_discount' => $comp['fixed_discount'],
                'protection' => $comp['_sogo_protection'],
                'api_exists' => $comp['api_exists'],
                'api_exists_zad3' => $comp['api_exists_zad3'],
                'additional_hova' => $comp['sogo_additional_hova']

            );
        }

        $this->companies = $companies_settings;
    }

    function get_company_id($company_name)
    {
        foreach ($this->companies as $key => $company) {

            if ($company['mf_company_name'] === $company_name) {
                return $company['company_id'];
            }
        }
    }

    /**
     * getting results from Misrad Ha Osar API
     *
     * @param array $args
     *
     * @return array|string
     */
    private function get_misrad_haOzar_mandatory_prices_results(array $args)
    {
//		echo '<pre style="direction: ltr;">';
//		var_dump( $this->data);
//		echo '</pre>';
        $ozar = new ozar_hova($args, $args['vehicle-type']);
//		echo '<pre style="direction: ltr;">';
//		var_dump($args);
//		echo '</pre>';
        $pricesResult = $ozar->connect($args);
        $time_zone = new DateTimeZone('Asia/Jerusalem');

        $ins_period = DateTime::createFromFormat('d/m/Y', $this->data['insurance_period'], $time_zone); //insurance expiring
        $ins_date_finish = DateTime::createFromFormat('d/m/Y', $this->data['insurance-date-finish'], $time_zone); //insurance future expiring
        //	$dayPast         = (int) $ins_date_finish->diff( $ins_period )->format( "%a" ) + 1;
        $dayPast = 366 - (int)$ins_period->format('j');
        //if is no response
        if (!is_array($pricesResult) || empty($pricesResult)) {
            $pricesResult = array();


            foreach ($this->arr_hova as $key => &$part) {
                // calc only if the start date is not the first of the month

                if ($ins_period->format('j') === 1) {
                    $new_price = $this->data['ownership'] == '1' ? $part['privatePrice'] : $part['companyPrice'];
                } else {
                    //which price to use depends on ownership
                    if ($this->data['ownership'] == '1') {
                        $price_day = $part['privatePrice'] / 365;
                    } else {
                        $price_day = $part['companyPrice'] / 365;
                    }
                    $new_price = $price_day * $dayPast;
                }


                //verify discount for ldw - deviation system
                if ($this->data['deviation-system'] == '1') {

                    if (!empty($part['ldwDiscount'])) {
                        $discount_percent = (int)ceil(((int)$part['ldwDiscount'] / 100) * $new_price);
                        $new_price = $new_price - (int)$discount_percent;
                    }
                }

                //verify discount for lcw - keep distance system
                if ($this->data['keeping-distance-system'] == '1') {

                    if (!empty($part['lcwDiscount'])) {
                        $discount_percent = (int)ceil(((int)$part['lcwDiscount'] / 100) * $new_price);
                        $new_price = $new_price - (int)$discount_percent;
                    }
                }

                $part[$key]['price'] = $new_price;

            }

        } else {
            $new_prices = array();

            foreach ($pricesResult as $price) {

                if (empty($price['company']) || empty($price['price']) || strpos($price['price'], '*') !== false) {
                    continue;
                }

                if ($ins_period->format('j') === '1') {

                    $price['price'] = intval(str_replace(',', '', $price['price']));
                } else {
                    $price_day = floatval(str_replace(',', '', $price['price'])) / 365;
                    $price['price'] = (int)ceil($price_day * (int)$dayPast);
                }


                array_push($new_prices, $price);
            }

        }

        return $new_prices;

    }

    /**
     *  assign returned responce from misrad haozar to $this->arr_hova
     * @array $this->arr_hova
     *
     * @return $this
     */
    private function get_data_for_mandatory_insurance_from_ozar()
    {
        if (isset($this->data['vehicle-manufacturer']) && isset($this->data['vehicle-sub-brand']) && isset($this->data['vehicle-brand'])) {
            global $wpdb;
            //if code levi length is 7 its commercial vehicle type, else its private
            $vehicle_type_by_levi = strlen($this->codeLevi);

            /**
             * if in car no search use what we have otherwise use the below
             *     let delek_cd = data.model_info.delek_cd;
            let koah_sus = data.model_info.koah_sus;
            let abs_ind = data.model_info.abs_ind;
            let mispar_kariot_avir = data.model_info.mispar_kariot_avir;
             */

            if(isset($this->data['air_bags']) && !empty($this->data['air_bags'])){

		        $this->data['ldw'] = $this->data['deviation-system'];
                $this->data['fcw'] = $this->data['keeping-distance-system'];
                $this->data['vehicle-type'] = $vehicle_type_by_levi != 7 ? '1' : '5';
                $this->data['engine_capacity'] =  (int)$this->data['engine_capacity'];
                $this->data['air_bags'] = $this->data['air_bags'] ?? 0;

            }else{
                $query = "SELECT engine_capacity, abs, esp, fcw, ldw, air_bags FROM wp_car_models WHERE manufacturer = '{$this->data['vehicle-manufacturer']}' AND `year`='{$this->data['vehicle-year']}' AND model = '{$this->data['vehicle-brand']}' GROUP BY code_levi"; //AND sub_model = '{$this->data['vehicle-sub-brand']}' tell sami to update sub model in the table

                $mandatory_insurance_data = $wpdb->get_results($query, ARRAY_A)[0];

                $this->data['engine_capacity'] = $mandatory_insurance_data['engine_capacity'];
                $this->data['abs'] = $mandatory_insurance_data['abs'];
                $this->data['esp'] = $this->data['stability-system'] ?? $mandatory_insurance_data['esp'];
                $this->data['ldw'] = $this->data['deviation-system'] ?? $mandatory_insurance_data['ldw'];
                $this->data['fcw'] = $this->data['keeping-distance-system'] ?? $mandatory_insurance_data['fcw'];
                $this->data['air_bags'] = $mandatory_insurance_data['air_bags'];
                $this->data['vehicle-type'] = $vehicle_type_by_levi != 7 ? '1' : '5';
            }


            $this->tmpArrHova = $this->set_params_for_mandatory_insurance();

            $this->tmpArrHova['vehicle-type'] = $this->data['vehicle-type'];

//			echo '<pre style="direction: ltr;">';
			//var_dump($mandatory_insurance_data['engine_capacity']);
//			echo '</pre>';
            $result = $this->get_misrad_haOzar_mandatory_prices_results($this->tmpArrHova);
		
			// 8.1.2023 sami set ahshara prices  if amur liot 0
            if ($_GET['insurance-type'] == "HOVA" && $this->data['youngest-driver'] < 24){
				$noYoungsForHovaAhshara = 0;
			}
			else {
				$noYoungsForHovaAhshara = 1;
			}
			
            $tmpHovaArray = array();
            if ($result) {
                foreach ((array)$result as $item) {

                    $company_id = $this->get_company_id($item['company']);
//
                    if ($company_id && (int)$company_id !== 2) {
                        $tmpHovaArray[$company_id] = array(
                            'price' => $item['price'],
                            'mandat_price' => $item['price'],
                            'company_id' => $company_id,
                            //'company'      => $item['company'],
                            'company' => $this->companies[$company_id]['crm_company_name'],//override
                            'additional_hova' => $this->companies[$company_id]["additional_hova"],
                        );

                    }
					// sami fix naheget in hachshara
                    if ($company_id && (int)$company_id === 1 && $this->data['gender'] == 2) {
                        $tmpHovaArray[$company_id] = array(
                            'price' => round($item['price'] * 1.051 * $noYoungsForHovaAhshara),
                            'mandat_price' => round($item['price'] * 1.051 * $noYoungsForHovaAhshara),
                            'company_id' => $company_id,
                            //'company'      => $item['company'],
                            'company' => $this->companies[$company_id]['crm_company_name'], //override
                            'additional_hova' => $this->companies[$company_id]["additional_hova"],
                        );
                    }
					// sami fix also price higher in hachshara when age < 24 for male gender 1
                    if ($company_id && (int)$company_id === 1 && $this->data['gender'] == 1) {
                        $tmpHovaArray[$company_id] = array(
                            'price' => $item['price'] * $noYoungsForHovaAhshara,
                            'mandat_price' => $item['price'] * $noYoungsForHovaAhshara,
                            'company_id' => $company_id,
                            //'company'      => $item['company'],
                            'company' => $this->companies[$company_id]['crm_company_name'], //override
                            'additional_hova' => $this->companies[$company_id]["additional_hova"],
                        );
                    }
					else if ($company_id && (int)$company_id == 2) {
//						echo '<pre style="direction: ltr;">';
//						var_dump($this->companies['20']);
//						echo '</pre>';
                        $tmpHovaArray[$company_id] = array(
                            'price' => $item['price'],
                            'mandat_price' => $item['price'],
                            'company_id' => $company_id,
                            //'company'      => $item['company'],
                            'company' => $this->companies[$company_id]['crm_company_name'],//override
                            'additional_hova' => $this->companies[$company_id]["additional_hova"],
                        );
//                        $tmpHovaArray['20'] = array(
//                            'price' => $item['price'],
//                            'mandat_price' => $item['price'],
//                            'company_id' => $company_id,
//                            //'company'      => $item['company'],
//                            'company' => $this->companies['20']['crm_company_name'],//override
//                        );
                    }

                }
            }

            $this->arr_hova = $tmpHovaArray;
        }

        return $this;
    }

    /**
     * @param $tmpHovaArray
     *
     * @return array
     */
    private function generate_prices_for_hova($tmpHovaArray)
    {
        $tmpArr = [];
        $time_zone = new DateTimeZone('Asia/Jerusalem');
        $ins_period = DateTime::createFromFormat('d/m/Y', $this->data['insurance_period'], $time_zone); //insurance expiring
        $ins_date_finish = DateTime::createFromFormat('d/m/Y', $this->data['insurance-date-finish'], $time_zone); //insurance future expiring

        $dayPast = $ins_date_finish->diff($ins_period)->format("%a");

        //which price to use depends on ownership
        if ($this->data['ownership'] == '1') {
            $price_day = $tmpHovaArray['privatePrice'] / 365;
        } else {
            $price_day = $tmpHovaArray['companyPrice'] / 365;
        }

        $new_price = $price_day * $dayPast;

        //verify discount for ldw - deviation system
        if ($this->data['deviation-system'] == '1') {

            if (!empty($tmpHovaArray['ldwDiscount'])) {
                $discount_percent = (int)ceil(((int)$tmpHovaArray['ldwDiscount'] / 100) * $new_price);
                $new_price = $new_price - (int)$discount_percent;
            }
        }

        //verify discount for lcw - keep distance system
        if ($this->data['keeping-distance-system'] == '1') {

            if (!empty($tmpHovaArray['lcwDiscount'])) {
                $discount_percent = (int)ceil(((int)$tmpHovaArray['lcwDiscount'] / 100) * $new_price);
                $new_price = $new_price - (int)$discount_percent;
            }
        }


        $company = sogo_get_company_name($tmpHovaArray['companyId']);

        $tmpArr['mandat_price'] = (int)ceil($new_price);//new calculated price
        $tmpArr['price'] = (int)ceil($new_price);//new calculated price
        $tmpArr['company_id'] = $tmpHovaArray['companyId'];
        $tmpArr['company'] = $company;

        return $tmpArr;

    }

    /**
     * @param array $comArgs
     */
    public function set_insurance_companies(array $comArgs)
    {
        $this->companies = $comArgs;
    }

    /**
     * @return array
     */
    public function get_insurance_companies(): array
    {
        return $this->companies;
    }


    /**
     * @param array $args
     */
    private function parse(array $args)
    {

        if (isset($_GET['insurance-type'])
            && !empty($_GET['insurance-type'])
            && in_array($_GET['insurance-type'], $this->ins_type_Arr)) {
            $this->ins_type = trim($_GET['insurance-type']);
        }

        if (isset($_GET['ins_order']) && !empty($_GET['ins_order'])) {
            $this->ins_order = trim($_GET['ins_order']);
        }

        $defaults = array(
            'esp' => '',
            'vehicle-manufacturer' => '',
            'air_bags' => '',
            'insurance_period' => '',
            'youngest-driver' => '',
            'lowest-seniority' => '',
            'license-suspensions' => '',
            'gender' => '',
            'law-suite-what-year' => '',
            'insurance-1-year' => '',
            'insurance-2-year' => '',
            'insurance-3-year' => '',
            'keeping-distance-system' => '',
            'law-suites-3-year' => '',
            'ownership' => '',
            'deviation-system' => '',
            'drive-allowed-number' => '',
            'insurance-date-finish' => '',
            'vehicle-year' => '',
            'insurance-type' => '',
            'insurance-before' => '',
            'engine_capacity' => '',
            'levi-code' => '',
            'driver-birthday' => '',
            'drive-on-saturday' => '',

        );

        $this->codeLevi = (isset($args['levi-code']) ? $args['levi-code'] : sogo_get_levi_code($args));

        $this->data = wp_parse_args($args, $defaults);

        if (empty($this->data)) {
            $this->data['levi-code'] = $this->codeLevi;
        }


    }

    private function set_hova()
    {
        $startMemory = memory_get_usage();
        $this->logmem("start hova"  , $startMemory);



        $this->arr_hova = []; // for tests
        $this->get_data_for_mandatory_insurance_from_ozar();
        $this->logmem( "ozar: " , $startMemory);
     //   $hova_ozar = $this->arr_hova;
        //	if ( empty( $this->arr_hova ) ) {

        $this->set_hova_from_db();
        $this->logmem('DB end',$startMemory);

        $temp = array();
        foreach ($this->arr_hova as $key => $item) {
            if ($item['mandat_price'] > 0) {
                $temp[$key] = $item;
            }
        }

        $this->arr_hova = $temp;


        //	}

    }
    function format_number(float $d): string {
        $e = (int)(log10($d) / 3);
        return sprintf('%.3f', $d / 1e3 ** $e) . ['', ' k', ' M', ' G'][$e];
    }
    public function logmem($obj, $startMemory){
        $memusage  =  memory_get_usage() - $startMemory;
        $memusage = $this->format_number($memusage);

        $obj .= " Memory: $memusage  ";
        file_put_contents(__DIR__ . '/hova.log', date('Y-m-d H:i:s')  . ":" . $obj . "\n", FILE_APPEND);

    }

    private function set_hova_from_db()
    {
        global $wpdb;
        $esp = isset($this->data['stability-system']) ? $this->data['stability-system'] : $this->data['esp'];
//		if(isset($_GET['oren'])){
//
//
//			var_dump($this->data['stability-system'] );
//			var_dump($this->data['esp'] );
//		}else{
//
//		}
        if (!isset($this->data['stability-system'])) {
            // sami asked to change the values 1 =2 and 2 = 1
            $esp = $esp == "0" ? 1 : 2;//if no, set 1 else set 2 if exists
        } else {
            // sami asked to change the values 1 =2 and 2 = 1
            $esp = $esp == "2" ? 1 : 2;//if no, set 1 else set 2 if exists
        }

        $karit = empty($this->data['air_bags']) ? '0' : $this->data['air_bags'];


        $time_zone = new DateTimeZone('Asia/Jerusalem');
        $ins_period = DateTime::createFromFormat('d/m/Y', $this->data['insurance_period'], $time_zone);
        $ins_period->setTime(9, 00);//set time of date to morning

        $day = $ins_period->format('j');
        $month = $ins_period->format('n');
        $year = $ins_period->format('Y');

        $code_levi = sogo_get_levi_code();

        $table = $wpdb->prefix . 'hova_ins';

        //remove all leading zeros from levi code
        $code_levi = ltrim($code_levi, '0');

        //if code levi length is 7 its commercial vehicle type, else its private
        $vehicle_type_by_levi = strlen($code_levi);

        $vehicle_type_by_levi = $vehicle_type_by_levi != 7 ? 1 : 2;
        $orderby = '';
        $query = "SELECT * FROM {$table} ";


        $query .= " WHERE (carType = {$vehicle_type_by_levi} or carType = 0)";
        if ($this->data['ownership'] == 1) {
            $query .= " AND (privatePrice > 0) ";
            $orderby = ' privatePrice ';
        } else {
            $query .= "AND (companyPrice > 0) ";
            $orderby = ' companyPrice ';
        }
        $query .= "and (ageStart <= {$this->data['youngest-driver']}) 
              and (ageEnd >= {$this->data['youngest-driver']}) 
              and (engineStart <= {$this->data['engine_capacity']}) 
              and (engineEnd >= {$this->data['engine_capacity']}) 
              and (vetekStart <= {$this->data['lowest-seniority']}) 
              and (vetekEnd >= {$this->data['lowest-seniority']}) 
              and (karit <= {$karit}) 
              and (karitEnd >= {$karit}) 
              and (esp = {$esp}) 
              and (min = {$this->data['gender']} or min = 0)
              and (shlilotM = {$this->data['license-suspensions']}) 
              and (month = {$month}) 
              and (year = {$year}) 
              and (fromDay <= {$day}) 
              and (lastDay >= {$day}) 
              ORDER BY {$orderby} ASC";

        if (isset($_GET['oren'])) {
            var_dump($query);
        }
        $arr_hova_temp = $wpdb->get_results($query, ARRAY_A);

//		echo '<pre style="direction: ltr;">';
//		var_dump($arr_hova_temp);
//		echo '</pre>';
        foreach ($arr_hova_temp as $row) {
            if (isset($this->arr_hova[$row['companyId']])) {
                if ($this->arr_hova[$row['companyId']]['mandat_price'] == 0) {
                    $this->arr_hova[$row['companyId']] = $this->generate_prices_for_hova($row);
                }
            } else {
                $this->arr_hova[$row['companyId']] = $this->generate_prices_for_hova($row);
            }

        }

    }


    private function prepare_insurance_api()
    {
        global $wpdb;

        $this->set_hova();

        //$time_zone         = new DateTimeZone( 'Asia/Jerusalem' );
        $ins_period_saved = $this->data['insurance_period'];
        $date_finish_saved = $this->data['insurance-date-finish'];

        $time_zone = new DateTimeZone('Asia/Jerusalem');
        $ins_period = DateTime::createFromFormat('d/m/Y', $ins_period_saved, $time_zone); //insurance expiring
        $ins_date_finish = DateTime::createFromFormat('d/m/Y', $date_finish_saved, $time_zone); //insurance future expiring
        $ins_start_day = $ins_period->format('d');
        $ins_end_day = $ins_date_finish->format('d');
        $dayPast = $ins_date_finish->diff($ins_period)->format("%a");

//		$insuranceDays   = ( 365 - $dayPast );
        $insuranceDays = (int)$dayPast + 1;
        $this->percent = $insuranceDays / 365;
        $code_levi = sogo_get_levi_code($this->data);
        //remove all leading zeros from levi code
        $code_levi = ltrim($code_levi, '0');

        //if code levi length is 7 its commercial vehicle type, else its private
        $vehicle_type_by_levi = strlen($code_levi);
        $vehicle_type_by_levi = $vehicle_type_by_levi != 7 ? 1 : 2;

        //$time_zone = new DateTimeZone( 'Asia/Jerusalem' );

        $car_year = DateTime::createFromFormat('Y', $this->data['vehicle-year'], $time_zone);
        $current_year = new DateTime;
        $current_year->format("Y");
        //get car age
        $car_age = $current_year->diff($car_year)->y;

        $year_taarif = (int)$ins_period->format('Y');
        $month_taarif = (int)$ins_period->format('m');

        $law_suites = 0;


        $year1 = $this->data['insurance-1-year'];
        $year2 = $this->data['insurance-2-year'];
        $year3 = $this->data['insurance-3-year'];
        $one_law_siut = $this->data['law-suites-3-year'];
        $insurance_before = $this->data['insurance-before'];
        $insurance_sequence = 0;

        if ($insurance_before != 2) {

            if ($one_law_siut == 1) {

                $low_suites_years_before = $this->data['law-suite-what-year'];

                switch ($low_suites_years_before) {
                    case '1':
                        $insurance_sequence = 0;
                        break;
                    case '2':
                        if ($year1 == 3) {
                            $insurance_sequence = 0;
                        } else {
                            $insurance_sequence = 1;
                        }
                        break;
                    case '3':
                        if ($year1 == 3) {
                            $insurance_sequence = 0;
                        } else if ($year2 == 3) {
                            $insurance_sequence = 1;
                        } else {
                            $insurance_sequence = 2;
                        }
                        break;
                }

            } else {

                if ($year1 == 3) {
                    $insurance_sequence = 0;
                } else if ($year2 == 3) {
                    $insurance_sequence = 1;
                } else if ($year3 == 3) {
                    $insurance_sequence = 2;
                } else if ($one_law_siut == 0) {
                    $insurance_sequence = 3;
                }
            }
        if ($this->data['law-suites-3-year'] == 2) {
                    $insurance_sequence = 99;
        }
		}

        $operator = '<=';
        //$operator  = $insurance_sequence == '0' ? '=' : '<=';
        $operator2 = '>=';
        //$operator2 = $insurance_sequence == '0' ? '=' : '>=';

        global $wpdb;

        $query = "SELECT DISTINCT * FROM wp_zad_g 
              WHERE 1 
              and (startAge <= {$this->data['youngest-driver']} or startAge = -1) 
              and (endAge >= {$this->data['youngest-driver']} or endAge = -1) 
              and (startVetek <= {$this->data['lowest-seniority']} or startVetek = -1) 
              and (endVetek >= {$this->data['lowest-seniority']} or endVetek = -1) 
              and carType = {$vehicle_type_by_levi} 
              and (startCarAge <= {$car_age} or startCarAge = -1) 
              and (endCarAge >= {$car_age} or endCarAge = -1) 
              and (ownerShip = {$this->data['ownership']} or ownerShip = -1) 
              and (startHiaderTviot {$operator} {$insurance_sequence}) 
              and (endHiaderTviot {$operator2} {$insurance_sequence}) 
              and (startDrivers <= {$this->data['drive-allowed-number']}) 
              and (endDrivers >= {$this->data['drive-allowed-number']}) 
              and (yearTaarif={$year_taarif} or yearTaarif= -1) 
              and (monthTaarif={$month_taarif} or monthTaarif= -1) 
              and (fromDay <= {$ins_start_day} and lastDay >= {$ins_start_day})
          
              ORDER BY (priceNormal + havila) ASC";
//


        $results = $wpdb->get_results($query, ARRAY_A);

        foreach ($results as $item) {
            // enter only rows that have price
            $price = $item['priceBitul'] != "0" ? $item['priceBitul'] : $item['priceNormal'];

            $item['price_havila'] = $item['havila'];

            if (absint($price) > 0) {
                $item['price'] = $price;
                $this->arr_zad_g_temp[$item['compId']] = $item;
            }

        }

        $this->set_prices_for_insurance_api();
    }


    private function get_api_results($companySettings)
    {

        $data = $this->data;

        //$data['levi-code'] = $this->codeLevi;

        //verify if was insurance before
        if ($this->data['insurance-before'] == '1') {
            $data['youngest-driver'] = $this->data['youngest-driver'];
            $data['lowest-seniority'] = $this->data['lowest-seniority'];
            $data['insurance-1-year'] = $this->data['insurance-1-year'];
            $data['insurance-2-year'] = $this->data['insurance-2-year'];
            $data['insurance-3-year'] = $this->data['insurance-3-year'];
            $data['law-suites-3-year'] = $this->data['law-suites-3-year'];
        }

//		echo '<pre style="direction: ltr;">';
//		var_dump($data);
//		echo '</pre>';

        $apiResult = $this->get_api_response($companySettings, $data);
        // if zag g block discount and price limit
        if (isset($_GET['insurance-type']) && $_GET['insurance-type'] == 'ZAD_G') {
            return $apiResult;
        }


        //TODO check api results and return none if it empty
        //	if ( ! (bool) $this->data['law-suites-3-year'] ) {

        $disc_price_temp = sogo_verify_discount(
            $apiResult,
            $companySettings,
            $this->data['youngest-driver'],
            $this->data['lowest-seniority'],
            $this->data['law-suites-3-year'],
            $this->data['insurance-1-year'],
            $this->data['insurance-2-year'],
            $this->data['insurance-3-year']
        );

        $apiResult['comprehensive'] = $disc_price_temp == false ? $apiResult['comprehensive'] : $disc_price_temp;


        return $apiResult;
        //	}
    }

    private function get_api_response($companySettings, $data)
    {

        $results = array();
//        if ($companySettings['company_id'] !== "11") {
//            return $results;
//        }
        switch ($companySettings['company_id']) {
            case '7':

                // Shomera *******************
                $shomera = new Shomera($companySettings);


                $results = $shomera->calc_price($data);

                return $results;
                break;
            case '71':

                // Shomera *******************
                $shomera = new Shomera($companySettings);


                $results = $shomera->calc_price_csharp($data);

                return $results;
                break;

            case '44'://disable api request
            case '4':

                // ayalon *******************
                $ayalon = new Ayalonws($companySettings);


                $results = $ayalon->calc_price($data);

                return $results;
                break;


            case '44'://disable api request
            case '4905':

                // ayalon *******************
                $ayalon = new Ayalonws($companySettings);


                $results = $ayalon->calc_price4905($data);

                return $results;
                break;				

            case '8':
            case '88'://disable api request
                // shirbit *******************

                $shirbit = new shirbitws($companySettings);
                $results = $shirbit->calc_price($data);

                return $results;
                break;

            case '1':
            case '111'://disable api request

                // hachshara ***************************************
                $hachshara = new hachsharaws($companySettings, $this->ins_type);
                $results = $hachshara->calc_price($data);

                return $results;
                break;
				

            case '742':
            case '111'://disable api request

                // hachshara ***************************************
                $hachshara = new hachsharaws($companySettings, $this->ins_type);
                $results = $hachshara->calc_price_bestCarPlus($data);

                return $results;
                break;

            case '11':

//			case '1111'://disable api request

                $shlomo = new Shlomo($companySettings);
                $results = $shlomo->calc_price($data);

                return $results;
                break;
            case '11325':

//			case '1111'://disable api request

                $shlomo = new Shlomo($companySettings);
                $results = $shlomo->calc_price_325($data);

                return $results;
                break;
            case '11328':

//			case '1111'://disable api request

                $shlomo = new Shlomo($companySettings);
                $results = $shlomo->calc_price_328($data);

                return $results;
                break;
				
            case '1132850':

//			case '1111'://disable api request

                $shlomo = new Shlomo($companySettings);
                $results = $shlomo->calc_price_32850($data);

                return $results;
                break;
				
            case '11327':

//			case '1111'://disable api request

                $shlomo = new Shlomo($companySettings);
                $results = $shlomo->calc_price_327($data);

                return $results;
                break;
				
            case '5': //wrong version
                $menora = new menoraws($companySettings);
                $results = $menora->calc_price($data);

                return $results;
                break;
            case '51':
                $menora = new menoraws($companySettings);
                $results = $menora->calc_price51($data);

                return $results;
                break;

            case '9':
                //	case '9999'://disable api request
                $clal = new Clal($companySettings);
                $results = $clal->calc_price($data);

                return $results;
                break;
            case '91': // clall green
                //	case '9999'://disable api request
                $clal = new Clal($companySettings);
                $results = $clal->calc_price_green_1($data);
                return $results;
                break;
            case '92': // clall green
                //	case '9999'://disable api request
                $clal = new Clal($companySettings);
                $results = $clal->calc_price_green_2($data);

                return $results;
                break;
            
			// 24.6.2022 GO STOPED TO GIVE US API SO I CANCEL FOR FASTER RESULTS	
			// case '60':
            //	case '9999'://disable api request
            //    $go = new GoWs($companySettings);
            //    $results = $go->calc_price($data);

            //    return $results;
            //    break;
            default:
                return false;
                break;
        }
    }

    /**
     *  get a row from our DB and return array with the calc price
     *
     * @param $zad_g
     */
    private function set_prices_for_insurance_api()
    {

        $insType = $this->ins_type === 'MAKIF' ? 4 : 5;
        $this->data['code-levi'] = $this->codeLevi;
        $this->data['ins-type'] = $insType;


        //if insurance makif we use
        $apiArr = ($this->ins_type === 'MAKIF' ? $this->companies : $this->arr_zad_g_temp);
//		$apiArr = $this->companies;

        foreach ($apiArr as $company_id => $insurance_zad) {


            if (!array_key_exists('compId', $insurance_zad)) {
                $insurance_zad['compId'] = $insurance_zad['company_id'];
            }

            if (!array_key_exists('price_havila', $insurance_zad)) {
                $insurance_zad['price_havila'] = $insurance_zad['havila'];
            }

            $insurance_zad['company_fake_name'] = $this->companies[$insurance_zad['compId']]['company_name'];

            $company_settigns = $this->companies[$company_id];

            $insurance = array();

            if ($company_settigns['api_exists'] === true && $this->ins_type == 'MAKIF') {

                $insurance = $this->get_api_results($this->companies[$company_id], $insurance_zad['compId']);

                $insurance['company'] = (!empty($company_settigns['crm_company_name']) ? $company_settigns['crm_company_name'] : $company_settigns['company_name']);

                //add havila of comprehensive insurance if switch is on to use it in admin
                if ($company_settigns['use_comprehensive_package'] === true) {
                    $insurance['price_havila'] = (int)$company_settigns['comprehensive_package_price'];
                    $insurance['comprehensive'] = (int)$insurance['comprehensive'] + (int)$insurance['price_havila'];
                }

            } else if ($this->ins_type == 'ZAD_G' && $company_settigns['api_exists_zad3'] === true) {

                $insurance = $this->get_api_results($this->companies[$company_id], $insurance_zad['compId']);
                $insurance['company'] = (!empty($company_settigns['crm_company_name']) ? $company_settigns['crm_company_name'] : $company_settigns['company_name']);
                $insurance['price_havila'] = $insurance_zad['havila'];
                $insurance['comprehensive'] = (int)$insurance['comprehensive'] + (int)$insurance['price_havila'];

            } else { // we dont have APi for that company

                //verify if no prices in zad g from db
                if (empty($insurance_zad['priceBitul']) && empty($insurance_zad['priceNormal'])) {
                    continue;
                }

                if ($insurance_zad['priceBitul'] > 0) {
                    // use price normal when it is ok for others.
                    $insurance['comprehensive'] = intval($insurance_zad['priceBitul'] * $this->percent) + $insurance_zad['havila'];
                } else {
                    $insurance['comprehensive'] = intval($insurance_zad['priceNormal'] * $this->percent) + $insurance_zad['havila'];
                }

                $insurance['gvul'] = $insurance_zad['gvul'];
                $insurance['axes'] = $insurance_zad['axes'];
                $insurance['hagana'] = $insurance_zad['hagana'];
                $insurance['grira '] = $insurance_zad['grira'];
                $insurance['shmashot'] = $insurance_zad['shmashot'];
                $insurance['radio'] = $insurance_zad['radio'];
                $insurance['hearotKlali'] = $insurance_zad['hearotKlali'];
                $insurance['compHavila'] = $insurance_zad['compHavila'];
                $insurance['price_havila'] = $insurance_zad['price_havila'];
                $insurance['message'] = $insurance_zad['message'];


                $insurance['protect'] = '';
                $insurance['protect_id'] = '';
                $insurance['id'] = $company_id;


                if (isset($this->arr_hova[$company_id])) {
                    //$insurance['company'] = $this->companies[ $insurance_zad['compId'] ]['crm_company_name'];
                    //$insurance['company']    = $this->arr_hova[ $company_id ]['company'];
                    $insurance['company_id'] = $company_id;
                    $insurance['mandatory'] = intval(preg_replace('/[^\d.]/', '', $this->arr_hova[$company_id]['price']));
                }
            }

            /**
             * end zad 3 and mekif
             */

            if ($insurance) {
                $insurance['company'] = (!empty($company_settigns['crm_company_name']) ? $company_settigns['crm_company_name'] : $company_settigns['company_name']);
                $insurance['message'] = $this->arr_zad_g_temp[$company_id]['message'];
                $this->arr_zad_g[$insurance_zad['compId']] = $insurance;

                if ($insurance_zad['priceNormal'] > 0) {
                    $this->tmp_mix_array_zad_g[$insurance_zad['compId']] = $insurance;
//					$this->tmp_mix_array_zad_g[$insurance_zad['compId']]['company'] = $insurance;
                    $this->tmp_mix_array_zad_g[$insurance_zad['compId']]['mandatory'] = 0;
                    $this->tmp_mix_array_zad_g[$insurance_zad['compId']]['comprehensive'] = intval($insurance_zad['priceNormal'] * $this->percent) + $insurance_zad['havila'];
                    $this->tmp_mix_array_zad_g[$insurance_zad['compId']]['comprehensive_normal'] = intval($insurance_zad['priceNormal'] * $this->percent) + $insurance_zad['havila'];
                }
            }
//			echo '<pre style="direction: ltr;">';
//			var_dump($this->tmp_mix_array_zad_g);
//			echo '</pre>';
        }
    }

    /*
     * @todo: remove this function if no use
     */
    public function check_price_for_discount_from_db_deprecated($company_id, array $params)
    {
        global $wpdb;

        if (is_null($company_id) || intval($company_id) !== (int)$company_id) {
            return false;
        }

        $sql = "SELECT DISTINCT `discount_prcent` FROM `wp_insurance_discount`";
        $sql .= " WHERE `comany_id`=" . $company_id;
        $sql .= " AND `young_driver_age`>=" . $company_id;
        $sql .= " AND `driving_seniority`>=" . $company_id;
        $sql .= " AND `insurance_num_years`>=" . $company_id;
        $sql .= " AND `num_claims`=" . $company_id;

        $result = $wpdb->get_results($sql, ARRAY_A);

        return $result;
    }

    /**
     * Get array of mandatory insurance from ozar or db for mix with third party insurance
     *
     * @return array
     */
    public function get_arr_hova_for_mix()
    {
        return $this->arr_hova;
    }

    /**
     * Get third party insurance array for mix with mandatory insurance if price normal is > 0
     *
     * @return array
     */
    public function get_arr_zad_g_for_mix()
    {
        return $this->tmp_mix_array_zad_g;
    }

    /**
     * @return array
     */
    public function get_hova(): array
    {
        $this->set_hova();

        return $this->arr_hova;
    }

    /**
     * @return array
     */
    public function get_insurance_api_results(): array
    {
        $this->prepare_insurance_api();

        return $this->arr_zad_g;
    }

}
