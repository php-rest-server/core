<?php
/**
 * ExceptionHelper.php
 *
 * collection of functions to work with Exceptions
 *
 * @author Artem Kaplenko
 * @since 0.0.1
 * @version 0.0.1
 */

namespace RestCore\Core\Helpers;

class ExceptionHelper
{
    public static function showError(\Exception $e)
    {
        http_response_code($e->getCode());
        echo json_encode(['error' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()]);
    }
}
