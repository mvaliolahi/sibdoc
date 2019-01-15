<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 12/29/18
 * Time: 3:01 PM
 */

namespace Mvaliolahi\SibDoc\Traits;

/**
 * Class HeaderTrait
 * @package Mvaliolahi\SibDoc\Traits
 */
trait HeaderTrait
{
    /**
     * @return bool
     */
    public function isHeaderEmpty()
    {
        return count($this->headers) == 0;
    }
}