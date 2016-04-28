<?php
namespace Kr\OAuthServerBundle\Security\Utils;

class Random
{
    const ALPHA_NUMERIC = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    /**
     * @param int $length
     * @param string $characters
     * @return string
     */
    public function generateString($length = 12, $characters = self::ALPHA_NUMERIC)
    {
        $randomString = "";
        for($i = 0; $i < $length; $i++) {
            $index = random_int(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }
}