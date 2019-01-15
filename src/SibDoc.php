<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 12/29/18
 * Time: 10:40 AM
 */

namespace Mvaliolahi\SibDoc;


use Mvaliolahi\SibDoc\Generators\HTML\HTML;
use Mvaliolahi\SibDoc\Schemas\Request\Request;
use Mvaliolahi\SibDoc\Traits\ConfigTrait;

/**
 * Class SibDoc
 * @package Mvaliolahi\SibDoc
 */
class SibDoc
{
    use ConfigTrait;

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var array
     */
    private $models = [];

    /**
     * @var array
     */
    private $endpoints = [];

    /**
     * @var array
     */
    private $requestHeader = [];

    /**
     * @var array
     */
    private $responseHeader = [];

    /**
     * @var array
     */
    private $generators = [
        'html' => HTML::class,
    ];

    /**
     * ConfigTrait constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        $this->title = $config['title'] ?? '';
        $this->description = $config['description'] ?? '';
        $this->baseUrl = $config['url'] ?? '';
        $this->addCustomGenerator($config);
    }

    /**
     * @param $config
     */
    private function addCustomGenerator($config): void
    {
        if (isset($config['generator']) && is_array($config['generator'])) {
            $this->generators = array_merge($this->generators, $config['generator']);
        }
    }

    /**
     * @param null $name
     * @param $callback
     */
    public function group($name, $callback)
    {
        $api = new SibDoc();
        $callback($api);

        $this->endpoints[$name] = $api->endpoints();
    }

    /**
     * @return array
     */
    public function endpoints()
    {
        return $this->endpoints;
    }

    /**
     * @param $url
     * @param $callback
     * @return array
     */
    public function get($url, $callback)
    {
        return $this->endpoints[] = $this->defineEndpoint('GET', $url, $callback);
    }

    /**
     * @param string $method
     * @param $url
     * @param $callback
     * @return array
     */
    private function defineEndpoint($method, $url, $callback)
    {
        $callback($request = (new Request));

        if ($request->isHeaderEmpty()) {
            $request->headers($this->requestHeader);
        }

        $this->fillResponseHeadersIfWereEmpty($request);

        return [
            'url'    => trim($url, '/'),
            'method' => $method,
            'http'   => $request->toArray(),
        ];
    }

    /**
     * @param Request $request
     */
    private function fillResponseHeadersIfWereEmpty(Request $request)
    {
        foreach ($request->responses() as $response) {
            if ($response->isHeaderEmpty()) {
                $response->headers($this->responseHeader);
            }
        }
    }

    /**
     * @param $url
     * @param $callback
     * @return array
     */
    public function post($url, $callback)
    {
        return $this->endpoints[] = $this->defineEndpoint('POST', $url, $callback);
    }

    /**
     * @param $url
     * @param $callback
     * @return array
     */
    public function put($url, $callback)
    {
        return $this->endpoints[] = $this->defineEndpoint('PUT', $url, $callback);
    }

    /**
     * @param $url
     * @param $callback
     * @return array
     */
    public function patch($url, $callback)
    {
        return $this->endpoints[] = $this->defineEndpoint('PATCH', $url, $callback);
    }

    /**
     * @param $url
     * @param $callback
     * @return array
     */
    public function delete($url, $callback)
    {
        return $this->endpoints[] = $this->defineEndpoint('DELETE', $url, $callback);
    }

    /**
     * @param $url
     * @param $callback
     * @return array
     */
    public function head($url, $callback)
    {
        return $this->endpoints[] = $this->defineEndpoint('HEAD', $url, $callback);
    }

    /**
     * @param $url
     * @param $callback
     * @return array
     */
    public function connect($url, $callback)
    {
        return $this->endpoints[] = $this->defineEndpoint('CONNECT', $url, $callback);
    }

    /**
     * @param $url
     * @param $callback
     * @return array
     */
    public function options($url, $callback)
    {
        return $this->endpoints[] = $this->defineEndpoint('OPTIONS', $url, $callback);
    }

    /**
     * @param $url
     * @param $callback
     * @return array
     */
    public function trace($url, $callback)
    {
        return $this->endpoints[] = $this->defineEndpoint('TRACE', $url, $callback);
    }

    /**
     * @param array $headers
     */
    public function requestHeaders($headers = [])
    {
        $this->requestHeader = $headers;
    }

    /**
     * @param $headers
     */
    public function responseHeaders($headers)
    {
        $this->responseHeader = $headers;
    }

    /**
     * @return mixed|string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return mixed|string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @return mixed|string
     */
    public function url()
    {
        return $this->baseUrl;
    }

    /**
     * @param $name
     * @param array $structure
     * @return mixed
     */
    public function model($name, $structure = [])
    {
        if (count($structure) == 0 || is_string($structure)) {
            return $this->models[$name];
        }

        $this->models[$name] = $structure;
    }

    /**
     * @return array
     */
    public function models()
    {
        return $this->models;
    }

    /**
     * @param $name
     * @return array
     */
    public function config($name)
    {
        return $this->config[$name] ?? null;
    }

    /**
     * @param string $generator
     * @param string $path
     * @return mixed
     * @throws Exceptions\ExportPathNotSetException
     */
    public function saveTo($path = null, $generator = 'html')
    {
        if (array_key_exists($generator, $this->generators)) {
            return (new $this->generators[$generator]($this))->format($path);
        }

        return (new HTML($this))->format($path);
    }
}