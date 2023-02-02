<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 3/26/2018
 * Time: 4:08 PM
 */

//api/RiskParametersApi/CalculateMortgage
class ozar_life {

	/**
	 * @var string
	 */
	private $cookies = '';
	private $premiumType = array(
		84100001 => 'משתנה כל שנה',
		84100002 => 'משתנה כל 5 שנים',
	);
	private $gender = array(
		84400001 => 'זכר',
		84400002 => 'נקבה',
	);
	//סוג הריבית במסלול *
	private $interestType = array(
		84700001 => 'קבועה',
		84700002 => 'משתנה',
	);

	private $numberOfInsured = array(
		"84200001" => 1,
		"84200002" => 2,
	);
	private $isSmoking = array(
		"false" => "לא מעשן",
		"true" => "מעשן",
	);
	private $insType = array(
		"1" => "חיים ומבנה",
		"2" => "חיים בלבד",
		"3" => "מבנה בלבד",
	);


	// for

	private $mtype = array(
		0        => 'בחר',
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
	);

	private $mtvia = array(
		0        => 'בחר',
		80700001 => 'ללא תביעות',
		80700002 => 'תביעה אחת - בשנה האחרונה',
		80700003 => 'תביעה אחת - לפני שנה',
		80700004 => 'תביעה אחת - לפני שנתיים',
		80700005 => 'שתי תביעות ויותר- בשלוש השנים האחרונות',
	);

	/**
	 * ozar_hova constructor.
	 *
	 * @param $params
	 */
	public function __construct(   ) {


	}


	/**
	 * Used in ajax to build the ui
	 * @return array
	 */
	public function get_params() {

		return array(
			'PremiumType' => $this->premiumType,
			'Gender'    => $this->gender,
			'InterestType'     => $this->interestType,
			'NumberOfInsured'    => $this->numberOfInsured,
			'IsSmoking'    => $this->isSmoking,
			'InsType'    => $this->insType,
			'description'    => get_field( '_sogo_life_description', 'options' ),
			'thx'    => get_field( '_sogo_life_thx', 'options' ),
			'mtype'    => $this->mtype,
			'maim'    => $this->maim,
			'mtvia'    => $this->mtvia,
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


		$api_url = 'https://life.cma.gov.il/RiskParameters/RiskParameters?id=84300003';


		$curl = curl_init( $api_url );
		curl_setopt( $curl, CURLOPT_HEADER, 1 );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 ); //timeout in seconds
		curl_setopt( $curl, CURLOPT_URL, $api_url );
		curl_setopt( $curl, CURLOPT_AUTOREFERER, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
		curl_setopt( $curl, CURLOPT_VERBOSE, 1 );
		curl_setopt( $curl, CURLOPT_POST, 1 );
		//	curl_setopt( $curl, CURLOPT_COOKIE, 'ASP.NET_SessionId=115vvyrx1x2sf41zl0wo1rnp; _ga=GA1.3.1597604625.1552329428; _gid=GA1.3.973549119.1552329428');
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $params );

		//execute post
		$result = curl_exec( $curl );
		//close connection
		curl_close( $curl );

		preg_match_all( '/^Set-Cookie:\s*([^;]*)/mi', $result, $matches );
		foreach ( $matches[1] as $item ) {
			$this->cookies .= $item . "; ";

		}


	}

	/**
	 * @param $params
	 */
	public function connect( $params ) {
		//	$api_url = 'https://dira.cma.gov.il/Home/FillParameters?InsuranceType=Content';
//		$api_url = 'https://dira.cma.gov.il/CalcResults/CalcResults';
		$api_url = 'https://life.cma.gov.il/RiskParameters/CalculateRiskRates';

		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $api_url );
		curl_setopt( $curl, CURLOPT_HEADER, 1 );
		curl_setopt( $curl, CURLOPT_COOKIE, $this->cookies );
		//	curl_setopt( $curl, CURLOPT_COOKIE, 'ASP.NET_SessionId=115vvyrx1x2sf41zl0wo1rnp; _ga=GA1.3.1597604625.1552329428; _gid=GA1.3.973549119.1552329428' );
		curl_setopt( $curl, CURLOPT_AUTOREFERER, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
		curl_setopt( $curl, CURLOPT_VERBOSE, 1 );
		curl_setopt( $curl, CURLOPT_POST, 1 );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode(  $params ) );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		) );


