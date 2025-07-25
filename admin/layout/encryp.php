<?php

if (!function_exists('encryptId')) {
    function encryptId($id, $keypoint)
    {
        $method = 'AES-256-CBC';
        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($id, $method, $keypoint, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted);
    }
}

if (!function_exists('decryptId')) {
    function decryptId($encryptedData, $keypoint)
    {
        $method = 'AES-256-CBC';
        $data = base64_decode($encryptedData);
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);
        return openssl_decrypt($encrypted, $method, $keypoint, OPENSSL_RAW_DATA, $iv);
    }
}


$key = 'mykessecure';
