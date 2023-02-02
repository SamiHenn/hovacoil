<?php
/**
 * Get data from snapir
 */
function sogo_get_snapir_data($code, $year) {


	$api_url = 'http://82.81.238.36/LeviConvert/PublicConversion.aspx';




	$params = array(
		'txtSearch'                => $code,
		'__EVENTTARGET'            => 'txtSearch',
		'ddlPriceList'             => '03/18',
		'ddlYear0'                 => $year,
		'__EVENTVALIDATION'        => 'fNeZRtwD9D+idCWZO8GNzaddD8oHUCfuuk4KFmq2KdKp9uKNTKQ2/nL++vrBHk0RU1oG9XxetuMvYKXnY/8J8UkhBIpbbf+tiYRsUFaY0GV/NLKmCAk9zXo/v1LuYW68UzIMA5ThmiYOkIBV3vymOmCsffBpuiu/8AzP5iOG6BBVfSawUrhd0E34Pv+WRlHV2x4tlt9xyrWkNBWAHgpwXfcNo3medk+1mozyZfW5cXg1qOA+x1uX5l0mKScFeUyD/xjc2sjPlIfwIhTiQNuKAa0wSSrzVcUF04+frLbnjnZREcxJQXXPY2UWx56eBC43WM7jfgAPp3s2JNqupyNR/G7Z9wAi9gDRS6pFBkeRrfHMpose5jvv2AgyAqnOIDaBCLzowQrLAoy04k1vdHdskw==',
		'__EVENTARGUMENT'          => '',
		'__LASTFOCUS'              => '',
		'__ASYNCPOST'              => true,
		'__VIEWSTATE'              => 'yCppidccf31mtDRFGqMdrt7QZQe6bcb+GBVTc7C7STy7w7clWgDBsSiRheNZsB+JWGq9jRqwotlTlNxFBiMoL7qrnaMjFqy63zEITZ1y1atp4EkReZOlRln4aG+lUrSYZ+bH80XjnGn0aIDl8qk0b9Qjrpa+Dy6Fk470B07Hbg38VFU97g/XJR6A1Jq3jZXZ0WBKzsKdxCfi+sGYbjfcUcV8NGERMyk1vDs4ZVrIhg+m1QrKxHcLDx/MOomdSY51XlQsVGFJByll0POb4V/FQEeULBSew2b4gLTvL3yXR3yx5LQEbA2XirJFDHU/btGSIbFlI9aytU3kifMlM+AeJvHkDkoXGFbgN2StLD+qC/Ua6JnTMROuOF03RgEI8pidtihPnzu9Xei1ND/NfbRax7MRjmd+cnQxrjZoFkrseaq25OC3usoF6iCuXa8zCOJkaMY1lFZeqxBTlXg0/9U4i1PV0FG/I/RtU7265fMH7ec3uEPc1bNy4L/aZ42gS4o+ndrdEp5UttGPTuGUbdjJisNW2Hlq9AD9YY8ZvpzszkuDiHmKDO5FadbyykFua3mT5GiFVxKYzztyAeQn7PFO8d/yj9lHYCW9Ubf9Sc8ST0MZPfql/MEat8Kl2neMKD37lwiCDezcWkjumjQFeRK42Ca19hkgPyXPEoGO7VwkiInogvS9nJiCbPDgCBV1KkSiOn72DToDp/gAex/wEri9jk6TAz0aS9dMn7fn3PVjeUBxPOYVE+k1Q04n/OG1gdEQH3Fc783akVFJVH4DE0GU/228l+zy5Lo4saZvBNDIzJiqWtMeoKMY+qJ/pWNIbKCDTXeKmeW8MLs+LM060adFL9DKEvOAcrFk9NOsF6sho/yQ7iJxfvCC+heWhk2Z/cyBS7bkhy2A3vOcYarwGQA1SIbpP6V/ueEpludVr8+Oz0Yv9R0Mgkun9eI8K3iBVfFB9Z7nDRaYpL/GkRHJR8ADgC18z1uHsYWB6JidMgLwHxwPCb9dvBGHkExqctVSZq5OaltlRFYGGC1DML7/tAYvYb5ftjuZ4I41Dz4pZymDW7KxuInKlN53f4U9kGWzUxqKPxHO6kDOx2z9vLVC9l/3ch9XYSqHKAwnUTrBs9WtFWzUr/iy2QusAyF89DNvA7euFNts2tSikM26L5bClNVzUcG+4VSeFTiGG2/AwnDY+Q2an2rnLeV+gutIxU0q9dro8kblPU+FefbZXjkVFv9OWQiZTWLf2zB/0HgOFUuOBNUJ9umsb+lDM6aaCF4CyjJxskYxQwN0H9ze1DqxUrlp9alxfJRgVt+yN6fuW86paSCEfUH4LaJ6kEFUIdqiE7hlL8KOCyihtrM6wRqzBTWuTaHKGJqDbyu5bXHMdddzDeXFsR3y6LVfVTO/9ucbm1DmDo1DVzZlqWReg/skgtEDtgEKKeV/ROZUBAgVPOM3kC619/TXCmOzTBsBGISAtqaTpPqIjJPTbRjhE4fuly/U4O04vE2Kw/varTAJGUzEWkR2M7z6VpVD2AYmTkH1hlcMEL0+8SXF3wabi7g4wUc3OY+UGEY2mX217B9YA6d3asSnhLAAaHL8f75WHeYHU7LBppGklofaGBSSnn4M4VZmoOjr1hf1HdN6uoYGwt7Vi48=',
//		'__VIEWSTATEGENERATOR'     => 'BA761583',
		'__VIEWSTATEENCRYPTED'     => '',
		'btnConvertCodeLevi'       => 'הצג',
//		'MaskedRishui_ClientState' => ''
	);

//	var_dump($params);
	$cookies = Array();

// Ask for the callback.





	$ip  = '127.0.0.1'; // trying to spoof ip..

	$header[0]  = "Accept: text/xml,application/xml,application/xhtml+xml,";
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";

	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: "; // browsers = blank
	$header[] = "X_FORWARDED_FOR: " . $ip;
	$header[] = "REMOTE_ADDR: " . $ip;
	$header[] = "Host: example.com";

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HEADERFUNCTION, "curlResponseHeaderCallback");
	curl_setopt($curl, CURLOPT_URL, $api_url);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36');
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	curl_setopt($curl, CURLOPT_REFERER, 'http://example.com/');
	curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
	curl_setopt($curl, CURLOPT_AUTOREFERER, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_VERBOSE, 1);
