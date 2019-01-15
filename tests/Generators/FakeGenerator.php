<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 1/14/19
 * Time: 1:24 PM
 */

namespace Tests\Generators;


use Mvaliolahi\SibDoc\Contracts\DocumentGenerator;

/**
 * Class FakeGenerator
 * @package Tests\Generators
 */
class FakeGenerator extends DocumentGenerator
{
    /**
     * @param $path
     * @return mixed
     */
    public function format($path)
    {
        return 'fake generator!';
    }
}