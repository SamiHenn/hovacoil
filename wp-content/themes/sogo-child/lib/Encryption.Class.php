<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11/7/2018
 * Time: 7:47 AM
 */

class Encryption {
    const ENCRYPT_TYPE = 'RC2-64-CBC';

    /**
     * @var $_key
     * generated key from function openssl_random_pseudo_bytes()
     * to decrypt must pass the same generated key NOT NEW!!!!!!!!
     */
    private $_key;

    public function __construct($key)
    {
        $this->_key = $key;
    }

    public function encrypt($param)
    {
        $result = openssl_encrypt($param, self::ENCRYPT_TYPE, $this->_key);

        return $result;
    }

    public function decrypt($param, $key = false)
    {
        $result = openssl_decrypt($param, self::ENCRYPT_TYPE, $this->_key);
        return $result;
    }

}

//$method = 'aes-128-gcm';
$key = openssl_random_pseudo_bytes(32);
$encription = new Encryption($key);



$plaintext = "1234567890";
$cipher = "RC2-64-CBC";

$x = $encription->encrypt($plaintext);
$x1 = $encription->decrypt($x);
