<?php
/**
 * Created by PhpStorm.
 * User: bllem
 * Date: 27.07.17
 * Time: 17:02
 */

namespace RestCore\Exceptions;

use Throwable;

class ModuleNotFoundException extends \Exception
{
    public function __construct($message = 'Module not found', $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}