//		curl_setopt( $curl, CURLOPT_POSTFIELDS, $params );

		//execute post
		$result = curl_exec( $curl );

		//close connection
		curl_close( $curl );

		$companies = get_field( '_sogo_life_companies', 'options' );

		$names     = array_column( $companies, 'name' );
		$discount = 'discount_1';


		try {
			$doc = new DOMDocument();
			@$doc->loadHTML( '<?xml encoding="UTF-8">' . $result );
			try {
				$arr    = array();
				$tables = $doc->getElementById( 'uiResultsDiv' );

				if ( ! is_null( $tables ) ) {
					$rows = $tables->getElementsByTagName( 'div' );

					foreach ( $rows as $tr ) {
						if ( ! empty( $tr->getAttribute( 'data-companyname' ) ) ) {
							$key = array_search(   $tr->getAttribute( 'data-companyname' ), $names);
							if ( $key !== false && $tr->getAttribute( 'data-first' ) != '10000' ) {
								$arr[$key] = array(
									'company' => trim($companies[$key]['title']),
									'sub_title' => $companies[$key]['sub_title'],
									'OriginalPrice'   =>  $tr->getAttribute( 'data-first' ),
									'PriceLife'   => ceil( $tr->getAttribute( 'data-first' ) * ((100 - $companies[$key][$discount]) / 100)),
									'Gender'   => $this->gender[$params['ListOfInsured'][0]['Gender']] ,
									'BirthDate'   => date("d-m-Y", strtotime($params['ListOfInsured'][0]['BirthDate'])) ,
									'IsSmoking'   => $this->isSmoking[$params['ListOfInsured'][0]['IsSmoking']] ,
									'Age'   => $params['ListOfInsured'][0]['Age'] ,
								);
							}

						}
					}
				}

				usort($arr,  "sogo_sort_life");
				return $arr;

			} catch ( Exception $e ) {
				return 'Caught exception: ' . $e->getMessage() . "\n";
			}

		} catch ( Exception $e ) {
			return 'Caught exception: ' . $e->getMessage() . "\n";
		}



	}
}

$params = array(
	'CalculationType' => '84300001',
	'PremiumType'     => '84100001',
	'NumberOfInsured' => '84200001',
	'ListOfInsured'   => array(
		0 => array(
			'Gender'    => '84400002',
			'BirthDate' => '1980-01-01T10:00:00.000Z',
			'IsSmoking' => false,
			'ID'        => 1,
			'Age'       => 39,
		)
	),

	'ListOfTracks'  => array(
		array(
			'DesiredPeriod' => 20,
			'DesiredSum'    => 10000,
			'ID'            => 1,
			'InterestRate'  => 2,
			'InterestType'  => 84700002,
		)
	),
	'DesiredPeriod' => '',
	'DesiredSum'    => '',

	'SortDirection' => "asc",
	'SortField'     => "",
	'uid'           => "3e7d50eb-2f29-4aa1-96da-efbf219abeff",

);


//$health = new ozar_life( $params );


/**
 * {"CalculationType":84300001,"PremiumType":84100001,
 * "NumberOfInsured":84200001,"ListOfInsured":
 * [{"Gender":84400002,"BirthDate":"1980-01-01T10:00:00.000Z","IsSmoking":false,"ID":1,"Age":39}]
 * ,"ListOfTracks":[],"DesiredSum":100000,"DesiredPeriod":23,"SortField":"","SortDirection":"asc"}
 */
//var_dump( $health->connect( $params ) );