<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 18/12/14
 * Time: 15:27
 */
namespace ZfComplementeTest\JQuery\Validate\Rule;


use ZfComplemente\JQuery\Validate\Rule\Cpf;

class CpfTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Cpf
     */
    private  $_class;
    public function setUp ()
    {
        $this->_class = new Cpf();
        parent::setUp ();
    }

    public function testGetRule()
    {
       $this->assertArrayHasKey('cpf',$this->_class->getRules());
    }

    public function testGetMessage()
    {
        $this->assertArrayHasKey('cpf',$this->_class->getMessages());
    }

    public function testGetJsFile()
    {
        $this->assertTrue(is_string($this->_class->getFile()));
    }

}
 