//	curl_setopt( $curl, CURLOPT_POST, 1 );
//$ip = "31.154.168.122";
//	$ch = curl_init( $api_url );
//	curl_setopt( $ch, CURLOPT_POST, 1 );
//	curl_setopt( $curl, CURLOPT_POSTFIELDS, $params );
//	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
//	curl_setopt( $ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip"));
	//execute post
	$result = curl_exec( $curl );
	var_dump($cookies);
	var_dump($result); die();
	$doc    = new DOMDocument();
	@$doc->loadHTML( '<?xml encoding="UTF-8">' . $result );

	//close connection
	curl_close( $curl );

		var_dump($result);
	try {
		$tables = $doc->getElementsByTagName( 'table' );

		if(isset($tables[1])){
			$tr  = $tables[1]->getElementsByTagName( 'td' );
			$no1 = str_pad( $tr[2]->textContent, 4, 0, STR_PAD_LEFT );
			$no2 = str_pad( $tr[3]->textContent, 5, 0, STR_PAD_LEFT );



			global $wpdb;
			$table = $wpdb->prefix . 'car_models';
			$wpdb->update(
				$table,
				array(
					'license_code' => "$no1-$no2",	// string
				),
				array( 'code_levi' => $code,'year'=> $year )

			);
		}



	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
//	sleep(2);

}

function curlResponseHeaderCallback($ch, $headerLine) {
	global $cookies;
	if (preg_match('/^Set-Cookie:\s*([^;]*)/mi', $headerLine, $cookie) == 1)
		$cookies[] = $cookie;
	return strlen($headerLine); // Needed by curl
}


add_action('wp_ajax_snapir','snapir_loop' );


function snapir_loop(){

	global $wpdb;

	$table = $wpdb->prefix . 'car_models';

	$rows = $wpdb->get_results("select code_levi, year from $table  where  license_code=''");
	var_dump($rows);
	if($rows){
		foreach ( $rows as $row ) {
			sogo_get_snapir_data($row->code_levi,$row->year);
			die();
			echo "['{$row->code_levi}',{$row->year}]<br/>";
		}
	}
}



