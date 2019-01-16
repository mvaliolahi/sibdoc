<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 1/16/19
 * Time: 5:00 PM
 */

namespace Mvaliolahi\SibDoc\Generators\Mock;


use Mvaliolahi\SibDoc\Contracts\DocumentGenerator;

/**
 * Class Mock
 * @package Mvaliolahi\SibDoc\Generators\Mock
 */
class Mock extends DocumentGenerator
{
    /**
     * @param $path
     * @return mixed
     */
    public function format($path)
    {
        return 'this a a mock version';
    }
}