<?php
/**
 * ActionAttribute.php
 *
 * Model of action attribute. Used in router.
 *
 * @author Artem Kaplenko
 * @since 0.0.1
 * @version 0.0.1
 */

namespace RestCore\Core\General;

/**
 * Class ActionAttribute
 * @package RestCore\Core\General
 */
class ActionAttribute
{
    public $name;
    public $isRequired;
    public $defaultValue;
}
