<?php

namespace App\Services;

class KeypairService
{
    /**
     * Creates a keypar.
     *
     * @return string
     */
    public static function createKeypair()
    {   
        return sodium_crypto_kx_keypair();
    }

    /**
     * Get Public Key.
     *
     * @param string $keypair
     * @return string
     */
    public static function getPublicKey($keypair)
    {   
        return bin2hex(sodium_crypto_kx_publickey($keypair));
    }
    
    /**
     * Get Secret Key.
     *
     * @param string $keypair
     * @return string
     */
    public static function getSecretKey($keypair)
    {   
        return bin2hex(sodium_crypto_kx_secretkey($keypair));
    }

    /**
     * Creates a keypar from public and private key.
     *
     * @param string $public, $secret
     * @return string
     */
    public static function keypairFromKeys($public, $secret)
    {   
        $public = hex2bin($public);
        $secret = hex2bin($secret);
        return sodium_crypto_box_keypair_from_secretkey_and_publickey($secret, $public);
    }

    /**
     * Crypts a message
     *
     * @param string $message, $public
     * @return string
     */
    public static function cryptMessage($message, $public)
    {   
        return sodium_crypto_box_seal($message, $public);
    }

    /**
     * Decrypts a message
     *
     * @param string $message, $keypair
     * @return string
     */
    public static function decryptMessage($message, $keypair)
    {   
        return sodium_crypto_box_seal_open($message, $keypair);
    }
}
