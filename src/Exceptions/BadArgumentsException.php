<?php
/**
 * Created by PhpStorm.
 * User: bllem
 * Date: 27.07.17
 * Time: 17:02
 */

namespace RestCore\Exceptions;

use Throwable;

class BadArgumentsException extends \Exception
{
    public function __construct($message = 'Path not found', $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}