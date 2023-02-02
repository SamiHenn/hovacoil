<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 3/26/2018
 * Time: 4:08 PM
 */

class ozar_dira {

	/**
	 * @var string
	 */
	private $cookies = '';
	// CoverageGroup
	// house type

	private $coverage = array(
		80100001 => 'מבנה',
		80100002 => 'תכולה',
		80100003 => 'תכולה ומבנה',
	);
	private $mtype = array(
		80500001 => 'בית פרטי',
		80500002 => 'בית דו משפחתי',
		80500003 => 'בניין משותף - קומת קרקע',
		80500004 => 'בניין משותף - קומת ביניים',
		80500005 => 'בניין משותף - קומה אחרונה',
		80500006 => 'בניין משותף - קומת גג (פנטהאוז)',
	);
	private $maim = array(
		80600001 => 'שרברב מטעם חברת הביטוח',
		80600002 => 'שרברב מטעם המבוטח',
		80600003 => 'ללא כיסוי נזקי מים',
	);


	private $mtvia = array(
		80700001 => 'ללא תביעות',
		80700002 => 'תביעה אחת - בשנה האחרונה',
		80700003 => 'תביעה אחת - לפני שנה',
		80700004 => 'תביעה אחת - לפני שנתיים',
		80700005 => 'שתי תביעות ויותר- בשלוש השנים האחרונות',
	);

	private $params = array();

//	// house type
//	private $mtype_parameter =


	/*
	* MAGE: null
	* MAGE_PARAMETER: null
	* MAIM: 80600001
	* MASHKANTA: null
	* MSUM: null
	* MTVIA: null
	* MTYPE: 80500001
	* MTYPE_PARAMETER: null
	* TSUM: 12
	* TTVIA: 80700001
	* TTYPE: null
	* TTYPE_PARAMETER: null
	* showFloor: false
		/**
		 * ozar_hova constructor.
		 *
		 * @param $params
		 */
	public function __construct() {


	}

	/**
	 * Used in ajax to build the ui
	 *
	 * @return array
	 */
	public function get_params() {


		$companies = get_field( '_sogo_dira_companies', 'options' );

		return array(
			'coverage'    => $this->coverage,
			'mtype'       => $this->mtype,
			'maim'        => $this->maim,
			'maim2'        => $this->maim2,
			'mtvia'       => $this->mtvia,
			'ttvia'       => $this->mtvia,
			'companies'   => $companies,
			'description' => get_field( '_sogo_dira_description', 'options' ),
			'thx'         => get_field( '_sogo_dira_thx', 'options' ),
		);
	}

	public function calc( $params ) {

		$this->get_cookie( $params );
	}

	/**
	 *  generate cookie from the briut.cma.gov.il
	 *
	 */
	function get_cookie( $params ) {
		$this->params = $params;
		$api_url      = 'https://dira.cma.gov.il/Calc/SendToCalculate';

		$curl = curl_init( $api_url );
		curl_setopt( $curl, CURLOPT_HEADER, 1 );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 ); //timeout in seconds
		curl_setopt( $curl, CURLOPT_URL, $api_url );
		curl_setopt( $curl, CURLOPT_AUTOREFERER, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
		curl_setopt( $curl, CURLOPT_VERBOSE, 1 );
		curl_setopt( $curl, CURLOPT_POST, 1 );

		curl_setopt( $curl, CURLOPT_POSTFIELDS, $params );

		//execute post
		$result = curl_exec( $curl );

		//close connection
		curl_close( $curl );

		preg_match_all( '/^Set-Cookie:\s*([^;]*)/mi', $result, $matches );
		foreach ( $matches[1] as $item ) {
			$this->cookies .= $item . "; ";

		}

		return '';

	}

	/**
	 * @param $params
	 */
	public function connect() {
		//	$api_url = 'https://dira.cma.gov.il/Home/FillParameters?InsuranceType=Content';
//		$api_url = 'https://dira.cma.gov.il/CalcResults/CalcResults';
		$api_url = 'https://dira.cma.gov.il/api/CalcResultsApi/getStoreCompanyRates';

		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $api_url );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_COOKIE, $this->cookies );
		curl_setopt( $curl, CURLOPT_AUTOREFERER, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
		curl_setopt( $curl, CURLOPT_VERBOSE, 0 );
		curl_setopt( $curl, CURLOPT_POST, 0 );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

		curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		) );


//		curl_setopt( $curl, CURLOPT_POSTFIELDS, $params );

		//execute post
		$result = curl_exec( $curl );

		//close connection
		curl_close( $curl );


		try {
			$results = json_decode( $result );
//var_dump($results);
			$companies = get_field( '_sogo_dira_companies', 'options' );

			$names    = array_column( $companies, 'name' );
			$discount = 'discount_1';
			$arr      = array();
			foreach ( $results as $c ) {
				$key = array_search( $c->CompanyShortName, $names );
				if ( $key !== false ) {
					// cal the real price
					$arr[$key] = array(
						'company'     => trim($companies[ $key ]['title']),
						'sub_title'   => $companies[ $key ]['sub_title'],
						'OriginalPrice'       =>    $c->Rate  ,
						'Price'       => ceil(( $c->Rate * ( ( 100 - $companies[ $key ][ $discount ] ) / 100 ) ) ),
						'coverage'    => isset( $this->params['CoverageGroup'] ) ? $this->coverage[ $this->params['CoverageGroup'] ] : '',
						'msum'        => $this->params['msum'],
						'tsum'        => $this->params['TSUM'],
						'mtype'       => isset( $this->params['MTYPE'] ) ? $this->mtype[ $this->params['MTYPE'] ] : '',
						'house_sm'    => $this->params['house_sm'],
						'MAIM'        => isset( $this->params['MAIM'] ) ? $this->main[ $this->params['MAIM'] ] : '',
						'mtvia'       => isset( $this->params['MTVIA'] ) ? $this->mtvia[ $this->params['MTVIA'] ] : '',
						'ttvia'       => isset( $this->params['TTVIA'] ) ? $this->mtvia[ $this->params['TTVIA'] ] : '',
						'mashkanta'   => $this->params['MASHKANTA'],
						'RateRemarks' => $c->RateRemarks,
					);


				}
			}
			usort($arr,  "sogo_sort");
			return $arr;

		} catch ( Exception $e ) {

			return 'Caught exception: ' . $e->getMessage() . "\n";
		}
	}
}


/**
 * {"CoverageGroup":80100002,
 * "InsuranceDate":"1970-01-01T00:00:00.000Z",
 * "MSUM":null,"MTYPE":80500001,
 * "MTYPE_PARAMETER":null,"MAGE":null,
 * "MAGE_PARAMETER":null,"MAIM":80600001,"MTVIA":null,"MASHKANTA":null,"TSUM":200000,"TTYPE":80500001,"TTYPE_PARAMETER":null,"TTVIA":80700001,"showFloor":false}
 */
