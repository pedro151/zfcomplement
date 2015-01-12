<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 18/12/14
 * Time: 19:14
 */

namespace ZfComplementeTest\JQuery\Validate\Rule;

use ZfComplemente\JQuery\Validate\Rule\EmailAddress;

class EmailAddressTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var EmailAddress
     */
    private  $_class;
    public function setUp ()
    {
        $this->_class = new EmailAddress();
        parent::setUp ();
    }

    public function testGetRule()
    {
        $this->assertArrayHasKey('email',$this->_class->getRules());
    }

    public function testGetMessage()
    {
        $this->assertArrayHasKey('email',$this->_class->getMessages());
    }

    public function testGetJsFile()
    {
        $this->assertNull($this->_class->getFile());
    }

}
 