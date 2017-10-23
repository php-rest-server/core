<?php
/**
 * Created by PhpStorm.
 * User: bllem
 * Date: 26.07.17
 * Time: 15:27
 */

namespace RestCore\Core;

use RestCore\Core\General\ActionInfo;
use RestCore\Core\Interfaces\ControllerInterface;

abstract class Controller implements ControllerInterface
{
    /**
     * @return ActionInfo[]
     */
    public function getMethods()
    {
        return [];
    }

    public function __construct()
    {
    }

}