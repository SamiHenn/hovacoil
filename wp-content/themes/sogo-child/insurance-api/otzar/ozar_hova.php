<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 3/26/2018
 * Time: 4:08 PM
 */

class ozar_hova {

	/**
	 * @var string
	 */
	private $cookies = '';


	/**
	 * ozar_hova constructor.
	 *
	 * @param $params
	 */
	public function __construct( $params, $type ) {
		$this->get_cookie( $type );

	}

	/**
	 *  generate cookie from the car.cma.gov.il
	 *
	 */
	function get_cookie( $type ) {
		if ( $type == '1' ) {
			$api_url = 'https://car.cma.gov.il/';
			//	$api_url = 'https://car.cma.gov.il//Parameters/GetParametersPerSheet?sheet_id=1';
		} else {
			$api_url = 'https://car.cma.gov.il//Parameters/GetParametersPerSheet?sheet_id=5';
		}

		$curl = curl_init( $api_url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl, CURLOPT_HEADER, 1 );
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt( $curl, CURLOPT_TIMEOUT, 50 ); //timeout in seconds
        //curl_setopt($curl, CURLOPT_VERBOSE, true);
//        $verbose = fopen('php://temp', 'w+');
//        curl_setopt($curl, CURLOPT_STDERR, $verbose);


        $result = curl_exec( $curl );
//        if ($result === FALSE) {
//            printf("cUrl error (#%d): %s<br>\n", curl_errno($curl),
//                htmlspecialchars(curl_error($curl)));
//        }

//        rewind($verbose);
//        $verboseLog = stream_get_contents($verbose);

//        echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
//		var_dump($result);
		preg_match_all( '/^Set-Cookie:\s*([^;]*)/mi', $result, $matches );

		foreach ( $matches[1] as $item ) {
			$this->cookies .= $item . "; ";

		}

		return '';

	}

	/**
	 * @param $params
	 */
	public function connect( $params ) {
//	    ob_start();
//        $stack = debug_backtrace();
//        echo "\nPrintout of Function Stack: \n\n";
//        print_r($stack);
//        echo "\n";
//
//        file_put_contents(__DIR__ . "/oren.log",ob_get_clean(), FILE_APPEND );

		$api_url = 'https://car.cma.gov.il/Parameters/Calculate';
//		var_dump($params);

		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $api_url );
		curl_setopt( $curl, CURLOPT_HEADER, 1 );
		curl_setopt( $curl, CURLOPT_COOKIE, $this->cookies );
		curl_setopt( $curl, CURLOPT_AUTOREFERER, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
		curl_setopt( $curl, CURLOPT_VERBOSE, 1 );
		curl_setopt( $curl, CURLOPT_POST, 1 );
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $params );

		//execute post
		$result = curl_exec( $curl );
		$doc    = new DOMDocument();
		@$doc->loadHTML( '<?xml encoding="UTF-8">' . $result );

		//close connection
		curl_close( $curl );

		try {
			$arr    = array();
			$tables = $doc->getElementById( 'ResultTable' );
			if ( ! is_null( $tables ) ) {
				$rows = $tables->getElementsByTagName( 'tr' );

				foreach ( $rows as $tr ) {
					$tds   = $tr->getElementsByTagName( 'td' );
					$arr[] = array(
						'company' => $tds[3]->textContent,
						'price'   => $tds[4]->textContent
					);
				}
			}

			return $arr;

		} catch ( Exception $e ) {
			return 'Caught exception: ' . $e->getMessage() . "\n";
		}
	}
}


/*$params_temp = array(
	'hdnForCaptcha'            => '', // always empty
	'sheet_id'                 => '1',  // always 1
	'code_owner'               => '1001', // always
	'insurance_date'           => '01/05/2018',
	'parameters[0].parameter'  => 'D',
	'parameters[0].value'      => '1',  // 1: private, 2: motorcycle, 3: bus , 4: taxi, 5: van, 7: special
	'parameters[1].parameter'  => 'D2',
	'parameters[1].value'      => '34', // age
	'parameters[2].parameter'  => 'E',
	'parameters[2].value'      => '0',
	'parameters[3].parameter'  => 'F',
	'parameters[3].value'      => '0', // number of accident
	'parameters[4].parameter'  d=> 'G',
	'parameters[4].value'      => '0', // number of psilot
	'parameters[5].parameter'  => 'N',
	'parameters[5].value'      => '1',
	'parameters[6].parameter'  => 'A',
	'parameters[6].value'      => '1800',
	'parameters[7].parameter'  => 'O',
	'parameters[7].value'      => '100',
	'parameters[8].parameter'  => 'J',
	'parameters[8].value'      => '1',
	'parameters[9].parameter'  => 'K',
	'parameters[9].value'      => '1',
	'parameters[10].parameter' => 'H',
	'parameters[10].value'     => '4', //air bags
	'parameters[11].parameter' => 'L',
	'parameters[11].value'     => '2',
	'parameters[12].parameter' => 'M',
	'parameters[12].value'     => '2',
	'parameters[13].parameter' => 'B',
	'parameters[13].value'     => '6',


);*/
