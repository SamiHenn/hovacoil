<?php
/**
 * Created by PhpStorm.
 * User: danielgontar
 * Date: 10/31/17
 * Time: 4:53 PM
 */

ini_set( 'display_errors', 'On' );


class Shlomo {

	private $api_url;
	private $response;
	private $prices_array = array();
	private $company;

	public function __construct( $company ) {
//		$this->api_url = "http://10.119.31.2/wwa/MainService.asmx"; // test
		$this->api_url = "http://10.113.0.11/wwa/MainService.asmx"; // live
		$this->company = $company;
	}


	public function calc_price( $insurance_params ) {
		// if we have suspensions disable shlomo.
		if ( (int) $insurance_params['license-suspensions'] > 1 ) {
			return false;
	}
		if ((int) $insurance_params['law-suites-3-year'] === 2 ) {
			return false;
	}

		if (((int)$insurance_params['insurance-1-year'] === 3) && ((int)$insurance_params['insurance-2-year'] === 3)) {
			return false;
    }

		if (($this->ins_type() !== '4') && (((int)$insurance_params['insurance-1-year'] === 3) && ((int)$insurance_params['insurance-2-year'] === 3) || ((int)$insurance_params['insurance-1-year'] === 3) && ((int)$insurance_params['insurance-3-year'] === 3) || ((int)$insurance_params['insurance-2-year'] === 3) && ((int)$insurance_params['insurance-3-year'] === 3))) {
			return false;
    }
		if (($this->ins_type() !== '4') && (((int)$insurance_params['insurance-1-year'] === 3) || ((int)$insurance_params['insurance-2-year'] === 3) || ((int)$insurance_params['insurance-3-year'] === 3)) && ((int) $insurance_params['law-suites-3-year'] === 1 )) {
			return false;
    }
		if (((int)$insurance_params['insurance-before'] === 2)) 	{
			return false;
    }
		$xml  = $this->get_xml( $insurance_params );
		$curl = curl_init();

		curl_setopt_array( $curl, array(
			CURLOPT_URL            => $this->api_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 12,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => "<soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:tem=\"http://tempuri.org/\">
									   <soap:Header/>
									   <soap:Body>
									      <tem:ProcessXml>
									         <tem:sGuid>09CA1271-6745-4468-8E3A-876E51ED1114</tem:sGuid>
									         <tem:sXmlQ><![CDATA[$xml]]></tem:sXmlQ>
									      </tem:ProcessXml>
									   </soap:Body>
									</soap:Envelope>",
			CURLOPT_HTTPHEADER     => array(
				"Content-Type: text/xml",
				"SOAPAction: http://tempuri.org/ProcessXml",
				"cache-control: no-cache,no-cache"
			),
		) );
		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'SHLOMO BITUAH' );
			var_dump( $xml );
			echo '</pre>';
		}


		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );

		if ( $err ) {
//			echo "cURL Error #:" . $err;
		} else {
			$string  = html_entity_decode( $response );
			$pattern = "#<\s*?ProcessXmlResult\b[^>]*>(.*?)</ProcessXmlResult\b[^>]*>#s";
			preg_match( $pattern, $string, $matches );
			$xml = $matches[1];

			$xmldata     = simplexml_load_string( $xml );
			$json_string = json_encode( $xmldata );

			$result_array = json_decode( $json_string, true );
			if ( isset( $_GET['dev'] ) ) {
				echo '<pre style="direction: ltr;">';
				var_dump( $result_array );
				echo '</pre>';
				var_dump( 'SHLOMO END' );
				echo '</pre>++++++++++++++';
			}

			if ( $result_array['REPLY_CODE']['APPL_ERR_CODE'] === "0000" ) {

				$values = $result_array['RESPONSE']['F'];


				//setup end date ************

				$start_date = $this->get_date( $insurance_params['insurance_period'], true );
				$end_date   = $this->get_date( $insurance_params['insurance-date-finish'], true );

				//Days number for calc mandatory insurance price of days left in year
				$days_left  = (int) $end_date->diff( $start_date )->format( "%a" ) + 1;
				$private    = strlen( ltrim( $insurance_params['levi-code'], '0' ) ) <= 6;
//				$hova_index = $this->ins_type() === '4' ? 11 : 13;
//				$comprehensive_index = $private ? 4: 6;
//				$comprehensive_index = $private ? 7 : 6;
//				$protect_index       = 14;
//				$mandatory_price = $values[ $hova_index ]['V'];
//				$comprehensive   = $values[ $comprehensive_index ]['V'];


				//Fix mandatory insurance price by day left in year
				//$price_for_day = $mandatory_price / 365;
				//	$new_price     = $price_for_day * $days_left;
				
				$mandatory_price = $this->return_val('HOVA-PREMIA', $values); //$values[ $hova_index ]['V'];
				$comprehensive   = $this->return_val('DQ-NETPREM', $values);//$values[ $comprehensive_index ]['V'];
				
				/**
				 * 18% discount for zad 3
				 */
				if ( (int) $insurance_params['license-suspensions'] == 1 ) {
			    $mandatory_price = ceil($mandatory_price * 1.4);
		        }
				if ( $this->ins_type() === '4' ) {
					$comprehensive = 0.78 * $comprehensive;
				}
				
				$this->prices_array['mandatory']     = $mandatory_price;
				$this->prices_array['comprehensive'] = $comprehensive;
				$this->prices_array['protect']       = $this->return_val ('MIGUN' ,$values); //$values[ $protect_index ]['V'];
				$this->prices_array['protect_id']    = $this->return_val ('MIGUN' ,$values); //$values[ $protect_index ]['V'];
				$this->prices_array['id']            = $this->company['company_id'];
				$this->prices_array['company']       = $this->company['mf_company_name'];
				$this->prices_array['company_id']    = $this->company['company_id'];
				$this->prices_array['company_slug']  = 'shlomo';
			}

			return $this->prices_array;

		}
	}


	public function calc_price_325( $insurance_params ) {
		// if we have suspensions disable shlomo.
		if ( (int) $insurance_params['license-suspensions'] > 1 ) {
			return false;
		}
		if ((int) $insurance_params['law-suites-3-year'] === 2 ) {
			return false;
	}		$xml  = $this->get_xml_325( $insurance_params );
		$curl = curl_init();

		curl_setopt_array( $curl, array(
			CURLOPT_URL            => $this->api_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 12,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => "<soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:tem=\"http://tempuri.org/\">
									   <soap:Header/>
									   <soap:Body>
									      <tem:ProcessXml>
									         <tem:sGuid>09CA1271-6745-4468-8E3A-876E51ED1114</tem:sGuid>
									         <tem:sXmlQ><![CDATA[$xml]]></tem:sXmlQ>
									      </tem:ProcessXml>
									   </soap:Body>
									</soap:Envelope>",
			CURLOPT_HTTPHEADER     => array(
				"Content-Type: text/xml",
				"SOAPAction: http://tempuri.org/ProcessXml",
				"cache-control: no-cache,no-cache"
			),
		) );
		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'SHLOMO ' );
			var_dump( $xml );
			echo '</pre>';
		}


		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );

		if ( $err ) {
//			echo "cURL Error #:" . $err;
		} else {
			$string  = html_entity_decode( $response );
			$pattern = "#<\s*?ProcessXmlResult\b[^>]*>(.*?)</ProcessXmlResult\b[^>]*>#s";
			preg_match( $pattern, $string, $matches );
			$xml = $matches[1];

			$xmldata     = simplexml_load_string( $xml );
			$json_string = json_encode( $xmldata );

			$result_array = json_decode( $json_string, true );
			if ( isset( $_GET['dev'] ) ) {
				echo '<pre style="direction: ltr;">';
				var_dump( $result_array );
				echo '</pre>';
				var_dump( 'SHLOMO END' );
				echo '</pre>++++++++++++++';
			}

			if ( $result_array['REPLY_CODE']['APPL_ERR_CODE'] === "0000" ) {

				$values = $result_array['RESPONSE']['F'];


				//setup end date ************

				$start_date = $this->get_date( $insurance_params['insurance_period'], true );
				$end_date   = $this->get_date( $insurance_params['insurance-date-finish'], true );

				//Days number for calc mandatory insurance price of days left in year
				$days_left  = (int) $end_date->diff( $start_date )->format( "%a" ) + 1;
				$private    = strlen( ltrim( $insurance_params['levi-code'], '0' ) ) <= 6;
//				$hova_index = $this->ins_type() === '4' ? 11 : 13;
//				$comprehensive_index = $private ? 4: 6;
//				$comprehensive_index = $private ? 7 : 6;
//				$protect_index       = 14;
//				$mandatory_price = $values[ $hova_index ]['V'];
//				$comprehensive   = $values[ $comprehensive_index ]['V'];
//				
				$mandatory_price = $this->return_val('HOVA-PREMIA', $values); //$values[ $hova_index ]['V'];
				$comprehensive   = $this->return_val('DQ-NETPREM', $values);//$values[ $comprehensive_index ]['V'];


				//Fix mandatory insurance price by day left in year
				//$price_for_day = $mandatory_price / 365;
				//	$new_price     = $price_for_day * $days_left;

				if ( (int) $insurance_params['license-suspensions'] == 1 ) {
			    $mandatory_price = ceil($mandatory_price * 1.4);
		        }
				//kolektiv 325 hatama lmehir zad g bli hagana mishpatit(-60) bli havila muvnit (-200/300)
				if ( $this->ins_type() === '4' ) {
					if (date("Y") - (int) $insurance_params['vehicle-year'] > 18 && date("Y") - (int) $insurance_params['vehicle-year'] < 23 ) {
					$comprehensive = 1.05 * ($comprehensive - 360);
					}
					if (date("Y") - (int) $insurance_params['vehicle-year'] <= 18) {
					$comprehensive = 1.05 * ($comprehensive - 260);
					}
					if (date("Y") - (int) $insurance_params['vehicle-year'] > 22) {
					$comprehensive = 1.05 * ($comprehensive - 60);
					}
				}
				
				$this->prices_array['mandatory']     = $mandatory_price;
				$this->prices_array['comprehensive'] = $comprehensive;
				$this->prices_array['protect']       = $this->return_val ('MIGUN' ,$values); //$values[ $protect_index ]['V'];
				$this->prices_array['protect_id']    = $this->return_val ('MIGUN' ,$values); //$values[ $protect_index ]['V'];
				$this->prices_array['id']            = $this->company['company_id'];
				$this->prices_array['company']       = $this->company['mf_company_name'];
				$this->prices_array['company_id']    = $this->company['company_id'];
				$this->prices_array['company_slug']  = 'shlomo';
			}

			return $this->prices_array;


		}
	}

	public function calc_price_328( $insurance_params ) {
		// if we have 2 suspensions disable shlomo.
		if ( (int) $insurance_params['license-suspensions'] > 1 ) {
			return false;
		}
		if ((int) $insurance_params['law-suites-3-year'] === 2 ) {
			return false;
	}	
		// sami - this product 328 good only for clients with no insurance before or only one year before
		if ( ((int) $insurance_params['law-suites-3-year'] === 0 ) && ((int) $insurance_params['insurance-before'] == 1) && ( ( ( (int) $insurance_params['insurance-1-year'] !== 3 ) && ( (int) $insurance_params['insurance-2-year'] !== 3 ) ) || (( (int) $insurance_params['insurance-1-year'] !== 3 ) && ( (int) $insurance_params['insurance-3-year'] !== 3 ) ) || (( (int) $insurance_params['insurance-2-year'] !== 3 ) && ( (int) $insurance_params['insurance-3-year'] !== 3 ) ) )) {
			return false;
		}

		$xml  = $this->get_xml_328( $insurance_params );
		$curl = curl_init();

		curl_setopt_array( $curl, array(
			CURLOPT_URL            => $this->api_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 12,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => "<soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:tem=\"http://tempuri.org/\">
									   <soap:Header/>
									   <soap:Body>
									      <tem:ProcessXml>
									         <tem:sGuid>09CA1271-6745-4468-8E3A-876E51ED1114</tem:sGuid>
									         <tem:sXmlQ><![CDATA[$xml]]></tem:sXmlQ>
									      </tem:ProcessXml>
									   </soap:Body>
									</soap:Envelope>",
			CURLOPT_HTTPHEADER     => array(
				"Content-Type: text/xml",
				"SOAPAction: http://tempuri.org/ProcessXml",
				"cache-control: no-cache,no-cache"
			),
		) );
		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'SHLOMO ' );
			var_dump( $xml );
			echo '</pre>';
		}


		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );

		if ( $err ) {
//			echo "cURL Error #:" . $err;
		} else {
			$string  = html_entity_decode( $response );
			$pattern = "#<\s*?ProcessXmlResult\b[^>]*>(.*?)</ProcessXmlResult\b[^>]*>#s";
			preg_match( $pattern, $string, $matches );
			$xml = $matches[1];

			$xmldata     = simplexml_load_string( $xml );
			$json_string = json_encode( $xmldata );

			$result_array = json_decode( $json_string, true );
			if ( isset( $_GET['dev'] ) ) {
				echo '<pre style="direction: ltr;">';
				var_dump( $result_array );
				echo '</pre>';
				var_dump( 'SHLOMO 328 END' );
				echo '</pre>++++++328++++++++';
			}

			if ( $result_array['REPLY_CODE']['APPL_ERR_CODE'] === "0000" ) {

				$values = $result_array['RESPONSE']['F'];


				//setup end date ************

				$start_date = $this->get_date( $insurance_params['insurance_period'], true );
				$end_date   = $this->get_date( $insurance_params['insurance-date-finish'], true );

				//Days number for calc mandatory insurance price of days left in year
				$days_left  = (int) $end_date->diff( $start_date )->format( "%a" ) + 1;
				$private    = strlen( ltrim( $insurance_params['levi-code'], '0' ) ) <= 6;
//				$hova_index = $this->ins_type() === '4' ? 11 : 13;
//				$comprehensive_index = $private ? 4: 6;
//				$comprehensive_index = $private ? 7 : 6;
//				$protect_index       = 14;


				$mandatory_price = $this->return_val('HOVA-PREMIA', $values); //$values[ $hova_index ]['V'];
				$comprehensive   = $this->return_val('DQ-NETPREM', $values);//$values[ $comprehensive_index ]['V'];


				//Fix mandatory insurance price by day left in year
				//$price_for_day = $mandatory_price / 365;
				//	$new_price     = $price_for_day * $days_left;

				/**
				 * plus 30 ils for 1 mhlion gvul aharayut
				 */
				$comprehensive = 30 + ($comprehensive*0.98);
				
				if ( (int) $insurance_params['license-suspensions'] == 1 ) {
			    $mandatory_price = ceil($mandatory_price * 1.4);
		        }
				
				$this->prices_array['mandatory']     = $mandatory_price;
				$this->prices_array['comprehensive'] = $comprehensive;
				$this->prices_array['protect']       = $this->return_val ('MIGUN' ,$values); //$values[ $protect_index ]['V'];
				$this->prices_array['protect_id']    = $this->return_val ('MIGUN' ,$values); //$values[ $protect_index ]['V'];
				$this->prices_array['id']            = $this->company['company_id'];
				$this->prices_array['company']       = $this->company['mf_company_name'];
				$this->prices_array['company_id']    = $this->company['company_id'];
				$this->prices_array['company_slug']  = 'shlomo';
			}

			return $this->prices_array;


		}
	}

	public function calc_price_32850( $insurance_params ) {
		// if we have suspensions disable shlomo.
		if ( (int) $insurance_params['license-suspensions'] > 1 ) {
			return false;
		}
		if ((int) $insurance_params['law-suites-3-year'] === 2 ) {
			return false;
	}	
		// sami - this product 328 good only for clients with no insurance before or only one year before
		if ( ((int) $insurance_params['law-suites-3-year'] === 0 ) && ((int) $insurance_params['insurance-before'] == 1) && ( ( ( (int) $insurance_params['insurance-1-year'] !== 3 ) && ( (int) $insurance_params['insurance-2-year'] !== 3 ) ) || (( (int) $insurance_params['insurance-1-year'] !== 3 ) && ( (int) $insurance_params['insurance-3-year'] !== 3 ) ) || (( (int) $insurance_params['insurance-2-year'] !== 3 ) && ( (int) $insurance_params['insurance-3-year'] !== 3 ) ) )) {
			return false;
		}

		$xml  = $this->get_xml_32850( $insurance_params );
		$curl = curl_init();

		curl_setopt_array( $curl, array(
			CURLOPT_URL            => $this->api_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 12,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => "<soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:tem=\"http://tempuri.org/\">
									   <soap:Header/>
									   <soap:Body>
									      <tem:ProcessXml>
									         <tem:sGuid>09CA1271-6745-4468-8E3A-876E51ED1114</tem:sGuid>
									         <tem:sXmlQ><![CDATA[$xml]]></tem:sXmlQ>
									      </tem:ProcessXml>
									   </soap:Body>
									</soap:Envelope>",
			CURLOPT_HTTPHEADER     => array(
				"Content-Type: text/xml",
				"SOAPAction: http://tempuri.org/ProcessXml",
				"cache-control: no-cache,no-cache"
			),
		) );
		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'SHLOMO ' );
			var_dump( $xml );
			echo '</pre>';
		}


		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );

		if ( $err ) {
//			echo "cURL Error #:" . $err;
		} else {
			$string  = html_entity_decode( $response );
			$pattern = "#<\s*?ProcessXmlResult\b[^>]*>(.*?)</ProcessXmlResult\b[^>]*>#s";
			preg_match( $pattern, $string, $matches );
			$xml = $matches[1];

			$xmldata     = simplexml_load_string( $xml );
			$json_string = json_encode( $xmldata );

			$result_array = json_decode( $json_string, true );
			if ( isset( $_GET['dev'] ) ) {
				echo '<pre style="direction: ltr;">';
				var_dump( $result_array );
				echo '</pre>';
				var_dump( 'SHLOMO 328 END' );
				echo '</pre>++++++328++++++++';
			}

			if ( $result_array['REPLY_CODE']['APPL_ERR_CODE'] === "0000" ) {

				$values = $result_array['RESPONSE']['F'];


				//setup end date ************

				$start_date = $this->get_date( $insurance_params['insurance_period'], true );
				$end_date   = $this->get_date( $insurance_params['insurance-date-finish'], true );

				//Days number for calc mandatory insurance price of days left in year
				$days_left  = (int) $end_date->diff( $start_date )->format( "%a" ) + 1;
				$private    = strlen( ltrim( $insurance_params['levi-code'], '0' ) ) <= 6;
//				$hova_index = $this->ins_type() === '4' ? 11 : 13;
//				$comprehensive_index = $private ? 4: 6;
//				$comprehensive_index = $private ? 7 : 6;
//				$protect_index       = 14;


				$mandatory_price = $this->return_val('HOVA-PREMIA', $values); //$values[ $hova_index ]['V'];
				$comprehensive   = $this->return_val('DQ-NETPREM', $values);//$values[ $comprehensive_index ]['V'];


				//Fix mandatory insurance price by day left in year
				//$price_for_day = $mandatory_price / 365;
				//	$new_price     = $price_for_day * $days_left;

				/**
				 * plus 30 ils for 1 mhlion gvul aharayut
				 */
				$comprehensive = 30 + ($comprehensive*0.98);
				
				if ( (int) $insurance_params['license-suspensions'] == 1 ) {
			    $mandatory_price = ceil($mandatory_price * 1.4);
		        }
				
				$this->prices_array['mandatory']     = $mandatory_price;
				$this->prices_array['comprehensive'] = $comprehensive;
				$this->prices_array['protect']       = $this->return_val ('MIGUN' ,$values); //$values[ $protect_index ]['V'];
				$this->prices_array['protect_id']    = $this->return_val ('MIGUN' ,$values); //$values[ $protect_index ]['V'];
				$this->prices_array['id']            = $this->company['company_id'];
				$this->prices_array['company']       = $this->company['mf_company_name'];
				$this->prices_array['company_id']    = $this->company['company_id'];
				$this->prices_array['company_slug']  = 'shlomo';
			}

			return $this->prices_array;


		}
	}
	public function calc_price_327( $insurance_params ) {
		// if we have suspensions disable shlomo.
		if ( (int) $insurance_params['license-suspensions'] > 1 ) {
			return false;
		}
		if ((int) $insurance_params['law-suites-3-year'] !== 2 ) {
			return false;
	}
		if ((int) $insurance_params['insurance-before'] !== 1 ) {
			return false;
	}
		if (((int) $insurance_params['insurance-1-year'] == 3 ) && ((int) $insurance_params['insurance-2-year'] == 3 ) && ((int) $insurance_params['insurance-3-year'] == 3 )){
			return false;
	}
			
				
		$xml  = $this->get_xml_327( $insurance_params );
		$curl = curl_init();

		curl_setopt_array( $curl, array(
			CURLOPT_URL            => $this->api_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 12,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => "<soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:tem=\"http://tempuri.org/\">
									   <soap:Header/>
									   <soap:Body>
									      <tem:ProcessXml>
									         <tem:sGuid>09CA1271-6745-4468-8E3A-876E51ED1114</tem:sGuid>
									         <tem:sXmlQ><![CDATA[$xml]]></tem:sXmlQ>
									      </tem:ProcessXml>
									   </soap:Body>
									</soap:Envelope>",
			CURLOPT_HTTPHEADER     => array(
				"Content-Type: text/xml",
				"SOAPAction: http://tempuri.org/ProcessXml",
				"cache-control: no-cache,no-cache"
			),
		) );
		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'SHLOMO ' );
			var_dump( $xml );
			echo '</pre>';
		}


		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );

		if ( $err ) {
//			echo "cURL Error #:" . $err;
		} else {
			$string  = html_entity_decode( $response );
			$pattern = "#<\s*?ProcessXmlResult\b[^>]*>(.*?)</ProcessXmlResult\b[^>]*>#s";
			preg_match( $pattern, $string, $matches );
			$xml = $matches[1];

			$xmldata     = simplexml_load_string( $xml );
			$json_string = json_encode( $xmldata );

			$result_array = json_decode( $json_string, true );
			if ( isset( $_GET['dev'] ) ) {
				echo '<pre style="direction: ltr;">';
				var_dump( $result_array );
				echo '</pre>';
				var_dump( 'SHLOMO 327 END' );
				echo '</pre>++++++327++++++++';
			}

			if ( $result_array['REPLY_CODE']['APPL_ERR_CODE'] === "0000" ) {

				$values = $result_array['RESPONSE']['F'];


				//setup end date ************

				$start_date = $this->get_date( $insurance_params['insurance_period'], true );
				$end_date   = $this->get_date( $insurance_params['insurance-date-finish'], true );

				//Days number for calc mandatory insurance price of days left in year
				$days_left  = (int) $end_date->diff( $start_date )->format( "%a" ) + 1;
				$private    = strlen( ltrim( $insurance_params['levi-code'], '0' ) ) <= 6;
//				$hova_index = $this->ins_type() === '4' ? 11 : 13;
//				$comprehensive_index = $private ? 4: 6;
//				$comprehensive_index = $private ? 7 : 6;
//				$protect_index       = 14;


				$mandatory_price = $this->return_val('HOVA-PREMIA', $values); //$values[ $hova_index ]['V'];
				$comprehensive   = $this->return_val('DQ-NETPREM', $values);//$values[ $comprehensive_index ]['V'];


				//Fix mandatory insurance price by day left in year
				//$price_for_day = $mandatory_price / 365;
				//	$new_price     = $price_for_day * $days_left;

				/**
				 * plus 30 ils for 1 mhlion gvul aharayut
				 */
				$comprehensive = 30 + ($comprehensive*0.95);
				
				if ( (int) $insurance_params['license-suspensions'] == 1 ) {
			    $mandatory_price = ceil($mandatory_price * 1.4);
		        }
				
				$this->prices_array['mandatory']     = $mandatory_price;
				$this->prices_array['comprehensive'] = $comprehensive;
				$this->prices_array['protect']       = $this->return_val ('MIGUN' ,$values); //$values[ $protect_index ]['V'];
				$this->prices_array['protect_id']    = $this->return_val ('MIGUN' ,$values); //$values[ $protect_index ]['V'];
				$this->prices_array['id']            = $this->company['company_id'];
				$this->prices_array['company']       = $this->company['mf_company_name'];
				$this->prices_array['company_id']    = $this->company['company_id'];
				$this->prices_array['company_slug']  = 'shlomo';
			}

			return $this->prices_array;


		}
	}
	private function return_val( $name, $obj ) {


		foreach ( $obj as $key => $item ) {
			if ( $item['N'] == $name ) {
				return $item[ 'V' ];
			}
		}
	}


	private function ins_type() {
		return isset( $_GET['insurance-type'] ) && $_GET['insurance-type'] == 'ZAD_G' ? '4' : '1';
	}

	private function get_xml( $insurance_params ) {
		$lob        = 120;
		$message_id = $this->GUID();
		$unique_id  = substr( $message_id, 0, 24 );

		$code_levi     = ltrim( $insurance_params['levi-code'], '0' );
		$car_year      = (int) $insurance_params['vehicle-year'];
		$drivers_count = $this->no_of_drivers( $insurance_params['drive-allowed-number'] );


//		var_dump($insurance_params  ); die();
//	var_dump($insurance_params['insurance_before_three_years']); die();


		$params = [
			'HEADER'  => [
				'KEY'           => [
					'LOB'      => $lob,
					'ACTIVITY' => '613',
				],
				'SESSION'       => [
					'SESSIONID_CREATOR' => 'INTERNET',
					'SESSION_TYPE'      => 'SELL PROCCESS',
					'SESSIONID'         => $unique_id,
				],
				'MSGID'         => $message_id,
				'LOG_LEVEL'     => 'E',
				'CHK_FLD_EXIST' => '1',
			],
			'REQUEST' => [
				[ 'N' => 'DQ-CODE', 'V' => '613' ],
				[ 'N' => 'DQ-CURRENCY', 'V' => '0' ],
				[ 'N' => 'DQ-DOCTYPE', 'V' => '1' ],
				[ 'N' => 'DQ-STARTDT', 'V' => $this->get_date( $insurance_params['insurance_period'] ) ],
				[ 'N' => 'DQ-ENDDT', 'V' => $this->get_date( $insurance_params['insurance-date-finish'] ) ],
				[ 'N' => 'DQ-ADDITIONDT', 'V' => $this->get_date( $insurance_params['insurance_period'] ) ],
				[ 'N' => 'DQ-SOCHENA-NO', 'V' => '313040' ],
				[ 'N' => 'DQ-KOLEK-NO', 'V' => '' ],
				[ 'N' => 'DQ-RISHUI-8', 'V' => $insurance_params['license_no'] == '' ? '' : $insurance_params['license_no'] ],
				[ 'N' => 'DQ-CLASS', 'V' => $lob ],
				[ 'N' => 'DQ-KIS-ZMAN', 'V' => '2' ],
				[ 'N' => 'DQ-MAKE', 'V' => $car_year ],
				[ 'N' => 'DQ-MODELCODE', 'V' => $code_levi ],
				[ 'N' => 'DQ-TRANSMIT', 'V' => '0' ],
				[ 'N' => 'MAKOR-PNIYA', 'V' => '7' ],
				[ 'N' => 'TVIOT-SHANA1', 'V' => $this->get_tviot( 1, $insurance_params ) ],
				[ 'N' => 'TVIOT-SHANA2', 'V' => $this->get_tviot( 2, $insurance_params ) ],
				[ 'N' => 'TVIOT-SHANA3', 'V' => $this->get_tviot( 3, $insurance_params ) ],
				[ 'N' => 'TAARICH-ALIA', 'V' => '' ], // need to add date the car is on the road
				[ 'N' => 'BAALUT', 'V' => $insurance_params['ownership'] == '1' ? '1' : '2' ],
				[ 'N' => 'HISHTATFUT-YERIDAT-ERECH', 'V' => '1' ],
				[ 'N' => 'HADASH-TMURAT-YASHAN', 'V' => $car_year >= date( "Y" ) - 1 ? '1' : '2' ],
				[ 'N' => 'RASHAIM-LINHOG', 'V' => $drivers_count ],
				[ 'N' => 'MIN-NEHAG', 'V' => (int) $insurance_params['gender'] ],
				[
					'N' => 'SUG-KISUI',
					'V' => $this->ins_type()
				],
				[ 'N' => 'KINUN', 'V' => '2' ],
				[ 'N' => 'NEHIGA-SHABAT', 'V' => '1' ],
				[ 'N' => 'FCW', 'V' => (int) $insurance_params['keeping-distance-system'] ],
				[ 'N' => 'LDW', 'V' => (int) $insurance_params['deviation-system'] ],
				[
					'N' => 'ESP',
					'V' => (int) $insurance_params['esp'] == '2' || (int) $insurance_params['esp'] == '0' ? '2' : '1'
				],
				[ 'N' => 'THIRD-YEAR', 'V' => ((int) $insurance_params['insurance-1-year'] != '3' && (int) $insurance_params['insurance-2-year'] != '3' && (int) $insurance_params['insurance-3-year'] != '3' && (int) $insurance_params['law-suites-3-year'] == '0' && $this->ins_type() == '4') == '1'],
			],
		];

//		if ( array_get( $this->data, 'fields.license' ) ) {
//			$params['REQUEST'][] = [ 'N' => 'DQ-RISHUI-8', 'V' => '' ];
//		}

		// all drivers have the same age and the same year issue license date --> the youngest driver dates.
//		switch ( $drivers_count ) {
//			case 3:
		$params['REQUEST'][] = [ 'N' => 'AGE', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [
			'N' => 'VETEK',
			'V' => $insurance_params['lowest-seniority']
		];//['young_driver_license_year'] ];
		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG1', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG1', 'V' => $insurance_params['lowest-seniority'] ];
//				break;
//			case 4:
		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG2', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG2', 'V' => $insurance_params['lowest-seniority'] ];

		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG3', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG3', 'V' => $insurance_params['lowest-seniority'] ];
