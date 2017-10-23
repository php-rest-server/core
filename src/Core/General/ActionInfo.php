<?php
/**
 * ActionInfo.php
 *
 * Class describes allowed methods for action
 *
 * @author Artem Kaplenko
 * @since 0.0.1
 * @version 0.0.1
 */

namespace RestCore\Core\General;

use RestCore\Core\Enums\HttpMethods;

/**
 * Class ActionInfo
 * @package RestCore\Core\General
 */
class ActionInfo
{
    /**
     * @var bool
     */
    public $get;

    /**
     * @var bool
     */
    public $post;

    /**
     * @var bool
     */
    public $put;

    /**
     * @var bool
     */
    public $path;

    /**
     * @var bool
     */
    public $delete;

    /**
     * @var bool
     */
    public $head;

    /**
     * @var bool
     */
    public $options;


    /**
     * Set internal field when object creating
     *
     * @param bool $get
     * @param bool $post
     * @param bool $put
     * @param bool $path
     * @param bool $delete
     * @param bool $head
     * @param bool $options
     */
    public function __construct(
        $get = true,
        $post = false,
        $put = false,
        $path = false,
        $delete = false,
        $head = false,
        $options = false
    ) {
        $this->get = $get;
        $this->post = $post;
        $this->put = $put;
        $this->path = $path;
        $this->delete = $delete;
        $this->head = $head;
        $this->options = $options;
    }


    /**
     * Check if this method allowed for this action
     *
     * @param string $method
     * @return bool
     */
    public function testMethod($method)
    {
        switch ($method) {
            case HttpMethods::GET:
                return $this->get;
            case HttpMethods::POST:
                return $this->post;
            case HttpMethods::PUT:
                return $this->put;
            case HttpMethods::PATCH:
                return $this->path;
            case HttpMethods::DELETE:
                return $this->delete;
            case HttpMethods::HEAD:
                return $this->head;
            case HttpMethods::OPTIONS:
                return $this->options;
            default:
                return false;
        }
    }


    /**
     * Get array of allowed methods for this action
     *
     * @return string[]
     */
    public function getAllowedMethods()
    {
        $result = [];
        if ($this->get) {
            $result[] = HttpMethods::GET;
        }
        if ($this->post) {
            $result[] = HttpMethods::POST;
        }
        if ($this->put) {
            $result[] = HttpMethods::PUT;
        }
        if ($this->path) {
            $result[] = HttpMethods::PATCH;
        }
        if ($this->delete) {
            $result[] = HttpMethods::DELETE;
        }
        if ($this->head) {
            $result[] = HttpMethods::HEAD;
        }
        if ($this->options) {
            $result[] = HttpMethods::OPTIONS;
        }

        return $result;
    }
}
