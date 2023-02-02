<?php
require_once '../../../wp-load.php';
ignore_user_abort ();
set_time_limit(0);
function sogo_build_rows_from_api($source)
{
    if($source === 'car'){
        $gov_resource_id = '053cea08-09bc-40ec-8f7a-156f0677aff3';
        $table = 'wp_gov_license_numbers';
    }elseif($source === 'model'){
        $gov_resource_id = '142afde2-6228-49f9-8a29-9b6c3a0cbe40';
        $table = 'wp_gov_car_models';
    }else{
        $gov_resource_id = -1;
    }
    $url = "/api/3/action/datastore_search?resource_id={$gov_resource_id}&include_total=1&limit=1000";
    $total = 10000000000000;
    $inx = 0;
    if($gov_resource_id !== -1) {
        while ($total > $inx) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://data.gov.il'. $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            global $wpdb;
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $res = json_decode($response, true);
                $rows = $res['result']['records'];
                if ($table === 'wp_gov_license_numbers') {

                    $fields_array = ['tozeret_cd', 'tozeret_nm', 'degem_cd', 'sug_degem', 'shnat_yitzur', 'mispar_rechev'];

                } elseif($table === 'wp_gov_car_models') {

                    $fields_array = [
                        'tozeret_cd',
                        'tozeret_nm',
                        'degem_cd',
                        'sug_degem',
                        'shnat_yitzur',
                        'bakarat_stiya_menativ_ind',
                        'nitur_merhak_milfanim_ind',
                        'nefah_manoa',
                        'bakarat_yatzivut_ind',
                        'delek_cd',
                        'koah_sus',
                        'abs_ind',
                        'mispar_kariot_avir'
                    ];

                }else{
                    break;
                }

                if (count($rows) !== 0) {
                    if($inx === 0) {
                        $wpdb->query("TRUNCATE TABLE $table"); // clear table before inserting new values
                    }
                    for ($i = 0; $i < count($rows); $i++) {
                        $query_row = [];
                        for ($j = 0; $j < count($fields_array); $j++) {
                            $query_row[$fields_array[$j]] = $rows[$i][$fields_array[$j]];
                        }
                        $wpdb->insert($table, $query_row);
                    }
                } else {
//                    echo 'here';
//                    var_dump($rows);die();
                    break;
                }

                $url = $res['result']['_links']['next'];
                $inx++;
            }
        } //end while loop
    }
}



sogo_build_rows_from_api('car');
