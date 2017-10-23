<?php
/**
 * Created by PhpStorm.
 * User: bllem
 * Date: 27.07.17
 * Time: 17:02
 */

namespace RestCore\Exceptions;

use Throwable;

class ActionNotFoundException extends \Exception
{
    public function __construct($message = 'Action not found', $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}