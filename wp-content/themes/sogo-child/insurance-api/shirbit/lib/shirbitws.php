<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/12/2017
 * Time: 4:24 PM
 */
class shirbitws
{
    private $api_url;
    private $params;
    private $soap;
    private $xml_obj;
    private $response;
    private $shirbit_array;
    private $formated_xml;
    private $company;


    public function __construct($company)
    {
        //$this->api_url = "https://qa.shirbit.co.il/ShirbitQuotes/CalcCarsPremium.aspx?";
        $this->api_url = "https://int.shirbit.co.il/ShirbitQuotes/CalcCarsPremium.aspx?";

//		$client = new SoapClient(null, array(
//			'location' => $this->api_url,
//			'uri'      => "https://qa.shirbit.co.il/ShirbitQuotes/",
//			'trace'    => 1,
//		));

//		$return = $client->__soapCall("getTimeZoneTime",
//			array(new SoapParam('ZULU', 'ns1:timezone')),
//			array('soapaction' => 'http://www.Nanonull.com/TimeService/getTimeZoneTime')
//		);


//		var_dump($this->soap->__getFunctions());
//		$this->params['UserName'] = 'hova';
//		$this->params['Password'] = 'hovatest9672';
//		$options       = array(
//			'cache_wsdl'     => 0,
//			'trace'          => 1,
//			'connection_timeout' => 120,
//			'stream_context' => stream_context_create( array(
//				'ssl' => array(
//					'verify_peer'       => false,
//					'verify_peer_name'  => false,
//					'allow_self_signed' => true
//				)
//			) )
//		);
//
//		$this->soap = new SoapClient( $this->api_url, $options );
//		var_dump( $this->soap->__getFunctions() );
        $this->company = $company;
    }

