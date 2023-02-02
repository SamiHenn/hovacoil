<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/12/2017
 * Time: 10:35 AM
 */

class menoraws
{
    private $api_url;
    private $params;
    private $soap;
    private $xml_obj;
    private $response;
    private $company;

    public function __construct($companySettings)
    {
        //	$this->api_url = "https://ext-api.menora.co.il/CarInsQuote?WSDL";
//		$this->api_url = "https://xgw.menora.co.il/CarInsQuoteQA?WSDL";
//		$this->api_url = "https://ext-api.menora.co.il:44430/CarInsQuoteQA?WSDL";
        $this->api_url = dirname(__FILE__) . '/m1mnkola11.wsdl';
        $certificate = dirname(__FILE__) . '/cert.pem';
        $options = array();


        $options['cache_wsdl'] = WSDL_CACHE_NONE;
        $options['trace'] = true;
        $options['exceptions'] = true;
        $options['local_cert'] = $certificate;
//		$options['passphrase'] = '1C3Tfj0-\Fz{$Y8c!';
//		$options['stream_context'] =$context;
//		$certificate   = dirname( __FILE__ ) . '/ws-hova.pem';
        $options = array();
        $context = stream_context_create(array(
            'ssl' => array(
                'verify_peer' => true,
                'verify_peer_name' => true,
                'allow_self_signed' => true
            )
        ));


        $options['cache_wsdl'] = WSDL_CACHE_NONE;
        $options['trace'] = true;
        $options['exceptions'] = true;
        $options['local_cert'] = $certificate;
        $options['passphrase'] = '1C3Tfj0-\Fz{$Y8c';
        $options['stream_context'] = $context;
        //$options['env'] = 'TV';

        try {


            $this->soap = new SoapClient($this->api_url, $options);

            $env = array(
                'env' => 'TV',

            );
            $header = new SoapHeader('http://www.shellWiz.com/shellWizHeader/v1.0', 'ShellWizHeader', $env, false);
            $this->soap->__setSoapHeaders($header);

        } catch (Exception $e) {

         //   echo $e->getMessage(), '<br />', $e->getTraceAsString();
        }


    }

