<?php
/**
 * Created by PhpStorm.
 * User: bllem
 * Date: 01.08.17
 * Time: 00:45
 */

namespace RestCore\Core\Interfaces;

/**
 * Interface CypherInterface
 * @package RestCore\Core\Interfaces
 */
interface CypherInterface
{
    public function __construct(array $params = []);

    public function encode($data);

    public function decode($data);
}