//				break;
//			case 3:
//				$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG1', 'V' => (int) $insurance_params['youngest-driver'] ];
//				$params['REQUEST'][] = [
//					'N' => 'VETEK-NEHAG1',
//					'V' => $insurance_params['lowest-seniority']
//				];
//				break;
//		}
		$xmlObj = new SimpleXMLElement( '<ROOTIN/>' );
		$this->arrayToXML( $params, $xmlObj );
		$xmlRequestStr = $xmlObj->asXML();

		//$xmlRequestStr = str_replace( '<F/>', '', $xmlRequestStr );

		return $xmlRequestStr;
	}

	private function get_xml_325( $insurance_params ) {
		$lob        = 120;
		$message_id = $this->GUID();
		$unique_id  = substr( $message_id, 0, 24 );

		$code_levi     = ltrim( $insurance_params['levi-code'], '0' );
		$car_year      = (int) $insurance_params['vehicle-year'];
		$drivers_count = $this->no_of_drivers( $insurance_params['drive-allowed-number'] );


//		var_dump($insurance_params  ); die();
//	var_dump($insurance_params['insurance_before_three_years']); die();


		$params = [
			'HEADER'  => [
				'KEY'           => [
					'LOB'      => $lob,
					'ACTIVITY' => '613',
				],
				'SESSION'       => [
					'SESSIONID_CREATOR' => 'INTERNET',
					'SESSION_TYPE'      => 'SELL PROCCESS',
					'SESSIONID'         => $unique_id,
				],
				'MSGID'         => $message_id,
				'LOG_LEVEL'     => 'E',
				'CHK_FLD_EXIST' => '1',
			],
			'REQUEST' => [
				[ 'N' => 'DQ-CODE', 'V' => '613' ],
				[ 'N' => 'DQ-CURRENCY', 'V' => '0' ],
				[ 'N' => 'DQ-DOCTYPE', 'V' => '1' ],
				[ 'N' => 'DQ-STARTDT', 'V' => $this->get_date( $insurance_params['insurance_period'] ) ],
				[ 'N' => 'DQ-ENDDT', 'V' => $this->get_date( $insurance_params['insurance-date-finish'] ) ],
				[ 'N' => 'DQ-ADDITIONDT', 'V' => $this->get_date( $insurance_params['insurance_period'] ) ],
				[ 'N' => 'DQ-SOCHENA-NO', 'V' => '313040' ],
				[ 'N' => 'DQ-KOLEK-NO', 'V' => '325' ],
				[ 'N' => 'DQ-RISHUI-8', 'V' => $insurance_params['license_no'] == '' ? '' : $insurance_params['license_no'] ],
				[ 'N' => 'EXCESS-MEKIF', 'V' => '3' ],
//				[ 'N' => 'KISUI-MISHPATIT', 'V' => '2' ],
//				[ 'N' => 'SUG-HAVILA', 'V' => '998' ],		
//				[ 'N' => 'GRIRA', 'V' => '2' ],		
//				[ 'N' => 'SHMASHOT', 'V' => '2' ],			
				[ 'N' => 'DQ-CLASS', 'V' => $lob ],
				[ 'N' => 'DQ-KIS-ZMAN', 'V' => '2' ],
				[ 'N' => 'DQ-MAKE', 'V' => $car_year ],
				[ 'N' => 'DQ-MODELCODE', 'V' => $code_levi ],
				[ 'N' => 'DQ-TRANSMIT', 'V' => '0' ],
				[ 'N' => 'MAKOR-PNIYA', 'V' => '7' ],
				[ 'N' => 'TVIOT-SHANA1', 'V' => $this->get_tviot( 1, $insurance_params ) ],
				[ 'N' => 'TVIOT-SHANA2', 'V' => $this->get_tviot( 2, $insurance_params ) ],
				[ 'N' => 'TVIOT-SHANA3', 'V' => $this->get_tviot( 3, $insurance_params ) ],
				[ 'N' => 'TAARICH-ALIA', 'V' => '' ], // need to add date the car is on the road
				[ 'N' => 'BAALUT', 'V' => $insurance_params['ownership'] == '1' ? '1' : '2' ],
				[ 'N' => 'HISHTATFUT-YERIDAT-ERECH', 'V' => '1' ],
				[ 'N' => 'HADASH-TMURAT-YASHAN', 'V' => $car_year >= date( "Y" ) - 1 ? '1' : '2' ],
				[ 'N' => 'RASHAIM-LINHOG', 'V' => $drivers_count ],
				[ 'N' => 'MIN-NEHAG', 'V' => (int) $insurance_params['gender'] ],
				[
					'N' => 'SUG-KISUI',
					'V' => $this->ins_type()
				],
				[ 'N' => 'KINUN', 'V' => '2' ],
				[ 'N' => 'NEHIGA-SHABAT', 'V' => '1' ],
				[ 'N' => 'FCW', 'V' => (int) $insurance_params['keeping-distance-system'] ],
				[ 'N' => 'LDW', 'V' => (int) $insurance_params['deviation-system'] ],
				[ 'N' => 'ESP', 'V' => (int) $insurance_params['esp'] == '2' || (int) $insurance_params['esp'] == '0' ? '2' : '1' ],
				[ 'N' => 'THIRD-YEAR', 'V' => ((int) $insurance_params['insurance-1-year'] != '3' && (int) $insurance_params['insurance-2-year'] != '3' && (int) $insurance_params['insurance-3-year'] != '3' && (int) $insurance_params['law-suites-3-year'] == '0' && $this->ins_type() == '4') == '1'],
			],
		];

//		if ( array_get( $this->data, 'fields.license' ) ) {
//			$params['REQUEST'][] = [ 'N' => 'DQ-RISHUI-8', 'V' => '' ];
//		}

		// all drivers have the same age and the same year issue license date --> the youngest driver dates.
//		switch ( $drivers_count ) {
//			case 3:
		$params['REQUEST'][] = [ 'N' => 'AGE', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [
			'N' => 'VETEK',
			'V' => $insurance_params['lowest-seniority']
		];//['young_driver_license_year'] ];
		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG1', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG1', 'V' => $insurance_params['lowest-seniority'] ];
//				break;
//			case 4:
		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG2', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG2', 'V' => $insurance_params['lowest-seniority'] ];

		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG3', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG3', 'V' => $insurance_params['lowest-seniority'] ];
