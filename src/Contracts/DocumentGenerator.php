<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 12/30/18
 * Time: 12:59 PM
 */

namespace Mvaliolahi\SibDoc\Contracts;


use Mvaliolahi\SibDoc\SibDoc;
use Mvaliolahi\SibDoc\Traits\ConfigTrait;

/**
 * Class DocumentGenerator
 * @package Mvaliolahi\SibDoc\Contracts
 */
abstract class DocumentGenerator
{
    use ConfigTrait;

    /**
     * @var
     */
    private $models;

    /**
     * @var array
     */
    private $endpoints = [];

    /**
     * @var mixed | null
     */
    private $backgroundColor;

    /**
     * DocumentGenerator constructor.
     * @param SibDoc $api
     */
    public function __construct(SibDoc $api)
    {
        $this->endpoints = $api->endpoints();
        $this->models = $api->models();

        $this->basicAttributes($api);
    }

    /**
     * @param SibDoc $api
     */
    private function basicAttributes(SibDoc $api): void
    {
        $this->title = $api->config('title');
        $this->description = $api->config('description');
        $this->baseUrl = $api->config('url');
        $this->backgroundColor = $api->config('background_color');
    }

    /**
     * @return array
     */
    public function groups()
    {
        $groups = [];

        foreach ($e = $this->endpoints() as $group => $endpoints) {
            if (!is_numeric($group)) {
                $groups[] = $group;
            } else {
                $groups[] = $e[$group]['url'];
            }
        }

        return $groups;
    }

    /**
     * @return array
     */
    public function endpoints()
    {
        return $this->endpoints;
    }

    /**
     * @return array
     */
    public function models()
    {
        return $this->models;
    }

    /**
     * @param null $backgroundColor
     * @return string | null
     */
    public function backgroundColor($backgroundColor = null)
    {
        if (!is_null($backgroundColor)) {
            return $this->backgroundColor = $backgroundColor;
        }

        return $this->backgroundColor;
    }

    /**
     * @param $path
     * @return mixed
     */
    public abstract function format($path);
}