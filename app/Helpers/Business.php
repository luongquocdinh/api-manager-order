<?php
/**
 * Created by PhpStorm.
 * User: thai
 * Date: 8/1/2018
 * Time: 2:35 PM
 */

namespace App\Helpers;

use Hashids\Hashids;

class Business
{
    const IS_DELETE = '1';
    const IS_PUBLISH = '1';
    const PAGE_NUMBER_DEFAULT = 10;

    public static function encodeByHashID($id)
    {
        $minHashLength = 15;
        $hash = new Hashids(env('SALT'), $minHashLength);

        return $hash->encode($id);
    }

    public static function decodeByHashID($hashID)
    {
        $minHashLength = 15;
        $hash = new Hashids(env('SALT'), $minHashLength);

        return $hash->decode($hashID);
    }

    public static function getTypeImageUpload()
    {
        return [
            1 => 'Product',
        ];
    }
}