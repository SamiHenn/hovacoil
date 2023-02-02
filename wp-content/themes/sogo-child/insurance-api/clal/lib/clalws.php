<?php
/**
 * Created by PhpStorm.
 * Date: 10/31/17
 * Time: 4:53 PM
 */
ini_set( 'display_errors', 'On' );

class Clal {

	private $api_url;
	private $insurance_params;
	private $params;
	private $soap;
	private $xml_obj;
	private $response;
	private $response_hova;
	private $clal_array;
	private $company;

	public function __construct( $company ) {
		$this->company = $company;
		//$this->api_url = "https://wsa.clalbit.co.il/CalcCampaignPremia.asmx?wsdl";
		$this->api_url = dirname( __FILE__ ) . '/CalcCampaignPremia.wsdl';
		$certificate   = dirname( __FILE__ ) . '/ws-hova.pem';
		$options       = array();
		$context       = stream_context_create( array(
			'ssl' => array(
				'verify_peer'       => true,
				'verify_peer_name'  => true,
				'allow_self_signed' => true
			)
		) );


		$options['cache_wsdl']     = WSDL_CACHE_NONE;
		$options['trace']          = true;
		$options['exceptions']     = true;
		$options['local_cert']     = $certificate;
		$options['passphrase']     = 'Rubhvhvpv!';
		$options['stream_context'] = $context;
		$options['connection_timeout'] = 15;
		$options['soap_version'] = SOAP_1_2;


		try {
			$this->soap = new SoapClient( $this->api_url, $options );


		} catch ( Exception $e ) {

            $this->soap = false;
		//	echo $e->getMessage(), '<br />', $e->getTraceAsString();
		}


	}

	public function calc_price( $insurance_params = array() ) {
	    if($this->soap === false){
	        return false;
        }
		if($insurance_params['ownership'] == '2'){
			return false;
		}
		if($insurance_params['law-suites-3-year'] == '2'){
			return false;
		}
		$this->insurance_params = $insurance_params;

		//	var_dump($insurance_params);
		$code_levi     = ltrim( $insurance_params['levi-code'], '0' );
		$car_year      = (int) $insurance_params['vehicle-year'];
		$drivers_count = $this->no_of_drivers( $insurance_params['drive-allowed-number'] );

		$youngest_age = $insurance_params['youngest-driver'];
		$this->hova   = array(
			'campaignId'               => 140,
			'IsHazaa'                  => true,
			'MisparSochen'             => 45682,
			'TrTchilatPolisa'          => $this->get_date( $insurance_params['insurance_period'] ),
			'TrTomPol'                 => $this->get_date( $insurance_params['insurance-date-finish'] ),
			'MisRishui'                => 6121188,
			'SugRechev'                => strlen($code_levi) > 6 ? 1100 : 1000,
			'TrLeida'                  => $this->cal_year_date( $youngest_age ),
			'TrRishayon'               => $this->cal_year_date( $insurance_params['lowest-seniority'] ),
			'AirBag'                   => (int) $insurance_params['air_bags'],
			'Degem'                    => $code_levi,
			'shnatYezur'               => $car_year,
			'MisparTeonot'             => (int)$insurance_params['body-claims'] * 100,
			'MisparHarshot'            => $insurance_params['license-suspensions'],
			'AllowCreditPayment'       => 0,
			'SachLetashlum'            => 0,
			'MisparTviot'              => $insurance_params["law-suites-3-year"] == '0' ? 99 : $insurance_params["law-suites-3-year"],
			'GilRashaimLinhogChevra'   => 0,
			'VetakRashaimLinhogChevra' => 0,
			'Fcw'                      => (int) $insurance_params['keeping-distance-system'] == '2' ? '0' : '1',
			'Ldw'                      => (int) $insurance_params['deviation-system'] == '2' ? '0' : '1',
			'YoungDriverGender'        => $insurance_params['gender'] == '1' ? '2' : '1'

		);

		try{
            $this->response_hova = $this->soap->WSBuildMizrahPolisa( $this->hova );
        }
        catch (SoapFault $fault) {
		    var_dump($fault);
            $this->response_hova = array();
//            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }


		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'clal - hova ' );
			var_dump( $this->hova );
			var_dump( $this->response_hova );
			echo '</pre>';
		}

