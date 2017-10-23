<?php
/**
 */

namespace RestCore\Core\Interfaces;


use RestCore\Core\General\ActionInfo;

interface ControllerInterface
{
    /**
     * @return ActionInfo[]
     */
    public function getMethods();
}