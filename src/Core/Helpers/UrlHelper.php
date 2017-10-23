<?php
/**
 * UrlHelper.php
 *
 * collection of a function to work with urls
 *
 * @author Artem Kaplenko
 * @since 0.0.1
 * @version 0.0.1
 */

namespace RestCore\Core\Helpers;

use RestCore\Core\General\RouteInfo;

/**
 * Class UrlHelper
 * @package RestCore\Core\Helpers
 */
class UrlHelper
{
    /**
     * Replace dashes to CamelCase string format
     *
     * @param string $string
     * @return string
     */
    public static function dashToCamelCase($string)
    {
        $result = '';
        $urlPart = explode('-', $string);
        foreach ($urlPart as $word) {
            $result .= ucfirst(strtolower($word));
        }
        return $result;
    }


    /**
     * Parse route and return object RouteInfo with information about accepted
     * route or return false if route pattern does not math
     *
     * @param string $from
     * @param string $to
     * @param string $url
     * @return bool|RouteInfo
     */
    public static function routeParse($from, $to, $url)
    {
        // validation and parse route pattern
        $result = preg_match('/^(\(([^\)]+)\)|[^\/]*)(.*)/', $from, $data);

        if ($result !== 1) {
            return false;
        }

        // prepare patter to test url and replacement
        $pattern = '/^' . str_replace('/', '\/', $data[3]) . '$/';

        // test route pattern match
        $result = preg_match($pattern, $url);

        if ($result !== 1) {
            return false;
        }

        // create RouteInfo object and fill fields
        $route = new RouteInfo();
        // make array of supported methods
        $route->methods = empty($data[2]) ? [] : explode('|', $data[2]);
        // replace pattern url
        $route->url = preg_replace($pattern, $to, $url);

        return $route;
    }
}