		$start_date = $this->get_date( $insurance_params['insurance_period'], true );
		$end_date   = $this->get_date( $insurance_params['insurance-date-finish'], true );
		//Days number for calc mandatory insurance price of days left in year
		$days_left = (int) $end_date->diff( $start_date )->format( "%a" ) + 1;


		if ( $this->response_hova->WSBuildMizrahPolisaResult->IsSuccess ) {
			//setup end date ************

			$mandatory_price = $this->response_hova->WSBuildMizrahPolisaResult->ClalPremia;
			//Fix mandatory insurance price by day left in year
			$price_for_day                 = $mandatory_price / 365;
			$new_price                     = ceil( $price_for_day * $days_left );
			$this->clal_array['mandatory'] = $mandatory_price ;//$new_price;
		}

		$tivot = $this->get_tivot();

		$this->params = array(
			"misparSochen"                  => 45682,
			"campaignId"                    => '1601',
			"rashaimLinhog"                 => $this->driver_age( $insurance_params ),
			"vetekRashaim"                  => $this->vetek( $insurance_params['lowest-seniority'] ),
			"trLeida"                       => $this->cal_year_date( $youngest_age ),
			"TrRishayon"                    => $this->cal_year_date( $insurance_params['lowest-seniority'] ),
			"degem"                         => $code_levi,
			"shnatYezur"                    => $car_year,
			"grira"                         => '990',
			"shmashot"                      => '99',
			"rechevChalufi"                 => '99',
			"radio"                         => '99',
			"hishtatfutAzmit"               => strlen($code_levi) > 6 ? 100 : 10,
			"chadashTmuratYashan"           => '0',
			"trRishayonRechev"              => "01/01/" . $insurance_params['vehicle-year'],
			"hanachatShabat"                => $insurance_params['drive-on-saturday'] === '1' ? 0 : 1,
			"lifneiShana"                   => $tivot[1],
			"lifneiShnataim"                => $tivot[2],
			"lifneiShalosh"                 => $tivot[3],
			"trTchilatPolisa"               => $this->get_date( $insurance_params['insurance_period'] ),
			"TrRishayonNosaf"               => $this->cal_year_date( $insurance_params['lowest-seniority'] ),
			"TrLeidaNosaf"                  => $this->cal_year_date( $youngest_age ),
			"trAliyaLakvish"                => "01/01/" . $insurance_params['vehicle-year'],
			"TzadGimel"                     => '',
			"BitulhishtatfutAzmitTzadGimel" => '',
		);



