<?php
/**
 * Created by PhpStorm.
 * User: bllem
 * Date: 27.07.17
 * Time: 17:02
 */

namespace RestCore\Exceptions;

use Throwable;

class BadPathException extends \Exception
{
    public function __construct($message = 'Path not found', $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}