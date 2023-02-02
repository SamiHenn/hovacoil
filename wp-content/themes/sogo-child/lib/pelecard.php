<?php


class pelecard
{


    private $gateway = 'https://gateway20.pelecard.biz/PaymentGW/';

    private $setting;

    function __construct()
    {
        if(false){
            $setting = new \stdClass();
            $setting->terminal = '0962210';
            $setting->user = 'shivukTest';
            $setting->password = 'r4FW1BDP';
            $this->setting = $setting;
        }else{
            $setting = new \stdClass();
            $setting->terminal = '5794777010';
            $setting->user = 'sami6';
            $setting->password = 'j10S4wVd';
            $this->setting = $setting;
        }



    }

    public function redirect_url($order_id)
    {
        $currency = "ILS";
        switch ($currency) {
            case 'ILS':
                $currency = '1';
                break;
            case 'USD':
                $currency = '2';
                break;
            case 'EUR':
                $currency = '978';
                break;
            default :
                die("Currency not supported : " . $currency);
                break;
        }
        $return_url = get_site_url(null, '/wp-content/themes/sogo-child/payment-callback.php', 'https');

        $data = array(
            "terminal" => $this->setting->terminal,
            "user" => $this->setting->user,
            "password" => $this->setting->password,

            "GoodURL" => $return_url,
            "ErrorURL" => $return_url,
            "ActionType" => "J2",
            "Currency" => $currency,
            "Total" => 1,
            "CreateToken" => "True",
            "cs_phone" => "True",
            "Language" => "HE",
            "CustomerIdField" => "must",
            "CardHolderName" => "must",
            "CardHolderID" => "",
            "Cvv2Field"       => "hide",
            "TelField" => "must",
            "ShopNo" => "001",
            "ParamX" => $order_id,
            "cssURL" => get_stylesheet_directory_uri() . "/css/pele1.css",
            "LogoURL" => "https=>//gateway20.pelecard.biz/Content/images/Pelecard.png"
        );

        $response = $this->sendRequest($this->gateway . 'init', $data);
 

        return $response->URL;


    }

    public function callback()
    {

        $this->log_debug(sprintf('%s: start', __FUNCTION__));
        $this->log_debug(sprintf('_GET: %s', print_r($_GET, true)));

//        if ($_GET['PelecardStatusCode'] !== '000') {
//            echo 'payment failed';
//            $this->log_debug(sprintf('_GET: %s', 'payment failed'));
//
//            die();
//        }

        $transaction_id = $_GET['PelecardTransactionId'];

        $entry['transaction_id'] = $transaction_id;
        $entry['transaction_type'] = '1';
        $data = $this->get_transaction();

        if ($data) {
            $token = $data->Token;
            $CreditCardNumber = $data->CreditCardNumber;
            $CreditCardExpDate = $data->CreditCardExpDate;
            $CreditCardExpYear = substr($CreditCardExpDate, 2, 4);
            $CreditCardExpMonth = substr($CreditCardExpDate, 0, 2);
            $CardHolderName = $data->CardHolderName;
            $CardHolderID = $data->CardHolderID;
            $CardHolderPhone = $data->CardHolderPhone;
            $order_id = $data->AdditionalDetailsParamX;
            // update the crm with the token for that order id (row in crm)
            // redirect user to the thx page just like the no credit flow does.
            $order_params = update_option('insurance-order_paid_' . $order_id, $token);
            sogo_request_crm(array(
                'token' => $token,
                'order_id' => $order_id,
                'credit_card_number' => $CreditCardNumber,
                'credit_card_exp_month' => $CreditCardExpMonth,
                'credit_card_exp_year' => $CreditCardExpYear,
                'cardholder_id' => $CardHolderID,
                'cardholder_phone' => $CardHolderPhone,
                'cardholder_name' => $CardHolderName), 'updatePaymentOrder');
        }
//        $return_url = get_site_url(null, 'settings/', 'https');
//      //  wp_redirect($return_url);

    }


    public function get_transaction()
    {

        $data = array(
            "terminal" => $this->setting->terminal,
            "user" => $this->setting->user,
            "password" => $this->setting->password,
            'TransactionId' => $_GET['PelecardTransactionId']
        );

        $transaction = $this->sendRequest($this->gateway . 'GetTransaction', $data);
        $this->log_debug('transaction: ' . print_r($transaction, true));
        //var_dump($transaction);die;
//        if ($transaction->StatusCode === '000') {
            // success
            $data = $transaction->ResultData;
            //   $exp = "20" . substr($data->CreditCardExpDate, 2) . "-" . substr($data->CreditCardExpDate, 2, 2) . "-20";
            //var_dump($data);die;
            return $data;
//            $card = array(
//                'token'                 => $data->Token,
//                'ConfirmationKey'       => $data->ConfirmationKey,
//                'TransactionPelecardId' => $data->TransactionPelecardId,
//                'CreditCardNumber'      => $data->CreditCardNumber,
//                'CreditCardExpDate'     => $exp,
//            );
//        //    update_option('_sogo_card_token', $card);
////            return true;
//        }
//        return false;


    }

    function sendRequest($gateway_url, $request)
    {
        $request = json_encode($request);

        $CR = curl_init();
        curl_setopt($CR, CURLOPT_URL, $gateway_url);
        curl_setopt($CR, CURLOPT_POST, 1);
        curl_setopt($CR, CURLOPT_POSTFIELDS, $request);
        curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($CR, CURLOPT_FAILONERROR, true);

        curl_setopt($CR, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            )
        );

        //actual curl execution
        $result = curl_exec($CR);
        $error = curl_error($CR);

        // on error - die with error message
        if (!empty($error)) {
            die($error);
        }

        curl_close($CR);
        return json_decode($result);

    }

    private function log_debug($obj)
    {
        ob_start();
        var_dump($obj);
        echo "\n";
        file_put_contents(__DIR__ . "/pelecardBilling.log", ob_get_clean(), FILE_APPEND);

    }

    private function log($obj)
    {
        global $wpdb;
        $table = 'pdf_pelecard_log';// we use it as in multi site we want only one table for all sites

        $wpdb->insert($table, array('StatusCode' => $obj->StatusCode, 'ErrorMessage' => $obj->ErrorMessage, 'ResultData' => json_encode($obj->ResultData)));

    }


}
