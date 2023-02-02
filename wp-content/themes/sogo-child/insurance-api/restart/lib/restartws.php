<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/12/2017
 * Time: 4:24 PM
 */
class restartws {
	private $url             = 'https://stg.quala.restartgroup.co/quala-inhouse/public/api/';
	private $login_prefix    = 'auth/login';
	private $send_prefix     = 'bids/external/cars';//url to get taskId
	private $receive_prefix  = 'bids/external/cars/{[taskId]}/results';//url to get insurances branches results
//https://stg.quala.restartgroup.co/api/auth/login
//https://stg.quala.restartgroup.co/quala-inhouse/public/api/bids/external/cars
	private $user            = 'api@hova.co.il';
	private $pass            = 'Hovaapi123';
	private $token           = '';
	private $apiParams       = [];
	private $tasId; // returned unique number from restart, according to api parameters for fetch insurances branches results

	/**
	 * restartws constructor.
	 */
	public function __construct() {
		$login  = $this->url . $this->login_prefix;
		$params = array( 'email' => $this->user, 'password' => $this->pass );

		$this->setupDefaultParams();

		$result       = $this->sendCurlRequest($login, $params);
		$parsedResult = json_decode($result);
		$this->token  = $parsedResult->data->token;
	}

	private function sendCurlRequest($url, $args)
	{

		$apiUrl = $url;
		$params = $args;
		$result = null;

		try {

			$curl = curl_init();

			// Check if initialization had gone wrong*
			if ( $curl === false ) {
				throw new Exception( 'failed to initialize' );
			}

			curl_setopt_array( $curl, array(
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS     => $params,
				CURLOPT_URL            => $apiUrl
			) );

			if ($this->token) {

				$headers = [
					'Content-Type: application/json',
					'Authorization: Bearer '. $this->token,
				];
				curl_setopt($curl, CURLOPT_HEADER, 1);
				curl_setopt($curl, 	CURLOPT_HTTPHEADER , $headers);
			}

			$result = curl_exec( $curl );

			if ( $result === false ) {
//				throw new Exception( curl_error( $curl ), curl_errno( $curl ) );
				exit;
			}
			curl_close( $curl );

			if ($this->token) {
//				echo '<pre style="direction: ltr;">';
//				var_dump($result);

				//echo '</pre>';

			}

		} catch (Exception $e) {
			trigger_error( sprintf(
				'Curl failed with error #%d: %s',
				$e->getCode(), $e->getMessage() ),
				E_USER_ERROR );
		}

		return $result;
	}

	private function setupApiParams($args)
	{
		//parsing to valid format insuranse start date
		$tmpDate      = explode('/', $args['insurance-date-start']);
		$tmpDate      = array_reverse($tmpDate);
		$insStartDate = implode('-', $tmpDate);

		//setting up ownership private or other
		$ownership    = ($args['ownership'] == 1 ? 1 : 0);

		//calculate youngest driver birthday date
		$age          = $args['youngest-driver'];
		$curYear      = date('Y');
		$birthYear    = (int) $curYear - (int) $age;
		$birthDayDate = $birthYear . '-01-01';

		//if there was body claims
		$bodyClaims   = ($args['body-claims'] == 1 ? 0 : $args['body-claims'] == 2 ? 1 : $args['body-claims'] == 3 ? 2 : 0);

		//checking if there was law suits
		$isLawSuits            = (bool)$args['law-suites-3-year'];
		$lawSuitsYearAgo       = 0;
		$lawSuitsTwoYearsAgo   = 0;
		$lawSuitsThreeYearsAgo = 0;

		if ($isLawSuits === true) {

			$lawSuits = (int) $args['law-suite-what-year'];

			switch ($lawSuits) {
				case 1:
					$lawSuitsYearAgo       = 1;
					break;
				case 2:
					$lawSuitsTwoYearsAgo   = 1;
					break;
				case 3:
					$lawSuitsThreeYearsAgo = 1;
					break;
			}
		}


		$this->apiParams['requestedBranches']             = ($args['ins-type'] === 'MAKIF' ? 4 : 5);
		$this->apiParams['insuranceStartDate']            = $insStartDate;
		$this->apiParams['zipCode']                       = 12345;
		$this->apiParams['carOwnership']                  = $ownership;
		$this->apiParams['vehicleManufactureYear']        = $args['vehicle-year'];
		$this->apiParams['vehicleModel']                  = $args['code-levi'];
		$this->apiParams['esp']                           = ($args['esp'] == 1 ? 1 : 0);
		$this->apiParams['fcw']                           = ($args['fcw'] == 1 ? 1 : 0);
		$this->apiParams['gearType']                      = ($args['gears'] == 1 ? 0 : 1);
		$this->apiParams['airBags']                       = (!empty($args['air_bags']) ? 5 : 0);
		$this->apiParams['ldw']                           = ($args['ldw'] == 1 ? 1 : 0);
		$this->apiParams['driversNumber']                 = (int) $args['drive-allowed-number'];
		$this->apiParams['youngDriverBirthDate']          = $birthDayDate;
		$this->apiParams['youngDriverGender']             = ($args['gender'] == 1 ? 1 : 0 );
		$this->apiParams['youngDriverLicenseYears']       = (int) $args['lowest-seniority'];

		if ((int )$args['drive-allowed-number'] > 1) {
			$this->apiParams['primaryDriverBirthDate']    = $birthDayDate;
			$this->apiParams['primaryDriverLicenseYears'] = (int) $args['lowest-seniority'];
		}

		$this->apiParams['suspensionsLastThreeYears']     = (int)$args['license-suspensions'];
		$this->apiParams['bodyDamagesLastThreeYears']     = $bodyClaims;
		$this->apiParams['claimsLastYear']                = $lawSuitsYearAgo;
		$this->apiParams['claimsLastTwoYears']            = $lawSuitsTwoYearsAgo;
		$this->apiParams['claimsLastThreeYears']          = $lawSuitsThreeYearsAgo;

	}

	public function getTaskIdFromApi($args)
	{
		$this->setupApiParams($args);
		$url = $this->url . $this->send_prefix;
		$result = $this->sendCurlRequest($url, $this->apiParams);

	}

	public function getApiResults()
	{

	}

	/**
	 * return @void
	 * setup array of default parameters for api
	 */
	private function setupDefaultParams()
	{
		$this->apiParams = [
			'requestedBranches' => '',//insurance types: 4 - hova + makif, 5 - hova + zad g
			'insuranceStartDate' => '',
			'zipCode'            => '',
			'carOwnership'      => '',
			'vehicleManufactureYear' => '',
			'vehicleModel' => '',// code levi izhak
			//'onRoadDate' => '',
			'esp' => '',
			'fcw' => '',
			'gearType' => '',
			'airBags' => '',
			'ldw' => '',
			'driversNumber' => '',
			'youngDriverBirthDate' => '',
			'youngDriverGender' => '',
			'youngDriverLicenseYears' => '',
			'primaryDriverBirthDate' => '',
			'primaryDriverLicenseYears' => '',
			'suspensionsLastThreeYears' => '',
			'bodyDamagesLastThreeYears' => '',
			'claimsLastYear' => '',
			'claimsLastTwoYears' => '',
			'claimsLastThreeYears' => '',
		];
	}

}

