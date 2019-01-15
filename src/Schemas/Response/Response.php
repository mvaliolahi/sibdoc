<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 12/29/18
 * Time: 12:12 PM
 */

namespace Mvaliolahi\SibDoc\Schemas\Response;


use Mvaliolahi\SibDoc\Contracts\Schema;
use Mvaliolahi\SibDoc\Traits\HeaderTrait;

/**
 * Class Response
 * @package Mvaliolahi\SibDoc\Response
 */
class Response implements Schema
{
    use HeaderTrait;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var mixed
     */
    private $meta;

    /**
     * @var
     */
    private $headers = [];

    /**
     * @var int
     */
    private $code = 200;

    /**
     * @var mixed
     */
    private $body;

    /**
     * @param int $code
     * @return Response
     */
    public function code($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param $title
     * @return Response |  mixed
     */
    public function title($title = null)
    {
        if (is_null($title)) {
            return $this->title;
        }

        $this->title = $title;

        return $this;
    }

    /**
     * @param $description
     * @return Response |  mixed
     */
    public function description($description = null)
    {
        if (is_null($description)) {
            return $this->description;
        }

        $this->description = $description;

        return $this;
    }

    /**
     * @param $meta
     * @return $this
     */
    public function meta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * @param null $body
     * @return $this
     */
    public function body($body = null)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        $response = [
            'title'       => $this->title,
            'description' => $this->description,
            'headers'     => $this->headers,
            'code'        => $this->code,
            'body'        => $this->body,
            'meta'        => $this->meta,
        ];

        $response = array_filter($response, function ($item) {
            return $item !== null;
        });

        return $response;
    }

    /**
     * @param array $headers
     * @return Response
     */
    public function headers($headers = [])
    {
        $this->headers = array_replace($this->headers, $headers);

        return $this;
    }
}