//				break;
//			case 3:
//				$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG1', 'V' => (int) $insurance_params['youngest-driver'] ];
//				$params['REQUEST'][] = [
//					'N' => 'VETEK-NEHAG1',
//					'V' => $insurance_params['lowest-seniority']
//				];
//				break;
//		}
		$xmlObj = new SimpleXMLElement( '<ROOTIN/>' );
		$this->arrayToXML( $params, $xmlObj );
		$xmlRequestStr = $xmlObj->asXML();

		//$xmlRequestStr = str_replace( '<F/>', '', $xmlRequestStr );

		return $xmlRequestStr;
	}

	private function get_xml_328( $insurance_params ) {
		$lob        = 120;
		$message_id = $this->GUID();
		$unique_id  = substr( $message_id, 0, 24 );

		$code_levi     = ltrim( $insurance_params['levi-code'], '0' );
		$car_year      = (int) $insurance_params['vehicle-year'];
		$drivers_count = $this->no_of_drivers( $insurance_params['drive-allowed-number'] );


//		var_dump($insurance_params  ); die();
//	var_dump($insurance_params['insurance_before_three_years']); die();


		$params = [
			'HEADER'  => [
				'KEY'           => [
					'LOB'      => $lob,
					'ACTIVITY' => '613',
				],
				'SESSION'       => [
					'SESSIONID_CREATOR' => 'INTERNET',
					'SESSION_TYPE'      => 'SELL PROCCESS',
					'SESSIONID'         => $unique_id,
				],
				'MSGID'         => $message_id,
				'LOG_LEVEL'     => 'E',
				'CHK_FLD_EXIST' => '1',
			],
			'REQUEST' => [
				[ 'N' => 'DQ-CODE', 'V' => '613' ],
				[ 'N' => 'DQ-CURRENCY', 'V' => '0' ],
				[ 'N' => 'DQ-DOCTYPE', 'V' => '1' ],
				[ 'N' => 'DQ-STARTDT', 'V' => $this->get_date( $insurance_params['insurance_period'] ) ],
				[ 'N' => 'DQ-ENDDT', 'V' => $this->get_date( $insurance_params['insurance-date-finish'] ) ],
				[ 'N' => 'DQ-ADDITIONDT', 'V' => $this->get_date( $insurance_params['insurance_period'] ) ],
				[ 'N' => 'DQ-SOCHENA-NO', 'V' => '313040' ],
				[ 'N' => 'DQ-KOLEK-NO', 'V' => '328' ],
				[ 'N' => 'DQ-RISHUI-8', 'V' => $insurance_params['license_no'] == '' ? '' : $insurance_params['license_no'] ],
				[ 'N' => 'EXCESS-MEKIF', 'V' => '5' ],
				[ 'N' => 'DQ-CLASS', 'V' => $lob ],
				[ 'N' => 'DQ-KIS-ZMAN', 'V' => '2' ],
				[ 'N' => 'DQ-MAKE', 'V' => $car_year ],
				[ 'N' => 'DQ-MODELCODE', 'V' => $code_levi ],
				[ 'N' => 'DQ-TRANSMIT', 'V' => '0' ],
				[ 'N' => 'MAKOR-PNIYA', 'V' => '7' ],
				[ 'N' => 'TVIOT-SHANA1', 'V' => $this->get_tviot( 1, $insurance_params ) ],
				[ 'N' => 'TVIOT-SHANA2', 'V' => $this->get_tviot( 2, $insurance_params ) ],
				[ 'N' => 'TVIOT-SHANA3', 'V' => $this->get_tviot( 3, $insurance_params ) ],
				[ 'N' => 'TAARICH-ALIA', 'V' => '' ], // need to add date the car is on the road
				[ 'N' => 'BAALUT', 'V' => $insurance_params['ownership'] == '1' ? '1' : '2' ],
				[ 'N' => 'HISHTATFUT-YERIDAT-ERECH', 'V' => '1' ],
				[ 'N' => 'HADASH-TMURAT-YASHAN', 'V' => $car_year >= date( "Y" ) - 1 ? '1' : '2' ],
				[ 'N' => 'RASHAIM-LINHOG', 'V' => $drivers_count ],
				[ 'N' => 'MIN-NEHAG', 'V' => (int) $insurance_params['gender'] ],
				[
					'N' => 'SUG-KISUI',
					'V' => $this->ins_type()
				],
				[ 'N' => 'KINUN', 'V' => '2' ],
				[ 'N' => 'NEHIGA-SHABAT', 'V' => '1' ],
				[ 'N' => 'FCW', 'V' => (int) $insurance_params['keeping-distance-system'] ],
				[ 'N' => 'LDW', 'V' => (int) $insurance_params['deviation-system'] ],
				[ 'N' => 'ESP', 'V' => (int) $insurance_params['esp'] == '2' || (int) $insurance_params['esp'] == '0' ? '2' : '1' ],
			],
		];

//		if ( array_get( $this->data, 'fields.license' ) ) {
//			$params['REQUEST'][] = [ 'N' => 'DQ-RISHUI-8', 'V' => '' ];
//		}

		// all drivers have the same age and the same year issue license date --> the youngest driver dates.
//		switch ( $drivers_count ) {
//			case 3:
		$params['REQUEST'][] = [ 'N' => 'AGE', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [
			'N' => 'VETEK',
			'V' => $insurance_params['lowest-seniority']
		];//['young_driver_license_year'] ];
		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG1', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG1', 'V' => $insurance_params['lowest-seniority'] ];
//				break;
//			case 4:
		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG2', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG2', 'V' => $insurance_params['lowest-seniority'] ];

		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG3', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG3', 'V' => $insurance_params['lowest-seniority'] ];
