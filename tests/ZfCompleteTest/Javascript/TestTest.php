<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 12/11/14
 * Time: 14:20
 */

namespace ZfComplementeTest\Javascript;


use Zend\Debug\Debug;
use ZfComplemente\Javascript\Test;

class TestTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultValidators ()
    {
        $test = new Test();
       Debug::dump($test->_getPublicPath());
    }
}
 