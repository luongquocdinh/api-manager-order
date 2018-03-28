<?php
/**
 * User: dinhlq
 * Date: 3/3/2018
 * Time: 14:29
 */

namespace App\Helpers;

class MessageApi
{
    const ITEM_DOES_NOT_EXISTS = 'Dữ liệu này không còn tồn tại';
    const UPLOAD_IMAGE_FAILED = 'Upload image failed';
    const SOMETHING_WRONG = 'Xảy ra lỗi khi xử lý';

    public static function success(array $data): array
    {
        return [
            'status'  => 200,
            'message' => 'success',
            'data'    => ($data) ? $data : [],
        ];
    }

    public static function error($code, $data): array
    {
        return [
            'status'  => $code,
            'message' => $data,
        ];
    }
}