//				break;
//			case 3:
//				$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG1', 'V' => (int) $insurance_params['youngest-driver'] ];
//				$params['REQUEST'][] = [
//					'N' => 'VETEK-NEHAG1',
//					'V' => $insurance_params['lowest-seniority']
//				];
//				break;
//		}
		$xmlObj = new SimpleXMLElement( '<ROOTIN/>' );
		$this->arrayToXML( $params, $xmlObj );
		$xmlRequestStr = $xmlObj->asXML();

		//$xmlRequestStr = str_replace( '<F/>', '', $xmlRequestStr );

		return $xmlRequestStr;
	}
	
	private function get_xml_32850( $insurance_params ) {
		$lob        = 120;
		$message_id = $this->GUID();
		$unique_id  = substr( $message_id, 0, 24 );

		$code_levi     = ltrim( $insurance_params['levi-code'], '0' );
		$car_year      = (int) $insurance_params['vehicle-year'];
		$drivers_count = $this->no_of_drivers( $insurance_params['drive-allowed-number'] );


//		var_dump($insurance_params  ); die();
//	var_dump($insurance_params['insurance_before_three_years']); die();


		$params = [
			'HEADER'  => [
				'KEY'           => [
					'LOB'      => $lob,
					'ACTIVITY' => '613',
				],
				'SESSION'       => [
					'SESSIONID_CREATOR' => 'INTERNET',
					'SESSION_TYPE'      => 'SELL PROCCESS',
					'SESSIONID'         => $unique_id,
				],
				'MSGID'         => $message_id,
				'LOG_LEVEL'     => 'E',
				'CHK_FLD_EXIST' => '1',
			],
			'REQUEST' => [
				[ 'N' => 'DQ-CODE', 'V' => '613' ],
				[ 'N' => 'DQ-CURRENCY', 'V' => '0' ],
				[ 'N' => 'DQ-DOCTYPE', 'V' => '1' ],
				[ 'N' => 'DQ-STARTDT', 'V' => $this->get_date( $insurance_params['insurance_period'] ) ],
				[ 'N' => 'DQ-ENDDT', 'V' => $this->get_date( $insurance_params['insurance-date-finish'] ) ],
				[ 'N' => 'DQ-ADDITIONDT', 'V' => $this->get_date( $insurance_params['insurance_period'] ) ],
				[ 'N' => 'DQ-SOCHENA-NO', 'V' => '313040' ],
				[ 'N' => 'DQ-KOLEK-NO', 'V' => '328' ],
				[ 'N' => 'DQ-RISHUI-8', 'V' => $insurance_params['license_no'] == '' ? '' : $insurance_params['license_no'] ],
				[ 'N' => 'EXCESS-MEKIF', 'V' => '2' ],
				[ 'N' => 'DQ-CLASS', 'V' => $lob ],
				[ 'N' => 'DQ-KIS-ZMAN', 'V' => '2' ],
				[ 'N' => 'DQ-MAKE', 'V' => $car_year ],
				[ 'N' => 'DQ-MODELCODE', 'V' => $code_levi ],
				[ 'N' => 'DQ-TRANSMIT', 'V' => '0' ],
				[ 'N' => 'MAKOR-PNIYA', 'V' => '7' ],
				[ 'N' => 'TVIOT-SHANA1', 'V' => $this->get_tviot( 1, $insurance_params ) ],
				[ 'N' => 'TVIOT-SHANA2', 'V' => $this->get_tviot( 2, $insurance_params ) ],
				[ 'N' => 'TVIOT-SHANA3', 'V' => $this->get_tviot( 3, $insurance_params ) ],
				[ 'N' => 'TAARICH-ALIA', 'V' => '' ], // need to add date the car is on the road
				[ 'N' => 'BAALUT', 'V' => $insurance_params['ownership'] == '1' ? '1' : '2' ],
				[ 'N' => 'HISHTATFUT-YERIDAT-ERECH', 'V' => '1' ],
				[ 'N' => 'HADASH-TMURAT-YASHAN', 'V' => $car_year >= date( "Y" ) - 1 ? '1' : '2' ],
				[ 'N' => 'RASHAIM-LINHOG', 'V' => $drivers_count ],
				[ 'N' => 'MIN-NEHAG', 'V' => (int) $insurance_params['gender'] ],
				[
					'N' => 'SUG-KISUI',
					'V' => $this->ins_type()
				],
				[ 'N' => 'KINUN', 'V' => '2' ],
				[ 'N' => 'NEHIGA-SHABAT', 'V' => '1' ],
				[ 'N' => 'FCW', 'V' => (int) $insurance_params['keeping-distance-system'] ],
				[ 'N' => 'LDW', 'V' => (int) $insurance_params['deviation-system'] ],
				[ 'N' => 'ESP', 'V' => (int) $insurance_params['esp'] == '2' || (int) $insurance_params['esp'] == '0' ? '2' : '1' ],
			],
		];

//		if ( array_get( $this->data, 'fields.license' ) ) {
//			$params['REQUEST'][] = [ 'N' => 'DQ-RISHUI-8', 'V' => '' ];
//		}

		// all drivers have the same age and the same year issue license date --> the youngest driver dates.
//		switch ( $drivers_count ) {
//			case 3:
		$params['REQUEST'][] = [ 'N' => 'AGE', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [
			'N' => 'VETEK',
			'V' => $insurance_params['lowest-seniority']
		];//['young_driver_license_year'] ];
		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG1', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG1', 'V' => $insurance_params['lowest-seniority'] ];
//				break;
//			case 4:
		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG2', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG2', 'V' => $insurance_params['lowest-seniority'] ];

		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG3', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG3', 'V' => $insurance_params['lowest-seniority'] ];
