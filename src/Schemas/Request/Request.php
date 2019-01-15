<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 12/29/18
 * Time: 12:11 PM
 */

namespace Mvaliolahi\SibDoc\Schemas\Request;


use Mvaliolahi\SibDoc\Contracts\Schema;
use Mvaliolahi\SibDoc\Schemas\Response\Response;
use Mvaliolahi\SibDoc\Traits\HeaderTrait;

/**
 * Class Request
 * @package Mvaliolahi\SibDoc\Request
 */
class Request implements Schema
{
    use HeaderTrait;

    /**
     * @var string
     */
    private $version;

    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $description;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var RequestBody
     */
    private $body;

    /**
     * @var mixed
     */
    private $meta;

    /**
     * All Available Response for specific request.
     *
     * @var array
     */
    private $responses = [];

    /**
     * @param $version
     * @return $this
     */
    public function version($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @param $mata
     * @return $this
     */
    public function meta($mata)
    {
        $this->meta = $mata;

        return $this;
    }

    /**
     * @param $title
     * @return Request
     */
    public function title($title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param $description
     * @return $this
     */
    public function description($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param array $params
     * @return Request
     */
    public function parameters($params = [])
    {
        $this->parameters = $params;

        return $this;
    }

    /**
     * @param $alias
     * @param Response $response
     */
    public function response($alias, $response = null)
    {
        if ($alias instanceof Response) {
            $response = $alias;
            $alias = $alias->title();
        }

        $this->responses[$alias] = $response;
    }

    /**
     * @return array
     */
    public function responses()
    {
        return $this->responses;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $request = [
            'title'       => $this->title,
            'description' => $this->description,
            'version'     => $this->version,
            'headers'     => $this->headers,
            'parameters'  => $this->parameters,
            'body'        => $this->body()->get(),
            'meta'        => $this->meta,
        ];

        $request = array_filter($request, function ($item) {
            return $item !== null;
        });

        return [
            'request'  => $request,
            'response' => $this->fetchResponses(),
        ];
    }

    /**
     * @return RequestBody
     */
    public function body()
    {
        if (!is_null($this->body)) {
            return $this->body;
        }

        return $this->body = (new RequestBody());
    }

    /**
     * @return array
     */
    private function fetchResponses()
    {
        $responses = [];

        foreach ($this->responses as $alias => $response) {
            $responses[$alias] = $response->toArray();
        }

        return $responses;
    }

    /**
     * @param array $headers
     * @return Request
     */
    public function headers($headers = [])
    {
        $this->headers = array_replace($this->headers, $headers);

        return $this;
    }
}