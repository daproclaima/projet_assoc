<?php
/**
 * Created by PhpStorm.
 * User: SNITPRO
 * Date: 09/01/2019
 * Time: 13:05
 */

namespace App\Controller;


trait HelperTrait
{
    /**
    * @param $text
    * @return false|string|string[]|null
    */
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}