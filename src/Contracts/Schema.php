<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 12/29/18
 * Time: 4:32 PM
 */

namespace Mvaliolahi\SibDoc\Contracts;


/**
 * Interface SchemaBuilder
 * @package Mvaliolahi\SibDoc\Contracts
 */
interface Schema
{
    /**
     * @return mixed
     */
    public function toArray();
}