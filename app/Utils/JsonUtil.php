<?php


namespace App\Utils;

use Illuminate\Support\Facades\Response;

class JsonUtil
{

    /*
     * STATUS CODES ::
     * 200  OK
     * 201  Created
     * 400  Bad Request
     * 401  Unauthorized
     * 403  Forbidden
     * 404  Not Found
     * 405  Method not allowed
     * 500  Internal Server Error
     */

    public static $_STATUS_OK = 200;
    public static $_CREATED = 201;
    public static $_BAD_REQUEST = 400;
    public static $_UNAUTHORIZED = 401;
    public static $_FORBIDDEN = 403;
    public static $_NOT_FOUND = 404;
    public static $_CONFLICT = 409;
    public static $_UNPROCESSABLE_ENTITY = 422;
    public static $_METHOD_NOT_ALLOWED = 405;
    public static $_INTERNAL_SERVER_ERROR = 500;


    public static function getResponse(bool $success, string $message, int $statusCode, $data = null) {

        $data = array(
            'success' => $success,
            'status' => $statusCode,
            'message' => $message,
            'data' => $data
        );

        return Response::json($data, $statusCode);
    }

    /*
    ---------------------------------------
    Success
    ---------------------------------------
    */

    public static function success($data = null, string $message = "Success") {
        return JsonUtil::getResponse(true, $message, JsonUtil::$_STATUS_OK, $data);
    }

    /*
    ---------------------------------------
    Method not allowed
    ---------------------------------------
    */

    public static function methodNotAllowed() {
        return JsonUtil::getResponse(false, "Method not allowed", JsonUtil::$_METHOD_NOT_ALLOWED);
    }

    /*
    ---------------------------------------
    Unprocessable entity
    ---------------------------------------
    */

    public static function unprocessableEntity(string $message = "") {
        return JsonUtil::getResponse(false, $message, JsonUtil::$_UNPROCESSABLE_ENTITY);
    }

    /*
    ---------------------------------------
    Internal Server Error
    ---------------------------------------
    */

    public static function serverError(string $message = "Server error")
    {
        return JsonUtil::getResponse(false, $message, JsonUtil::$_INTERNAL_SERVER_ERROR);
    }


    /*
    ---------------------------------------
    Access Denied
    ---------------------------------------
    */

    public static function accessDenied(string $message = "Unauthorized access")
    {
        return JsonUtil::getResponse(false, $message, JsonUtil::$_UNAUTHORIZED);
    }
    /*
    ---------------------------------------
    Access Forbidden
    ---------------------------------------
    */

    public static function accessForbidden()
    {
        return JsonUtil::getResponse(false, "Access forbidden", JsonUtil::$_FORBIDDEN);
    }

    /*
    ---------------------------------------
    Not Found
    ---------------------------------------
    */

    public static function notFound(string $message = "Not found")
    {
        return JsonUtil::getResponse(false, $message, JsonUtil::$_NOT_FOUND);
    }

    /*
    ---------------------------------------
    Validation Error
    ---------------------------------------
    */

    public static function validationError($data = null, string $message = "Validation Error")
    {
        return JsonUtil::getResponse(false, $message, JsonUtil::$_UNPROCESSABLE_ENTITY, $data);
    }

}
