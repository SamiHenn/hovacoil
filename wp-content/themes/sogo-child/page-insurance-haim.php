<?php // Template Name: thank you
//get_header();
//the_post();

//prepare data for payment API
$payment_data = array(
	'CalculationType' => 84300001,
	'DesiredPeriod' => 2,
	'DesiredSum' => 100,
	'ListOfTracks' => array(),
	'NumberOfInsured' => 84200001,
	'PremiumType' => 84100001,
	'SortDirection' => 'asc',
	'SortField' => '',
	'ListOfInsured' => array(
		0 => array(
			'Age' => 34,
			'BirthDate' => "1984-07-04T10:00:00.000Z",
			'Gender' => 84400001,
			'ID' => 1,
			'IsSmoking' => true,
		)
	)
);

$payment_data = json_encode($payment_data);

$api_url = 'https://life.cma.gov.il/RiskParameters/CalculateRiskRates';

$curl = curl_init();
curl_setopt( $curl, CURLOPT_URL, $api_url );
$headers = [
	'Accept: */*',
	'Cache-Control: no-cache',
//	'Content-Type: application/json; charset=utf-8',
	'Content-Type: application/json',
	'Cookie: ASP.NET_SessionId=w2vuqdi5amsjex3kg1ltp03e',
];
curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $curl, CURLOPT_AUTOREFERER, true );
curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
curl_setopt( $curl, CURLOPT_POST, 1 );
curl_setopt( $curl, CURLOPT_POSTFIELDS, $payment_data );

//execute post
$result = curl_exec( $curl );

/*$DOM = new DOMDocument;
$DOM->loadHTML($result);
$xpath = new DOMXPath($DOM);*/

//$results = $xpath->query("//div[@class='terminal']");

$api_url2 = 'https://life.cma.gov.il/RiskParameters/ExportToExcel';

$curl2 = curl_init();
curl_setopt( $curl2, CURLOPT_URL, $api_url2 );
$headers = [
	'Cache-Control: private',
'Content-Disposition: attachment; filename=RiskResults-2018-09-05_12-42-28-PM.xlsx',
'Content-Length: 10844',
'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
'Date: Wed, 05 Sep 2018 09:42:28 GMT',
'SERVER: ',
'SiteSq: 1',
//	'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
//	'Cache-Control: private',
//	'Content-length: 10844',
////	'Content-Type: application/json; charset=utf-8',
//	'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
	'Cookie: ASP.NET_SessionId=w2vuqdi5amsjex3kg1ltp03e',
];
curl_setopt( $curl2, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $curl2, CURLOPT_RETURNTRANSFER, true );
//curl_setopt( $curl2, CURLOPT_AUTOREFERER, true );
curl_setopt( $curl2, CURLOPT_TIMEOUT, 10 );
curl_setopt( $curl2, CURLOPT_POST, 1 );
//curl_setopt( $curl, CURLOPT_POSTFIELDS, $payment_data );

$excel = curl_exec( $curl2 );
echo '<pre style="direction: ltr;">';
//var_dump($result);
var_dump($excel);
echo '</pre>';
?>

<?php get_footer() ?>