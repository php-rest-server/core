<?php
/**
 * HttpMethods.php
 *
 * Class contains constants with http RestFull API methods
 *
 * @author Artem Kaplenko
 * @since 0.0.1
 * @version 0.0.1
 */

namespace RestCore\Core\Enums;

/**
 * Class HttpMethods
 * @package RestCore\Core\Enums
 */
class HttpMethods
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';
    const HEAD = 'HEAD';
    const OPTIONS = 'OPTIONS';
}