    public function calc_price($insurance_params)
    {
		        if ($insurance_params['law-suites-3-year'] == '2') {
					return false;
        }
		// SHIRBIT NO SHLILOT
		if((int)$insurance_params['license-suspensions'] !== 0){
			return false;
		}
//		debug( $insurance_params );

        //setup insurance type for API
        $ins_type = $insurance_params['ins-type'] === 4 ? 0 : 1;
        $zip_code = $insurance_params['ins-type'] === 4 ? sogo_get_city_code($insurance_params['city']) : 3000;

        //setup start date ***********
        $start = str_replace('/', '-', $insurance_params['insurance_period']);

        $start_time = new DateTime($start);
        $start_date = $start_time->format('d/m/Y');

        //setup end date *************
        $end = str_replace('/', '-', $insurance_params['insurance-date-finish']);

        $end_time = new DateTime($end);
        $end_date = $end_time->format('d/m/Y');


        //setup number of drivers *************
        $NumOfDrivers = '';
        $gender = $insurance_params['gender'];
        switch ($insurance_params['drive-allowed-number']) {
            case 1:
                if ($gender == '1') {
                    $NumOfDrivers = 2;
                } else {
                    $NumOfDrivers = 1;
                }
                break;
            case 2:
                $NumOfDrivers = 3;
                break;
            case 3:
                $NumOfDrivers = 5;
                break;
            default:
                $NumOfDrivers = 4;
                break;
        }

        //setup insurance past *************   25/1/2022 SAMI
        //$total_insurance_past = 0;
        $insurance_1_year = isset($insurance_params['insurance-1-year']) && !empty($insurance_params['insurance-1-year']) && $insurance_params['insurance-1-year'] != '3' ? 1 : 0;
        $insurance_2_year = isset($insurance_params['insurance-2-year']) && !empty($insurance_params['insurance-2-year']) && $insurance_params['insurance-2-year'] != '3' ? 1 : 0;
        $insurance_3_year = isset($insurance_params['insurance-3-year']) && !empty($insurance_params['insurance-3-year']) && $insurance_params['insurance-3-year'] != '3' ? 1 : 0;
		
        $total_insurance_past = (int)$insurance_1_year + (int)$insurance_2_year + (int)$insurance_3_year;

        if ($insurance_params['insurance-before'] == '2') {
            //if insurance before is 2 than there is no insurance past ** 25/1/2022 CHANGED BY SAMI TO VERSION 3
            //$total_insurance_past = 0;
			$insurance_1_year = 0;
			$insurance_2_year = 0;
			$insurance_3_year = 0;
        }

        //setup law suites last 3 years ******************
        $claims_type = 0;
        $law_suites_3_year = isset($insurance_params['law-suites-3-year']) && !empty($insurance_params['law-suites-3-year']) ? $insurance_params['law-suites-3-year'] : '0';
        //check if there are no lsw suites
        if ($law_suites_3_year == '0') {
            $claims_type = 0;
        } //check if there is 1 lew suite
        elseif ($law_suites_3_year == '1') {
            $what_year_was_lawsuite = $insurance_params['law-suite-what-year'];
            switch ($what_year_was_lawsuite) {
                case '1':
                    $claims_type = 1;
                    break;
                case '2':
                    $claims_type = 2;
                    break;
                case '3':
                    $claims_type = 3;
                    break;
            }

        }

        $this->params = array(
//          'Version' => 2,  ** 25/1/2022 CHANGED BY SAMI TO VERSION 3
            'Version' => 3,
            'UserName' => 'hova',
            //'Password'               => 'hovatest9672',
            'Password' => 'nRX8i3GV1pcncjW1',
            'ModelCode' => (int)$insurance_params['levi-code'],
            'ManufactureYear' => (int)$insurance_params['vehicle-year'],
            'DriveAllow' => $NumOfDrivers,
            'AgeYears' => (int)$insurance_params['youngest-driver'],
            'SeniorityYears' => (int)$insurance_params['lowest-seniority'],
            'IsLdw' => ((int)$insurance_params['deviation-system'] === 1 ? 1 : 0),
            'IsFcw' => ((int)$insurance_params['keeping-distance-system'] === 1 ? 1 : 0),
            'IsEsp' => ((int)$insurance_params['esp'] === 1 ? 1 : 0),
            'ClaimsType' => $claims_type,
//          'InsurancePast' => $total_insurance_past,  ** 25/1/2022 CHANGED BY SAMI TO VERSION 3
            'InsurancePastInYear1' => $insurance_1_year,
            'InsurancePastInYear2' => $insurance_2_year,
            'InsurancePastInYear3' => $insurance_3_year,
            'PolicyStartDate' => $start_date,
            'PolicyEndDate' => $end_date,
            'DepreciationPercent' => 1.5,
            'AreDiscountsActive' => 0,
            'AutomaticEstablishment' => 0,
//			'AgentNumber' => '1',
//			'AgentName' => 'אורן',
            'IsThirdParty' => $ins_type,
            'SettlementCode' => $zip_code,
            'IsBestPolicy' => 0,
			'LicenseNumber' => ((int)$insurance_params['license_no'] === "" ? 9999999 : (int)$insurance_params['license_no']),
            'SatDriving' => ((int)$insurance_params['drive-on-saturday'] === 1 ? 1 : 0),
            'RidersPackage' => 0,
            'YoungestDriverGender' => (int)$insurance_params['gender']
        );


        $this->shirbit_array = array();
        if (isset($_GET['dev'])) {
            echo '<pre style="direction: ltr;">+++++++++++++';
            var_dump('SHIRBIT');
            var_dump($this->params);

        }
        $query = http_build_query($this->params);


        try {
            $curl = curl_init();

            // Check if initialization had gone wrong*
            if ($curl === false) {
                throw new Exception('failed to initialize');
            }

            curl_setopt_array($curl, array(
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->api_url . $query
            ));
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/xml'));

            $result = curl_exec($curl);
            if (isset($_GET['dev'])) {
                var_dump(' Results');
                var_dump($result);
                var_dump('SHIRBIT END');
                echo '</pre>++++++++++++++';
            }
//			$resultXml = htmlspecialchars($result);
//			echo '<pre style="direction: ltr;">';
//			var_dump(simplexml_load_string($result));
//			echo '</pre>';
            // Check the return value of curl_exec(), too
//            if ($result === false) {
//                throw new Exception(curl_error($curl), curl_errno($curl));
//            }
            curl_close($curl);

            return $this->set_shirbit_params($result);


        } catch (Exception $e) {
//            trigger_error(sprintf(
//                'Curl failed with error #%d: %s',
//                $e->getCode(), $e->getMessage()),
//                E_USER_ERROR);
        }

    }

    public function set_shirbit_params($xml)
    {
        if (!$xml) {
//            $this->shirbit_array['mandatory'] = '';
//            $this->shirbit_array['comprehensive'] = '';
//            $this->shirbit_array['protect'] = '';
//            $this->shirbit_array['protect_id'] = '';
//            $this->shirbit_array['id'] = $this->company['company_id'];
//            $this->shirbit_array['company'] = $this->company['mf_company_name'];
//            $this->shirbit_array['company_id'] = $this->company['company_id'];
//            $this->shirbit_array['company_slug'] = 'shirbit';
//
//            return $this->shirbit_array;
			return array();
        } else {
            $this->formated_xml = (array)simplexml_load_string($xml);
            if (false === $this->formated_xml) {
                return array();
            }
            $this->shirbit_array['mandatory'] = (int)$this->formated_xml['MandatoryPremium'];
            $this->shirbit_array['comprehensive'] = (int)$this->formated_xml['Premium'];
            $this->shirbit_array['protect'] = '';
            $this->shirbit_array['protect_id'] = $this->formated_xml['Protect'];
            $this->shirbit_array['id'] = $this->company['company_id'];
            $this->shirbit_array['company'] = $this->company['mf_company_name'];
            $this->shirbit_array['company_id'] = $this->company['company_id'];
            $this->shirbit_array['company_slug'] = 'shirbit';

            return $this->shirbit_array;
        }
    }
}

//*************** status *************************
/*
 * finished
 * consult whit oren about the non mandatory fields
 * */
