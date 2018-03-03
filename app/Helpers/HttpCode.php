<?php
/**
 * User: dinhlq
 * Date: 25/1/2018
 * Time: 5:58 AM
 */

namespace App\Helpers;


class HttpCode
{
    const FAILED = 100;
    const SUCCESS = 200;
    const WARNING = 300;

    const INVALID_METHOD_CODE = 101;
    const NOT_VALID_INFORMATION = 102;
    const SOMETHING_WENT_WRONGS = 103;
    const ACCOUNT_IS_NOT_ACTIVE = 104;

    const UNKNOWN_ERROR = 300;
    const MISSING_TOKEN = 400;
    const INVALID_TOKEN = 401;
}