<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 10/11/14
 * Time: 14:29
 */
namespace ZfComplementeTest\Form\Element;

use Zend\Form\Form;
use ZfComplemente\Form\Element\Phone as PhoneElement;

class PhoneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhoneElement
     */
    private $_element;

    /**
     * @var Form
     */
    private $_form;

    public function setUp ()
    {
        $this->_element = new PhoneElement();

        parent::setUp ();
    }

    /**
     *
     */
    public function testDefaultValidators ()
    {
        $inputSpec = $this->_element->getInputSpecification ();
        $this->assertArrayHasKey ('validators', $inputSpec);
        $this->assertInternalType ('array', $inputSpec['validators']);

        $expectedValidators = array (
            'Zend\Validator\Regex'
        );

        foreach ($inputSpec['validators'] as $i => $validator)
        {
            $class = get_class ($validator);
            $this->assertEquals ($expectedValidators[$i], $class);
        }
    }

    /** @dataProvider validatedDataProvider */
    public function testValidation ($data, $valid)
    {
        $this->_form = $this->creatForm ();
        $this->_form->setData (array ('telefone' => $data));
        $this->assertSame ($valid, $this->_form->isValid (), $data);
    }

    /**
     *
     */
    public function testValid ()
    {


        foreach ($this->validatedDataProvider() as $value)
        {
            $this->testValidation ($value[0], $value[1]);
        }
    }

    /** @dataProvider validatedDataProvider */
    public function validatedDataProvider ()
    {
        return array (
            array (
                '(032)555-5555',
                true
            ),

            array (
                '(011)111-111',
                true
            ),

            array (
                '(011)1111-1111',
                true
            ),

            array (
                '1(11)1111-111',
                false
            ),


            array (
                '(11) 1111-1111',
                false
            ),

            array (
                '1111111',
                false
            )
        );
    }

    /**
     * @return Form
     */
    public function creatForm ()
    {
        $form = new Form();
        $form->add (array (
            'name' => 'telefone',
            'type' => 'ZfComplemente\Form\Element\Phone',
        ));
        return $form;
    }

}
 