//				break;
//			case 3:
//				$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG1', 'V' => (int) $insurance_params['youngest-driver'] ];
//				$params['REQUEST'][] = [
//					'N' => 'VETEK-NEHAG1',
//					'V' => $insurance_params['lowest-seniority']
//				];
//				break;
//		}
		$xmlObj = new SimpleXMLElement( '<ROOTIN/>' );
		$this->arrayToXML( $params, $xmlObj );
		$xmlRequestStr = $xmlObj->asXML();

		//$xmlRequestStr = str_replace( '<F/>', '', $xmlRequestStr );

		return $xmlRequestStr;
	}
	private function get_xml_327( $insurance_params ) {
		$lob        = 120;
		$message_id = $this->GUID();
		$unique_id  = substr( $message_id, 0, 24 );

		$code_levi     = ltrim( $insurance_params['levi-code'], '0' );
		$car_year      = (int) $insurance_params['vehicle-year'];
		$drivers_count = $this->no_of_drivers( $insurance_params['drive-allowed-number'] );

//		var_dump($insurance_params  ); die();
//	var_dump($insurance_params['insurance_before_three_years']); die();


		$params = [
			'HEADER'  => [
				'KEY'           => [
					'LOB'      => $lob,
					'ACTIVITY' => '613',
				],
				'SESSION'       => [
					'SESSIONID_CREATOR' => 'INTERNET',
					'SESSION_TYPE'      => 'SELL PROCCESS',
					'SESSIONID'         => $unique_id,
				],
				'MSGID'         => $message_id,
				'LOG_LEVEL'     => 'E',
				'CHK_FLD_EXIST' => '1',
			],
			'REQUEST' => [
				[ 'N' => 'DQ-CODE', 'V' => '613' ],
				[ 'N' => 'DQ-CURRENCY', 'V' => '0' ],
				[ 'N' => 'DQ-DOCTYPE', 'V' => '1' ],
				[ 'N' => 'DQ-STARTDT', 'V' => $this->get_date( $insurance_params['insurance_period'] ) ],
				[ 'N' => 'DQ-ENDDT', 'V' => $this->get_date( $insurance_params['insurance-date-finish'] ) ],
				[ 'N' => 'DQ-ADDITIONDT', 'V' => $this->get_date( $insurance_params['insurance_period'] ) ],
				[ 'N' => 'DQ-SOCHENA-NO', 'V' => '313040' ],
				[ 'N' => 'DQ-KOLEK-NO', 'V' => '327' ],
				[ 'N' => 'DQ-RISHUI-8', 'V' => $insurance_params['license_no'] == '' ? '' : $insurance_params['license_no'] ],
				[ 'N' => 'EXCESS-MEKIF', 'V' => '5' ],
				[ 'N' => 'DQ-CLASS', 'V' => $lob ],
				[ 'N' => 'DQ-KIS-ZMAN', 'V' => '2' ],
				[ 'N' => 'DQ-MAKE', 'V' => $car_year ],
				[ 'N' => 'DQ-MODELCODE', 'V' => $code_levi ],
				[ 'N' => 'DQ-TRANSMIT', 'V' => '0' ],
				[ 'N' => 'MAKOR-PNIYA', 'V' => '7' ],
				[ 'N' => 'TVIOT-SHANA1', 'V' => $insurance_params['insurance-1-year'] != '3' ? '002' : $this->get_tviot( 1, $insurance_params ) ],
				[ 'N' => 'TVIOT-SHANA2', 'V' => ($insurance_params['insurance-1-year'] == '3' && $insurance_params['insurance-2-year'] != '3') ? '002' : $this->get_tviot( 2, $insurance_params ) ],
				[ 'N' => 'TVIOT-SHANA3', 'V' => ($insurance_params['insurance-1-year'] == '3' && $insurance_params['insurance-2-year'] == '3' && $insurance_params['insurance-3-year'] != '3') ? '002' : $this->get_tviot( 3, $insurance_params ) ],
				[ 'N' => 'TAARICH-ALIA', 'V' => '' ], // need to add date the car is on the road
				[ 'N' => 'BAALUT', 'V' => $insurance_params['ownership'] == '1' ? '1' : '2' ],
				[ 'N' => 'HISHTATFUT-YERIDAT-ERECH', 'V' => '1' ],
				[ 'N' => 'HADASH-TMURAT-YASHAN', 'V' => $car_year >= date( "Y" ) - 1 ? '1' : '2' ],
				[ 'N' => 'RASHAIM-LINHOG', 'V' => $drivers_count ],
				[ 'N' => 'MIN-NEHAG', 'V' => (int) $insurance_params['gender'] ],
				[
					'N' => 'SUG-KISUI',
					'V' => $this->ins_type()
				],
				[ 'N' => 'KINUN', 'V' => '2' ],
				[ 'N' => 'NEHIGA-SHABAT', 'V' => '1' ],
				[ 'N' => 'FCW', 'V' => (int) $insurance_params['keeping-distance-system'] ],
				[ 'N' => 'LDW', 'V' => (int) $insurance_params['deviation-system'] ],
				[ 'N' => 'ESP', 'V' => (int) $insurance_params['esp'] == '2' || (int) $insurance_params['esp'] == '0' ? '2' : '1' ],
			],
		];

//		if ( array_get( $this->data, 'fields.license' ) ) {
//			$params['REQUEST'][] = [ 'N' => 'DQ-RISHUI-8', 'V' => '' ];
//		}

		// all drivers have the same age and the same year issue license date --> the youngest driver dates.
//		switch ( $drivers_count ) {
//			case 3:
		$params['REQUEST'][] = [ 'N' => 'AGE', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [
			'N' => 'VETEK',
			'V' => $insurance_params['lowest-seniority']
		];//['young_driver_license_year'] ];
		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG1', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG1', 'V' => $insurance_params['lowest-seniority'] ];
//				break;
//			case 4:
		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG2', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG2', 'V' => $insurance_params['lowest-seniority'] ];

		$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG3', 'V' => (int) $insurance_params['youngest-driver'] ];
		$params['REQUEST'][] = [ 'N' => 'VETEK-NEHAG3', 'V' => $insurance_params['lowest-seniority'] ];
