<?php

namespace IMAG\PhdCallBundle\Util;

final class Security
{
    /**
     * Calculate a uniq password only based on alpha-numeric characters
     * 
     * @param int length
     * @return string output
     */
    public static function randomPassword($length = 8)
    {
        $allowedChars = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $i = 0;
        $output = '';

        do {
            $shuffle = str_shuffle($allowedChars);
            $output .= $shuffle[rand(0, strlen($allowedChars - 1))];
            $i++;
        } while($i < $length);

        return $output;
    }
}