    public function calc_price(array $args)
    {

        if (empty($args['levi-code'])) {
            return false;
        }
		if (((int)$args['insurance-1-year'] === 3) && ((int)$args['insurance-2-year'] === 3) && ((int)$args['insurance-3-year'] === 3) || ((int)$args['insurance-before'] === 2) || ((int)$args['law-suites-3-year'] === 2)) {
			return false;
	}
		if (((int)$args['insurance-1-year'] !== 3) && ((int)$args['insurance-2-year'] === 3) && ((int)$args['insurance-3-year'] === 3) && ((int)$args['law-suites-3-year'] === 1)) {
			return false;
	}
        $time_zone = new DateTimeZone('Asia/Jerusalem');
        //setup start date ************
        $start = str_replace('/', '-', $args['insurance_period']);
        $start_date = new DateTime($start, $time_zone);
        $start_date_formatted = (int)$start_date->format('Ymd');

        //setup end date ************
        $end = str_replace('/', '-', $args['insurance-date-finish']);
        $end_date = new DateTime($end, $time_zone);
        $end_date_formatted = (int)$end_date->format('Ymd');

        //setup youngest driver age *************
        $today = new DateTime('now', $time_zone);
        $youngest_age = $today->modify('-' . $args['youngest-driver'] . ' year');
        $youngest_age_formatted = $youngest_age->format('Ymd');

        //setup Rishayon Date *************
        $today2 = new DateTime('now', $time_zone);

        $r_date = $today2->modify('-' . $args['lowest-seniority'] . ' year');
        $r_date = $r_date->format('Ymd');

        //remove all leading zeros from levi code
        $code_levi = sogo_get_levi_code();
        $code_levi = ltrim($code_levi, '0');
        //if code levi length is 7 its commercial vehicle type, else its private
        $vehicle_type_by_levi = strlen($code_levi);

		$insurance_type = ($_GET['insurance-type'] == 'ZAD_G' ? 9 : 6);
		//sami - 170320201 -  20% anha meshi + 20% nekuda total 35% only Makif - 6
        $makifDiscount = $insurance_type == 6 ? 0.65 : 1;
        //return insurance type before, value for API
        function get_early_insurance_type($insType)
        {

            switch ($insType) {
                case 1:
                    return 2;
                    break;
                case 2:
                    return 5;
                    break;
                default:
                    return 1;
                    break;

            }
        }
				
        //setting up mispar tviyot
        $misparTviyot = 0;
        switch ($args['law-suites-3-year']) {
            case 1;
                $misparTviyot = 1;
                break;
            case 2:
                $misparTviyot = 3;
                break;
            default:
                $misparTviyot = 0;
                break;

        }
//sami - nehag hadash parameter by ins type and vetek and anaf
//          9 = zad g regular , 6 = mekif regular 
        if (($insurance_type == 9) || ($insurance_type == 6)) {
            if ($args['lowest-seniority'] == 0) {
                $NehagHadash = 2;
            }
            if ($args['lowest-seniority'] >= 1) {
                $NehagHadash = 1;
            }
        }
//      	10 =  topline , 4 = G-top , 1 = ototop	
        if (($insurance_type == 10) || ($insurance_type == 1) || ($insurance_type == 4)) {
            if ($args['lowest-seniority'] <= 1) {
                $NehagHadash = 2;
            }
            if ($args['lowest-seniority'] >= 2) {
                $NehagHadash = 1;
            }
        }

        /* setting up number of allowed drivers */
        $mispar_nahagim = 0;
        switch ($args['drive-allowed-number']) {
            case 1:
                $mispar_nahagim = 1;
                break;
            case 2:
                $mispar_nahagim = 2;
                break;
            case 3:
                $mispar_nahagim = 9;
                break;
            default:
                $mispar_nahagim = 9;
        }

        //sami - return from age
        if ($args['drive-allowed-number'] >= 3) {

            if ($args['youngest-driver'] >= 17) {
                $from_age = 1;
            }
            if ($args['youngest-driver'] >= 21) {
                $from_age = 2;
            }
            if ($args['youngest-driver'] >= 24) {
                $from_age = 3;
            }
            if ($args['youngest-driver'] >= 30) {
                $from_age = 4;
            }
            if ($args['youngest-driver'] >= 35) {
                $from_age = 5;
            }
            if ($args['youngest-driver'] >= 40) {
                $from_age = 6;
            }
            if ($args['youngest-driver'] >= 50) {
                $from_age = 7;
            }
            if ($args['youngest-driver'] >= 60) {
                $from_age = 8;
            }
            if ($args['youngest-driver'] >= 65) {
                $from_age = 11;
            }
            if ($args['youngest-driver'] >= 70) {
                $from_age = 9;
            }
            if ($args['youngest-driver'] >= 75) {
                $from_age = 12;
            }
        }


        $this->params = array(


            //	'ind'         => '0', //'0'
            'PARM_CHEVRA' => 25,
            //'PARM_CHEVRA' => 4.0,
            'PARM_SOCHEN' => 916165,//11940,// 515033,

            'PARM_RECHEV' => array(
                'PARM_DEGEM' => $code_levi,
                'PARM_YEAR' => substr($args['vehicle-year'], 2),
                'PARM_MISPAR_RISHUY' => $args['license_no'] == "" ? 99999999 : $args['license_no'],

            ),

            'PARM_TKUFA' => array(
                'PARM_TAAR_TCHILA' => $this->convert_date($start_date_formatted),
                'PARM_TAAR_SIUM' => $this->convert_date($end_date_formatted),
            ),

            'PARM_SUG_BITUACH' => $insurance_type,
            'PARM_MISP_NAHAGIM' => $mispar_nahagim,

            'PARM_SUG_BITUACH_1' => get_early_insurance_type($args['insurance-1-year']),
            'PARM_SUG_BITUACH_2' => get_early_insurance_type($args['insurance-2-year']),
            'PARM_SUG_BITUACH_3' => get_early_insurance_type($args['insurance-3-year']),

            'PARM_TVIOT' => array(
                'PARM_TVIOT_1' => ($args['law-suites-3-year'] == 1 && $args['law-suite-what-year'] == 1) ? 1 : 0,
                'PARM_TVIOT_2' => ($args['law-suites-3-year'] == 1 && $args['law-suite-what-year'] == 2) ? 1 : 0,
                'PARM_TVIOT_3' => ($args['law-suites-3-year'] == 1 && $args['law-suite-what-year'] == 3) ? 1 : 0,
                'PARM2_MISPAR_TVIOT' => $args['body-claims'],
                'PARM2_MISPAR_SHLILOT' => $args['license-suspensions'] == 0 ? 1 : ($args['license-suspensions'] == 1 ? 2 : 3),
            ),

            'PARM_YERIDAT_ERECH' => 1.5,
            'PARM_DIRAT_KARKA' => 1,
            'PARM_HADASH_TMURAT_YASHAN' => 1,

            'PARM_TAARICHIM' => array(
                'PARM_TAAR_LEIDA_1' => $this->convert_date($youngest_age_formatted),
                'PARM_TAAR_RISHAYON_1' => $this->convert_date($r_date),
                'PARM_TAAR_LEIDA_2' => $this->convert_date($youngest_age_formatted),
                'PARM_TAAR_RISHAYON_2' => $this->convert_date($r_date),
                'PARM_TAAR_LEIDA_3' => $this->convert_date($youngest_age_formatted),
                'PARM_TAAR_RISHAYON_3' => $this->convert_date($r_date),
                'PARM_TAAR_LEIDA_TSAIR' => $this->convert_date($youngest_age_formatted),
                'PARM_TAAR_RISHAYON_TSAIR' => $this->convert_date($r_date),
                'PARM_MIN_TSAIR' => $args['gender']
            ),

            'PARM_REIDERIM1' => array(
//				'PARM_SUG_SHIMUSH'          =>  $vehicle_type_by_levi != 7 ? 1 : 2, //car private or commercial
                'PARM_SUG_SHIMUSH' => $args['ownership'],
                'PARM_BITUL_HISHT_AZMIT' => 1,
                'PARM_ARHAVAT_NIZKEY_GUF' => 1,
                'PARM_GVUL_AHARAYUT_750000' => 1,
                'PARM_KOD_PERKLIT' => 2,
                'PARM_ERECH_RADIO' => 0,
                'PARM_ERECH_AVIZERIM' => 0
            ),

            'PARM_REIDERIM2' => array(
                'PARM_KOD_RADIO_TAPE' => 9,
                'PARM_KOD_AVIZERIM' => 99,
                'PARM_KOD_GRIRA' => 1
            ),

            'PARM_REIDERIM3' => array(
                'PARM_ADIF' => 1,
                'PARM_NEHIGA_BSHABAT' => $args['drive-on-saturday'] === 1 ? 2 : 1,
                'PARM_HAVILAT_SHERUT' => 1,
                'PARM_KINUN_OTOMATI' => 1,
                'PARM_SHEMASHOT' => 1,
//				'PARM_RECHEV_OTOMATI'  => 2,
                'PARM_UBDAN_GAMUR_50' => 1,
                'PARM_AGANA_MISHPATIT' => 1,
                'PARM_MONEA_BE_GAZ' => 1
            ),

            'PARM_REIDERIM4' => array(
                'PARM_RASHAIM_LINHOG' => $from_age,
                'PARM_NAHAG_CHADASH' => $NehagHadash,
                'PARM_KOD_SHIABUD' => 0,
                'PARM_BAKARAT_TROM' => 1
            )

        );
	    if ( isset( $_GET['dev'] ) ) {
		    {
			    echo '<pre style="direction: ltr;">';
			    var_dump('menora');
			  //  var_dump($this->params);
			    echo '</pre>';
		    }
	    }

        try {
            $this->response = $this->soap->m1mnkola11Operation($this->params);
			if ( isset( $_GET['dev'] ) ) {
                {
                    echo '<pre style="direction: ltr;">';
                    var_dump('menora1');
                    var_dump($this->response);
                    echo '</pre>';
                }
            }
        } catch (Exception $e) {
	        if ( isset( $_GET['dev'] ) ) {
		        {
			        echo '<pre style="direction: ltr;">';
			        var_dump('menoradebug');
			        var_dump($this->response);
			        var_dump($e->getMessage());
			        echo '</pre>';
		        }
	        }
//			echo '<pre style="direction: ltr;">';
//			var_dump($e->getMessage());
//			echo '</pre>';
        }
//		var_dump( $this->response ); die();
        $return = array();
//		var_dump($this->response->PARM_RETURN );
		
        if ($this->response->PARM_RETURN->PARM_RETURN_CODE === '00') {
            $res = $this->response->PARM_RETURN;
            $return['mandatory'] = $res->PARM_RETURN_TAARIF_HOVA;
            $return['comprehensive'] = (($res->PARM_RETURN_TAARIF_CASCO) * $makifDiscount);
            $return['protect'] = '';
            $return['protect_id'] = $res->PARM_RETURN_MIGUN;
//          $return['id'] = $this->company['company_id'];
            $return['id'] = '5';
            $return['company'] = $this->company['mf_company_name'];
//          $return['company_id'] = $this->company['company_id'];
            $return['company_id'] = '5';
            $return['company_slug'] = 'menora';
        }


        return $return;
    }