        try{
            $this->response = $this->soap->WSGetClalPremia( $this->params );
        }
        catch (SoapFault $fault) {
            $this->response = array();
//            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }

		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'clal - mekif ' );
			var_dump( $this->params );
			var_dump( $this->response );
			echo '</pre>';
		}

		//get relevant data from function params($ayalon etc...) & build the my_array according to my need
		$results = $this->response->WSGetClalPremiaResult;
		if ( $results->IsSuccess ) {

			$price_for_day                 = $results->ClalPremia / 365;
			$new_price                     = ceil( $price_for_day * $days_left );
			$this->clal_array['comprehensive'] = $new_price;
			$this->clal_array['protect']       = $results->RamatMigun;
			$this->clal_array['protect_id']    = $results->RamatMigun;
			$this->clal_array['id']            = $this->company['company_id'];
			$this->clal_array['company']       = $this->company['mf_company_name'];
			$this->clal_array['company_id']    = $this->company['company_id'];
			$this->clal_array['company_slug']  = 'clal';
		}else{
			return false;
		}

		return $this->clal_array;
	}

	public function calc_price_green_1( $insurance_params = array() ) {
        if($this->soap === false){
            return false;
        }
		if($insurance_params['ownership'] == '2'){
			return false;
		}
		if($insurance_params['law-suites-3-year'] == '2'){
			return false;
		}
		$this->insurance_params = $insurance_params;

		//	var_dump($insurance_params);
		$code_levi     = ltrim( $insurance_params['levi-code'], '0' );
		$car_year      = (int) $insurance_params['vehicle-year'];
		$drivers_count = $this->no_of_drivers( $insurance_params['drive-allowed-number'] );

		$youngest_age = $insurance_params['youngest-driver'];
		$this->hova   = array(
			'campaignId'               => 140,
			'IsHazaa'                  => true,
			'MisparSochen'             => 45682,
			'TrTchilatPolisa'          => $this->get_date( $insurance_params['insurance_period'] ),
			'TrTomPol'                 => $this->get_date( $insurance_params['insurance-date-finish'] ),
			'MisRishui'                => 6121188,
			'SugRechev'                => strlen($code_levi) > 6 ? 1100 : 1000,
			'TrLeida'                  => $this->cal_year_date( $youngest_age ),
			'TrRishayon'               => $this->cal_year_date( $insurance_params['lowest-seniority'] ),
			'AirBag'                   => (int) $insurance_params['air_bags'],
			'Degem'                    => $code_levi,
			'shnatYezur'               => $car_year,
			'MisparTeonot'             => (int)$insurance_params['body-claims'] * 100,
			'MisparHarshot'            => $insurance_params['license-suspensions'],
			'AllowCreditPayment'       => 0,
			'SachLetashlum'            => 0,
			'MisparTviot'              => $insurance_params["law-suites-3-year"] == '0' ? 99 : $insurance_params["law-suites-3-year"],
			'GilRashaimLinhogChevra'   => 0,
			'VetakRashaimLinhogChevra' => 0,
			'Fcw'                      => (int) $insurance_params['keeping-distance-system'] == '2' ? '0' : '1',
			'Ldw'                      => (int) $insurance_params['deviation-system'] == '2' ? '0' : '1',
			'YoungDriverGender'        => $insurance_params['gender'] == '1' ? '2' : '1'

		);


		$this->response_hova = $this->soap->WSBuildMizrahPolisa( $this->hova );

		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'clal - hova ' );
			var_dump( $this->hova );
			var_dump( $this->response_hova );
			echo '</pre>';
		}

		$start_date = $this->get_date( $insurance_params['insurance_period'], true );
		$end_date   = $this->get_date( $insurance_params['insurance-date-finish'], true );
		//Days number for calc mandatory insurance price of days left in year
		$days_left = (int) $end_date->diff( $start_date )->format( "%a" ) + 1;


		if ( $this->response_hova->WSBuildMizrahPolisaResult->IsSuccess ) {
			//setup end date ************

			$mandatory_price = $this->response_hova->WSBuildMizrahPolisaResult->ClalPremia;
			//Fix mandatory insurance price by day left in year
			$price_for_day                 = $mandatory_price / 365;
			$new_price                     = ceil( $price_for_day * $days_left );
			$this->clal_array['mandatory'] = $mandatory_price ;//$new_price;
		}

		$tivot = $this->get_tivot();

		$this->params = array(
			"misparSochen"                  => 45682,
			"campaignId"                    => '3111',
			"rashaimLinhog"                 => $this->driver_age( $insurance_params ),
			"vetekRashaim"                  => $this->vetek( $insurance_params['lowest-seniority'] ),
			"trLeida"                       => $this->cal_year_date( $youngest_age ),
			"TrRishayon"                    => $this->cal_year_date( $insurance_params['lowest-seniority'] ),
			"degem"                         => $code_levi,
			"shnatYezur"                    => $car_year,
			"grira"                         => '10',
			"shmashot"                      => '2',
			"rechevChalufi"                 => '3',
			"radio"                         => '10',
			"hishtatfutAzmit"               => strlen($code_levi) > 6 ? 100 : 10,
			"chadashTmuratYashan"           => '0',
			"trRishayonRechev"              => "01/01/" . $insurance_params['vehicle-year'],
			"hanachatShabat"                => $insurance_params['drive-on-saturday'] === '1' ? 0 : 1,
			"lifneiShana"                   => $tivot[1],
			"lifneiShnataim"                => $tivot[2],
			"lifneiShalosh"                 => $tivot[3],
			"trTchilatPolisa"               => $this->get_date( $insurance_params['insurance_period'] ),
			"TrRishayonNosaf"               => $this->cal_year_date( $insurance_params['lowest-seniority'] ),
			"TrLeidaNosaf"                  => $this->cal_year_date( $youngest_age ),
			"trAliyaLakvish"                => "01/01/" . $insurance_params['vehicle-year'],
			"TzadGimel"                     => '',
			"BitulhishtatfutAzmitTzadGimel" => '',
		);


		$this->response = $this->soap->WSGetClalPremia( $this->params );

		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'clal - mekif ' );
			var_dump( $this->params );
			var_dump( $this->response );
			echo '</pre>';
		}

		//get relevant data from function params($ayalon etc...) & build the my_array according to my need
		$results = $this->response->WSGetClalPremiaResult;
		if ( $results->IsSuccess ) {
			$price_for_day                 = $results->ClalPremia / 365;
			$new_price                     = ceil( $price_for_day * $days_left );
			$this->clal_array['comprehensive'] = $new_price;
			$this->clal_array['protect']       = $results->RamatMigun;
			$this->clal_array['protect_id']    = $results->RamatMigun;
			$this->clal_array['id']            = $this->company['company_id'];
			$this->clal_array['company']       = $this->company['mf_company_name'];
			$this->clal_array['company_id']    = $this->company['company_id'];
			$this->clal_array['company_slug']  = 'clal';
		}else{
			return false;
		}

		return $this->clal_array;
	}

	public function calc_price_green_2( $insurance_params = array() ) {
        if($this->soap === false){
            return false;
        }
		if($insurance_params['ownership'] == '2'){
			return false;
		}
		if($insurance_params['law-suites-3-year'] == '2'){
			return false;
		}		$this->insurance_params = $insurance_params;

		//	var_dump($insurance_params);
		$code_levi     = ltrim( $insurance_params['levi-code'], '0' );
		$car_year      = (int) $insurance_params['vehicle-year'];
		$drivers_count = $this->no_of_drivers( $insurance_params['drive-allowed-number'] );

		$youngest_age = $insurance_params['youngest-driver'];
		$this->hova   = array(
			'campaignId'               => 140,
			'IsHazaa'                  => true,
			'MisparSochen'             => 45682,
			'TrTchilatPolisa'          => $this->get_date( $insurance_params['insurance_period'] ),
			'TrTomPol'                 => $this->get_date( $insurance_params['insurance-date-finish'] ),
			'MisRishui'                => 6121188,
			'SugRechev'                => strlen($code_levi) > 6 ? 1100 : 1000,
			'TrLeida'                  => $this->cal_year_date( $youngest_age ),
			'TrRishayon'               => $this->cal_year_date( $insurance_params['lowest-seniority'] ),
			'AirBag'                   => (int) $insurance_params['air_bags'],
			'Degem'                    => $code_levi,
			'shnatYezur'               => $car_year,
			'MisparTeonot'             => (int)$insurance_params['body-claims'] * 100,
			'MisparHarshot'            => $insurance_params['license-suspensions'],
			'AllowCreditPayment'       => 0,
			'SachLetashlum'            => 0,
			'MisparTviot'              => $insurance_params["law-suites-3-year"] == '0' ? 99 : $insurance_params["law-suites-3-year"],
			'GilRashaimLinhogChevra'   => 0,
			'VetakRashaimLinhogChevra' => 0,
			'Fcw'                      => (int) $insurance_params['keeping-distance-system'] == '2' ? '0' : '1',
			'Ldw'                      => (int) $insurance_params['deviation-system'] == '2' ? '0' : '1',
			'YoungDriverGender'        => $insurance_params['gender'] == '1' ? '2' : '1'

		);


		$this->response_hova = $this->soap->WSBuildMizrahPolisa( $this->hova );

		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'clal - hova ' );
			var_dump( $this->hova );
			var_dump( $this->response_hova );
			echo '</pre>';
		}

		$start_date = $this->get_date( $insurance_params['insurance_period'], true );
		$end_date   = $this->get_date( $insurance_params['insurance-date-finish'], true );
		//Days number for calc mandatory insurance price of days left in year
		$days_left = (int) $end_date->diff( $start_date )->format( "%a" ) + 1;


		if ( $this->response_hova->WSBuildMizrahPolisaResult->IsSuccess ) {
			//setup end date ************

			$mandatory_price = $this->response_hova->WSBuildMizrahPolisaResult->ClalPremia;
			//Fix mandatory insurance price by day left in year
			$price_for_day                 = $mandatory_price / 365;
			$new_price                     = ceil( $price_for_day * $days_left );
			$this->clal_array['mandatory'] = $mandatory_price ;//$new_price;
		}

		$tivot = $this->get_tivot();

		$this->params = array(
			"misparSochen"                  => 45682,
			"campaignId"                    => '3111',
			"rashaimLinhog"                 => $this->driver_age( $insurance_params ),
			"vetekRashaim"                  => $this->vetek( $insurance_params['lowest-seniority'] ),
			"trLeida"                       => $this->cal_year_date( $youngest_age ),
			"TrRishayon"                    => $this->cal_year_date( $insurance_params['lowest-seniority'] ),
			"degem"                         => $code_levi,
			"shnatYezur"                    => $car_year,
			"grira"                         => '10',
			"shmashot"                      => '2',
			"rechevChalufi"                 => '3',
			"radio"                         => '10',
			"hishtatfutAzmit"               => strlen($code_levi) > 6 ? 100 : 10,
			"chadashTmuratYashan"           => '0',
			"trRishayonRechev"              => "01/01/" . $insurance_params['vehicle-year'],
			"hanachatShabat"                => $insurance_params['drive-on-saturday'] === '1' ? 0 : 1,
			"lifneiShana"                   => $tivot[1],
			"lifneiShnataim"                => $tivot[2],
			"lifneiShalosh"                 => $tivot[3],
			"trTchilatPolisa"               => $this->get_date( $insurance_params['insurance_period'] ),
			"TrRishayonNosaf"               => $this->cal_year_date( $insurance_params['lowest-seniority'] ),
			"TrLeidaNosaf"                  => $this->cal_year_date( $youngest_age ),
			"trAliyaLakvish"                => "01/01/" . $insurance_params['vehicle-year'],
			"TzadGimel"                     => '',
			"BitulhishtatfutAzmitTzadGimel" => '',
		);


		$this->response = $this->soap->WSGetClalPremia( $this->params );

		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'clal - mekif ' );
			var_dump( $this->params );
			var_dump( $this->response );
			echo '</pre>';
		}

		//get relevant data from function params($ayalon etc...) & build the my_array according to my need
		$results = $this->response->WSGetClalPremiaResult;
		if ( $results->IsSuccess ) {
			if($results->ClalPremia == 0){
				return false;
			}
			$price_for_day                 = $results->ClalPremia / 365;

			$new_price                     = ceil( $price_for_day * $days_left * 0.925 );
			$this->clal_array['comprehensive'] = $new_price;
			$this->clal_array['protect']       = $results->RamatMigun;
			$this->clal_array['protect_id']    = $results->RamatMigun;
			$this->clal_array['id']            = $this->company['company_id'];
			$this->clal_array['company']       = $this->company['mf_company_name'];
			$this->clal_array['company_id']    = $this->company['company_id'];
			$this->clal_array['company_slug']  = 'clal';
		}else{
			return false;
		}


		return $this->clal_array;
	}
	private function get_date( $val, $obj = false ) {
		$time_zone  = new DateTimeZone( 'Asia/Jerusalem' );
		$start      = str_replace( '/', '-', $val );
		$start_date = new DateTime( $start, $time_zone );
		if ( $obj ) {
			return $start_date;
		}

		return $start_date->format( 'd/m/Y' );
	}

	private function get_license_date( $val ) {

		$time_zone  = new DateTimeZone( 'Asia/Jerusalem' );
		$start      = str_replace( '/', '-', $val );
		$start_date = new DateTime( $start, $time_zone );
		$r_date     = $start_date->modify( '-' . $val . ' year' );

		return $r_date->format( 'Y' );

	}

	function cal_year_date( $val ) {
		$time_zone = new DateTimeZone( 'Asia/Jerusalem' );

		$today = new DateTime( 'now', $time_zone );
		$date  = $today->modify( '-' . $val . ' year' );


		return $date->format( 'd/m/Y' );
	}

	/**
	 *  "ערכים אפשריים:
	 * 1 - כל נהג
	 * 3 - נהג נקוב יחיד
	 * 4 - שני נהגים נקובים
	 * 5 - שלושה נהגים נקובים "
	 */
	private function no_of_drivers( $val ) {

		switch ( $val ) {
			case 1:
				$NumOfDrivers = 3;
				break;
			case 2:
				$NumOfDrivers = 4;
				break;
			default:
				$NumOfDrivers = 1;
				break;
		}

		return $NumOfDrivers;
	}

	private function vetek( $years ) {
		/**
		 * 10 - עד שנה
		 * 20 - עד שנתיים
		 * 30 - עד שלוש שנים
		 * 40 - עד ארבע שנים
		 * 50 - מעל ארבע שנים
		 */
		$val = ( absint( $years ) + 1 ) * 10;
		if ( $val > 50 ) {
			return 50;
		}

		return $val;
	}

	private function driver_age( $params ) {
		if ( $params['drive-allowed-number'] === '2' ) {
			return '1100';
		}
		if ( $params['drive-allowed-number'] === '1' ) {
			return '1000';
		}

		$age = (int) $params['youngest-driver'];
		if ( $age >= 75 ) {
			return '900';
		}
		if ( $age >= 60 ) {
			return '800';
		}
		if ( $age >= 50 ) {
			return '500';
		}
		if ( $age >= 40 ) {
			return '600';
		}
		if ( $age >= 35 ) {
			return '500';
		}
		if ( $age >= 30 ) {
			return '400';
		}
		if ( $age >= 24 ) {
			return '300';
		}
		if ( $age >= 21 ) {
			return '200';
		}

		return '100';

	}

	private function get_tivot() {
		/**
		 * 0 – עם ותק ללא תביעות
		 * 1 - תביעה אחת
		 * 2 - שתי תביעות
		 * 3 - שלוש תביעות
		 * 4 - מעל שלוש תביעות
		 * 99- ללא ותק
		 */

		// law-suites-3-year
		// law-suite-what-year
		// insurance-1-year, insurance-2-year, insurance-3-year

		// if we did not have insurance in this year return 99
		// no ins no suites

		$y1 = (int) $this->insurance_params["insurance-1-year"];
		$y2 = (int) $this->insurance_params["insurance-2-year"];
		$y3 = (int) $this->insurance_params["insurance-3-year"];


		if ( $this->insurance_params["law-suites-3-year"] === '0' ) {
			// if we had insurance for 3 years
			if ( ( $y1 !== 3 &&
			       $y2 !== 3 &&
			       $y3 !== 3
			     ) && (
				     $y1 === 2 ||
				     $y2 === 2 ||
				     $y3 === 2
			     ) ) {

				return array(
					0,0,0,99
				);

			}
		}

		return array(
			$this->get_year_tviot(1),
			$this->get_year_tviot(1),
			$this->get_year_tviot(2),
			$this->get_year_tviot(3),
		);







	}

	private function get_year_tviot($year){
		if ( $this->insurance_params["insurance-{$year}-year"] !== '1' ) {
			return 99;
		}

		// we had insurance, check law suites in the last 3 years === 0
		if ( $this->insurance_params["law-suites-3-year"] === '0' ) {
			return 0;
		}

		// we had law suites check on which year
		if ( $this->insurance_params["law-suite-what-year"] == $year ) {
			return $this->insurance_params["law-suites-3-year"];

		}

		// a year with mekif without suite in this year.
		return 0;

	}

}