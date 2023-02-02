<?php


class GoWs {

	private $_api_url = 'https://api.go-ins.co.il/Go.MarketingSite.WebApiApplication/api/PolicyProposals/GeneratePolicyProposalReduced';

	public $api_params = [];
	public $company;

	public function __construct($company)
	{
		$this->company = $company;
	}

	public function calc_price(array $args)
	{
		if (((int)$args['insurance-1-year'] === 3) || ((int)$args['insurance-2-year'] === 3) || ((int)$args['insurance-3-year'] === 3) || ((int)$args['insurance-before'] === 2) || ((int)$args['law-suites-3-year'] === 2))
			return false;
        if(empty($args['license_no'])){
			return false;
    }
		if($args['ownership'] === 2){
			return false;
    }
		//		$results_arr = [];

		$time_zone = new DateTimeZone('Asia/Jerusalem');

		//setup insurance required params for API
		$start_date_tmp     = str_replace('/', '-', $args['insurance_period']);
		$start_date         = new DateTime($start_date_tmp, $time_zone);
		$start_date_for_api = $start_date->format('Y-m-d');
		$zip_code           = sogo_get_city_code($args['city'] , 'zip_code');//7194700;//trim(strip_tags($args['zip_code']));
		$lisence_number     = trim(strip_tags($args['license_no']));


		//Setup driver Details
		$selected_number_drivers = (int)$args['drive-allowed-number'] ;
		$youngest_driver_age     = (int)$args['youngest-driver'];
		$youngest_driver_gender  = (int)$args['gender'];

		$current_year       = (int)date('Y');
		$lowest_seniority   = (int)$args['lowest-seniority'];
		$license_issue_year = $current_year - $lowest_seniority;

		//Setup law suits last three years
		//changed by sami at 3.5.19 because go change api
		//$insurance_before    = (int)$args['insurance-before'] === 1 ? true : false;
		$before_1Year     = (int)$args['insurance-1-year'] === 3 ? false : true;
		$before_2Year     = (int)$args['insurance-3-year'] === 3 ? false : true;
		$before_3Year     = (int)$args['insurance-3-year'] === 3 ? false : true;

		$body_claims         = (int)$args['body-claims'] > 0 ? 2 : 1;
		$license_suspensions = (int)$args['license-suspensions'] > 0 ? 2 : 1;
		$law_suits_exists    = (int)$args['law-suites-3-year'];
		$law_suits_what_year = (int)$args['law-suite-what-year'];
		$was_year_ago        = 1;// 1 - No insurance law suits
		$was_two_years_ago   = 1;// 1 - No insurance law suits
		$was_three_year_ago  = 1;// 1 - No insurance law suits

		if ($law_suits_exists === 1) {
			switch ($law_suits_what_year) {
				case 1:
					$was_year_ago = 2;
					break;
				case 2:
					$was_two_years_ago = 2;
					break;
				case 3:
					$was_three_year_ago = 2;
					break;
			}
		}


		//agent number 267920
		$this->api_params = [
			'InsuranceStartDate'                                    => $start_date_for_api . 'T12:31:37.212Z',
			'AgentToken'                                            => '6D2FD000-D5BA-460C-83CC-B2936C2E3A34',
			"CampaignId"                                            => null,
			'LicenseNumber'                                         => $lisence_number,
			"DrivePermissionType"                                   => $selected_number_drivers >3 ?3 :$selected_number_drivers,
			'YoungestDriverAge'                                     => $youngest_driver_age,
			'YoungestDriverGender'                                  => $youngest_driver_gender,
			'YoungestDriverLicenseIssueYear'                        => $license_issue_year,
			'ResidenceZipCode'                                      => $zip_code,
			'CoverForNewDriver'                                     => $lowest_seniority === 0 ? true : false,
			'YoungOrNewDriverIsCarOwner'                            => false,
			'WasComprehensiveOrThirdPartyInsuranceLastYear'         => $before_1Year,
			'WasComprehensiveOrThirdPartyInsuranceTwoYearsAgo'      => $before_2Year,
			'WasComprehensiveOrThirdPartyInsuranceThreeYearsAgo'    => $before_3Year,
//			'WasComprehensiveOrThirdPartyInsuranceInLastThreeYears' => $insurance_before,
			'WasPropertyClaimsLastYear'                             => $was_year_ago,
			'WasPropertyClaimsTwoYearsAgo'                          => $was_two_years_ago,
			'WasPropertyClaimsThreeYearsAgo'                        => $was_three_year_ago,
			'WasBodyClaimsInLastThreeYears'                         => $body_claims,
			'DriverLicenseRevocationStatus'                         => $license_suspensions,
		];
		if (isset($_GET['dev'])) {
			echo '<pre style="direction: ltr;">+++++++++++++';
			var_dump('GO');
			var_dump( $this->api_params);
			var_dump('GO END');
			echo '</pre>++++++++++++++';
		}
		$data_string = json_encode($this->api_params);

		$ch = curl_init($this->_api_url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string))
		);

		$result = curl_exec($ch);

//		if (curl_error($ch)) {
//			echo curl_error($ch);
//			die();
//		}

		$decodet_result = json_decode($result);

		if (isset($_GET['dev'])) {
			echo '<pre style="direction: ltr;">+++++++++++++';
			var_dump('GO API RESPONSE');
			var_dump($decodet_result);
			var_dump('GO END');
			echo '</pre>++++++++++++++';
		}

		/**
		 * if the license number is not the same as the api return to us
		 */
//var_dump($args['levi-code']);
		if($decodet_result->CarDetails->CarSubModelId !== (int)$args['levi-code']){
//			var_dump($decodet_result->CarDetails->CarSubModelId );
			return false;
		}

		$results_arr['mandatory']     = ceil($decodet_result->PriceBidDetails->CompulsoryInsurancePrice);
		$results_arr['comprehensive'] = ceil($decodet_result->PriceBidDetails->ComprehensiveInsurancePrice);
		$results_arr['buyUrl']        = $decodet_result->PolicyProposalLandingURL;
		$results_arr['protect']       = 0;
		$results_arr['protect_id']    = 0;
		$results_arr['id']            = $this->company['company_id'];
		$results_arr['company']       = $this->company['mf_company_name'];
		$results_arr['company_id']    = $this->company['company_id'];
		$results_arr['company_slug']  = 'go';

		curl_close($ch);
		return $results_arr;

	}
}