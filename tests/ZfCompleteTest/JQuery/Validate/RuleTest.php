<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 13/11/14
 * Time: 16:45
 */

namespace ZfComplementeTest\JQuery\Validate;

use Zend\Debug\Debug;
use Zend\Stdlib\ArrayUtils;
use ZfComplemente\JQuery\Validate\Cpf;
use ZfComplemente\JQuery\Validate\Phone;
use ZfComplemente\JQuery\Validate\Rule;

class RuleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Rule
     */
    private $class;
    private $diretory;

    public function setUp ()
    {
        $this->class = new Rule('teste');
        parent::setUp ();
    }

    public function testInArray ()
    {
        $method  = new Cpf();
        $method2 = new Phone();
        $class   = $this->class;
        $class->addMethod ($method);
        $class->addMethod ($method2);
        $arrayClass = $class->toArray ();
        $this->assertInternalType ('array', $arrayClass);
        $this->assertArrayHasKey ('teste', $arrayClass);
        $this->assertArrayHasKey ('cpf', $arrayClass['teste']);
        $this->assertArrayHasKey ('phone', $arrayClass['teste']);
    }
}
 