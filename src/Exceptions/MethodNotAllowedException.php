<?php
/**
 * Created by PhpStorm.
 * User: bllem
 * Date: 27.07.17
 * Time: 17:02
 */

namespace RestCore\Exceptions;

use Throwable;

class MethodNotAllowedException extends \Exception
{
    public function __construct($message = 'Method not allowed', $code = 405, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}