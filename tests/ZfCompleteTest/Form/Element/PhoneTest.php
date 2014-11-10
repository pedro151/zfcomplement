<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 10/11/14
 * Time: 14:29
 */
namespace ZfComplementeTest\Form\Element;

use ZfComplemente\Form\Element\Phone as PhoneElement;

class PhoneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhoneElement
     */
    private $_element;

    public function setUp ()
    {
        $this->_element = new PhoneElement();

        parent::setUp();
    }

    public function testDefaultValidators()
    {
        $inputSpec = $this->_element->getInputSpecification();
        $this->assertArrayHasKey('validators', $inputSpec);
        $this->assertInternalType('array', $inputSpec['validators']);

        $expectedValidators = array(
            'Zend\Validator\Regex'
        );

        foreach ($inputSpec['validators'] as $i => $validator) {
            $class = get_class($validator);
            $this->assertEquals($expectedValidators[$i], $class);
        }
    }

    public function setDown ()
    {

    }

}
 