    public function calc_price51(array $args)
    {

        if (empty($args['levi-code']) || ((int)$args['law-suites-3-year'] === 2)) {
            return false;
        }
        if (($args['law-suites-3-year'] != 0 ) && (((int)$args['insurance-3-year'] != 1) || ((int)$args['insurance-2-year'] != 1) || ((int)$args['insurance-1-year'] != 1))) {
            return false;
        }
		
        if ($args['lowest-seniority'] < 2 ) {
            return false;
        }
        $time_zone = new DateTimeZone('Asia/Jerusalem');
        //setup start date ************
        $start = str_replace('/', '-', $args['insurance_period']);
        $start_date = new DateTime($start, $time_zone);
        $start_date_formatted = (int)$start_date->format('Ymd');

        //setup end date ************
        $end = str_replace('/', '-', $args['insurance-date-finish']);
        $end_date = new DateTime($end, $time_zone);
        $end_date_formatted = (int)$end_date->format('Ymd');

        //setup youngest driver age *************
        $today = new DateTime('now', $time_zone);
        $youngest_age = $today->modify('-' . $args['youngest-driver'] . ' year');
        $youngest_age_formatted = $youngest_age->format('Ymd');

        //setup Rishayon Date *************
        $today2 = new DateTime('now', $time_zone);

        $r_date = $today2->modify('-' . $args['lowest-seniority'] . ' year');
        $r_date = $r_date->format('Ymd');

        //remove all leading zeros from levi code
        $code_levi = sogo_get_levi_code();
        $code_levi = ltrim($code_levi, '0');
        //if code levi length is 7 its commercial vehicle type, else its private
        $vehicle_type_by_levi = strlen($code_levi);


		$insurance_type = ($_GET['insurance-type'] == 'ZAD_G' ? 4 : 10);

        //return insurance type before, value for API
        function get_early_insurance_type51($insType)
        {

            switch ($insType) {
                case 1:
                    return 2;
                    break;
                case 2:
                    return 5;
                    break;
                default:
                    return 1;
                    break;

            }
        }

        //setting up mispar tviyot
        $misparTviyot = 0;
        switch ($args['law-suites-3-year']) {
            case 1;
                $misparTviyot = 1;
                break;
            case 2:
                $misparTviyot = 3;
                break;
            default:
                $misparTviyot = 0;
                break;

        }
//sami - nehag hadash parameter by ins type and vetek and anaf
//          9 = zad g regular , 6 = mekif regular 
        if (($insurance_type == 9) || ($insurance_type == 6)) {
            if ($args['lowest-seniority'] == 0) {
                $NehagHadash = 2;
            }
            if ($args['lowest-seniority'] >= 1) {
                $NehagHadash = 1;
            }
        }
//      	10 =  topline , 4 = G-top , 1 = ototop	
        if (($insurance_type == 10) || ($insurance_type == 1) || ($insurance_type == 4)) {
            if ($args['lowest-seniority'] <= 1) {
                $NehagHadash = 2;
            }
            if ($args['lowest-seniority'] >= 2) {
                $NehagHadash = 1;
            }
        }

        /* setting up number of allowed drivers */
        $mispar_nahagim = 0;
        switch ($args['drive-allowed-number']) {
            case 1:
                $mispar_nahagim = 1;
                break;
            case 2:
                $mispar_nahagim = 2;
                break;
            case 3:
                $mispar_nahagim = 3;
                break;
            default:
                $mispar_nahagim = 9;
        }

        //sami - return from age
        if ($args['drive-allowed-number'] == 4) {

            if ($args['youngest-driver'] >= 17) {
                $from_age = 1;
            }
            if ($args['youngest-driver'] >= 21) {
                $from_age = 2;
            }
            if ($args['youngest-driver'] >= 24) {
                $from_age = 3;
            }
            if ($args['youngest-driver'] >= 30) {
                $from_age = 4;
            }
            if ($args['youngest-driver'] >= 35) {
                $from_age = 5;
            }
            if ($args['youngest-driver'] >= 40) {
                $from_age = 6;
            }
            if ($args['youngest-driver'] >= 50) {
                $from_age = 7;
            }
            if ($args['youngest-driver'] >= 60) {
                $from_age = 8;
            }
            if ($args['youngest-driver'] >= 65) {
                $from_age = 11;
            }
            if ($args['youngest-driver'] >= 70) {
                $from_age = 9;
            }
            if ($args['youngest-driver'] >= 75) {
                $from_age = 12;
            }
        }


        $this->params = array(


            //	'ind'         => '0', //'0'
            'PARM_CHEVRA' => 25,
            //'PARM_CHEVRA' => 4.0,
            'PARM_SOCHEN' => 916165,//11940,// 515033,

            'PARM_RECHEV' => array(
                'PARM_DEGEM' => $code_levi,
                'PARM_YEAR' => substr($args['vehicle-year'], 2),
                'PARM_MISPAR_RISHUY' => $args['license_no'] == "" ? 99999999 : $args['license_no'],

            ),

            'PARM_TKUFA' => array(
                'PARM_TAAR_TCHILA' => $this->convert_date($start_date_formatted),
                'PARM_TAAR_SIUM' => $this->convert_date($end_date_formatted),
            ),

            'PARM_SUG_BITUACH' => $insurance_type,
            'PARM_MISP_NAHAGIM' => $mispar_nahagim,

            'PARM_SUG_BITUACH_1' => get_early_insurance_type51($args['insurance-1-year']),
            'PARM_SUG_BITUACH_2' => get_early_insurance_type51($args['insurance-2-year']),
            'PARM_SUG_BITUACH_3' => get_early_insurance_type51($args['insurance-3-year']),

            'PARM_TVIOT' => array(
                'PARM_TVIOT_1' => ($args['law-suites-3-year'] == 1 && $args['law-suite-what-year'] == 1) ? 1 : 0,
                'PARM_TVIOT_2' => ($args['law-suites-3-year'] == 1 && $args['law-suite-what-year'] == 2) ? 1 : 0,
                'PARM_TVIOT_3' => ($args['law-suites-3-year'] == 1 && $args['law-suite-what-year'] == 3) ? 1 : 0,
                'PARM2_MISPAR_TVIOT' => $args['body-claims'],
                'PARM2_MISPAR_SHLILOT' => $args['license-suspensions'] == 0 ? 1 : ($args['license-suspensions'] == 1 ? 2 : 3),
            ),

            'PARM_YERIDAT_ERECH' => 1.5,
            'PARM_DIRAT_KARKA' => 1,
            'PARM_HADASH_TMURAT_YASHAN' => 1,

            'PARM_TAARICHIM' => array(
                'PARM_TAAR_LEIDA_1' => $this->convert_date($youngest_age_formatted),
                'PARM_TAAR_RISHAYON_1' => $this->convert_date($r_date),
                'PARM_TAAR_LEIDA_2' => $this->convert_date($youngest_age_formatted),
                'PARM_TAAR_RISHAYON_2' => $this->convert_date($r_date),
                'PARM_TAAR_LEIDA_3' => $this->convert_date($youngest_age_formatted),
                'PARM_TAAR_RISHAYON_3' => $this->convert_date($r_date),
                'PARM_TAAR_LEIDA_TSAIR' => $this->convert_date($youngest_age_formatted),
                'PARM_TAAR_RISHAYON_TSAIR' => $this->convert_date($r_date),
                'PARM_MIN_TSAIR' => $args['gender']
            ),

            'PARM_REIDERIM1' => array(
//				'PARM_SUG_SHIMUSH'          =>  $vehicle_type_by_levi != 7 ? 1 : 2, //car private or commercial
                'PARM_SUG_SHIMUSH' => $args['ownership'],
                'PARM_BITUL_HISHT_AZMIT' => 1,
                'PARM_ARHAVAT_NIZKEY_GUF' => 1,
                'PARM_GVUL_AHARAYUT_750000' => 1,
                'PARM_KOD_PERKLIT' => 2,
                'PARM_ERECH_RADIO' => 0,
                'PARM_ERECH_AVIZERIM' => 0
            ),

            'PARM_REIDERIM2' => array(
                'PARM_KOD_RADIO_TAPE' => 9,
                'PARM_KOD_AVIZERIM' => 99,
                'PARM_KOD_GRIRA' => 1
            ),

            'PARM_REIDERIM3' => array(
                'PARM_ADIF' => 1,
                'PARM_NEHIGA_BSHABAT' => $args['drive-on-saturday'] === 1 ? 2 : 1,
                'PARM_HAVILAT_SHERUT' => 1,
                'PARM_KINUN_OTOMATI' => 1,
                'PARM_SHEMASHOT' => 1,
//				'PARM_RECHEV_OTOMATI'  => 2,
                'PARM_UBDAN_GAMUR_50' => 1,
                'PARM_AGANA_MISHPATIT' => 1,
                'PARM_MONEA_BE_GAZ' => 1
            ),

            'PARM_REIDERIM4' => array(
                'PARM_RASHAIM_LINHOG' => $from_age,
                'PARM_NAHAG_CHADASH' => $NehagHadash,
                'PARM_KOD_SHIABUD' => 0,
                'PARM_BAKARAT_TROM' => 1
            )

        );


        try {
            $this->response = $this->soap->m1mnkola11Operation($this->params);
            if (isset($_GET['dev'])) {
                {
                    echo '<pre style="direction: ltr;">';
                    var_dump('menora');
                    var_dump($this->response);
                    echo '</pre>';
                }
            }

        } catch (Exception $e) {
//			echo '<pre style="direction: ltr;">';
//			var_dump($e->getMessage());
//			echo '</pre>';
        }
//		var_dump( $this->response ); die();
        $return = array();
//		var_dump($this->response->PARM_RETURN );
        if ($this->response->PARM_RETURN->PARM_RETURN_CODE === '00') {
            $res = $this->response->PARM_RETURN;
            $return['mandatory'] = $res->PARM_RETURN_TAARIF_HOVA;
            $return['comprehensive'] = $res->PARM_RETURN_TAARIF_CASCO * 0.927;
            $return['protect'] = '';
            $return['protect_id'] = $res->PARM_RETURN_MIGUN;
//          $return['id'] = $this->company['company_id'];
            $return['id'] = '51';
            $return['company'] = $this->company['mf_company_name'];
//          $return['company_id'] = $this->company['company_id'];
            $return['company_id'] = '51';
            $return['company_slug'] = 'menora';
        }

        return $return;
    }

    function convert_date($date)
    {
        return date('Ymd', strtotime($date)) - 19000000;
    }
}
