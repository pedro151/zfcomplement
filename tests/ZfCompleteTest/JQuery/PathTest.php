<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 12/11/14
 * Time: 17:49
 */

namespace ZfComplementeTest\JQuery\Validate;


use Zend\Debug\Debug;
use ZfComplemente\JQuery\Path;
use ZfComplementeTest\Bootstrap;

class PathTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Path
     */
    private $class;
    private $diretory;

    public function setUp ()
    {
        $serviceManager = Bootstrap::getServiceManager();

        $this->class = new Path($serviceManager);
        $this->diretory = 'validate';
        parent::setUp ();
    }

    public function testHasPath ()
    {

        $this->assertFalse($this->class->hasPath(), 'erro - existe Path'); //nao deve existir path
        $this->class->setDiretory($this->diretory);
        $this->assertTrue($this->class->hasPath(), 'erro - não existe Path');// deve existir path
    }

    public function testHasDiretory()
    {
        $this->assertTrue($this->class->hasDiretory($this->diretory));
        $this->assertFalse($this->class->hasDiretory('notfound'));
    }
}
 