//				break;
//			case 3:
//				$params['REQUEST'][] = [ 'N' => 'GIL-NEHAG1', 'V' => (int) $insurance_params['youngest-driver'] ];
//				$params['REQUEST'][] = [
//					'N' => 'VETEK-NEHAG1',
//					'V' => $insurance_params['lowest-seniority']
//				];
//				break;
//		}
		$xmlObj = new SimpleXMLElement( '<ROOTIN/>' );
		$this->arrayToXML( $params, $xmlObj );
		$xmlRequestStr = $xmlObj->asXML();

		//$xmlRequestStr = str_replace( '<F/>', '', $xmlRequestStr );

		return $xmlRequestStr;
	}
	function arrayToXML( array $array, SimpleXMLElement &$xml ) {
		foreach ( $array as $key => $value ) {
			// Array
			if ( is_array( $value ) ) {
				$xmlChild = is_numeric( $key ) ? $xml->addChild( "F" ) : $xml->addChild( $key );
				$this->arrayToXML( $value, $xmlChild );
				continue;
			}
			// Object
			if ( is_object( $value ) ) {
				$xmlChild = $xml->addChild( get_class( $value ) );
				$this->arrayToXML( get_object_vars( $value ), $xmlChild );
				continue;
			}
			// Simple Data Element
			is_numeric( $key ) ? $xml->addChild( "F", $value ) : $xml->addChild( $key, $value );
		}
	}


	/**
	 * """ללא תביעות"" = 999
	 * ""ללא עבר ביטוחי"" = 998
	 * ""תביעה אחת"" = 1
	 * ""שתי תביעות"" = 2
	 * ""שלוש תביעות ומעלה"" = 3"
	 */

	function get_tviot( $year, $params ) {
		/**
		 * if we have in the current year insurance, we will check the suite year and last 3 years suites
		 */
// LO RELEVANTI KI KEN MITYAHASIM LESHANA SHLISHIT BAZAD G
	//	if ( $year === 3 && $this->ins_type() === 4 ) {
	//		return '999';
	//	}
		// year has insurance
		$has_insurance = $params["insurance-$year-year"];
		$suites        = (int) $params["law-suites-3-year"];
		$suite_year    = (int) $params["law-suite-what-year"];


		if ( (int) $has_insurance === 1 | (int) $has_insurance === 2 ) {
			if ( $suites === 0 || (int) $year !== $suite_year ) {
				return '999';
			} else {
				return $suites; // number of suites
			}
		} else {
			return '998'; // no insurance for this year
		}


	}

	private function get_date( $val, $obj = false ) {
		$time_zone  = new DateTimeZone( 'Asia/Jerusalem' );
		$start      = str_replace( '/', '-', $val );
		$start_date = new DateTime( $start, $time_zone );
		if ( $obj ) {
			return $start_date;
		}

		return $start_date->format( 'Ymd' );
	}

	private function get_license_date( $val ) {

		$time_zone = new DateTimeZone( 'Asia/Jerusalem' );

		$start_date = new DateTime( 'now', $time_zone );
		$r_date     = $start_date->modify( '-' . $val . ' year' );

		return $r_date->format( 'Y' );

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

	function GUID() {
		if ( function_exists( 'com_create_guid' ) === true ) {
			return trim( com_create_guid(), '{}' );
		}

		return sprintf( '%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 16384, 20479 ), mt_rand( 32768, 49151 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 ) );
	}

}
