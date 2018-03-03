<?php
/**
 * User: dinhlq
 * Date: 3/3/2018
 * Time: 14:29
 */

namespace App\Helpers;

class MessageApi
{
    const ITEM_DOES_NOT_EXISTS = 'Item dose not exist';
    const UPLOAD_IMAGE_FAILED = 'Upload image failed';
    const SOMETHING_WRONG = 'Something went wrong';

    public static function success(array $data): array
    {
        return [
            'status'  => 200,
            'message' => 'success',
            'data'    => ($data) ? $data : [],
        ];
    }

    public static function error($code, array $data): array
    {
        return [
            'status'  => $code,
            'message' => $data,
        ];
    }
}