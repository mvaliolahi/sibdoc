<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 12/30/18
 * Time: 9:13 AM
 */

namespace Mvaliolahi\SibDoc\Schemas\Request;


/**
 * Class RequestBody
 * @package Mvaliolahi\SibDoc\Schemas\Request
 */
class RequestBody
{
    /**
     * @var array
     */
    private $body = [];

    /**
     * @param $data
     */
    public function formData($data)
    {
        $this->body['form-data'] = $data;
    }

    /**
     * @param $data
     * @return $this
     */
    public function xWWWFormUrlEncode($data)
    {
        $this->body['x-www-form-urlencode'] = $data;

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function raw($data)
    {
        $this->body['raw'] = $data;

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function binary($data)
    {
        $this->body['binary'] = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->body;
    }
}