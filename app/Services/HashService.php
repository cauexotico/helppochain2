<?php

namespace App\Services;

class HashService
{
    /**
     * Creates a hash from array.
     *
     * @param array $args
     * @return array $args
     */
    public static function hashTransaction($args)
    {
        $unHashed = '';

        foreach($args as $v) {
            $unHashed = $unHashed . $v;
        }    

        $args['hash'] = HashService::createHash($unHashed);

        return $args;
    }
    /**
     * Creates a hash from string.
     *
     * @param string $string
     * @return string $hash
     */
    public static function createHash($string)
    {
        return hash('sha256', $string);
    }
}
