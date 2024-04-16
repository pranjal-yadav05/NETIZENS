<?php

// Base64 encoded AES-256 key
$encryptionKey = "8yQOaTDSVvAhSLzKvMfJhXambe1V41F4p0XEinl+HyM=";

// Function to encrypt a message using AES-256 encryption
function encryptMessage($message, $encryptionKey, $iv) {
    // Decode the Base64 encoded key
    $key = base64_decode($encryptionKey);

    // Perform AES-256 encryption
    $encryptedMessage = openssl_encrypt($message, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv);

    // Encode the encrypted message in Base64 format
    $encodedMessage = base64_encode($encryptedMessage);

    return $encodedMessage;
}

// Function to decrypt a message using AES-256 decryption
function decryptMessage($encodedMessage, $encryptionKey, $iv) {
    // Decode the Base64 encoded key
    $key = base64_decode($encryptionKey);

    // Decode the Base64 encoded message
    $encryptedMessage = base64_decode($encodedMessage);

    // Perform AES-256 decryption
    $decryptedMessage = openssl_decrypt($encryptedMessage, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv);

    return $decryptedMessage;
}
?>
