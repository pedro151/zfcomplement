<?php

namespace ZfComplement\JQuery\View\Helper;

use Zend\Debug\Debug;
use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Json\Json;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;
use ZfComplement\JQuery\Config;
use ZfComplement\JQuery\Filter;
use ZfComplement\JQuery\JQueryPluginManager;
use ZfComplement\JQuery\Validate\Options;
use ZfComplement\JQuery\Validate\Rule\RuleInterface;

class Jquery extends AbstractHelper
{

    /**
     * @var ServiceLocatorInterface
     */
    protected $_sm;

    protected $_pluginmanager;

    /**
     * @param ServiceLocatorInterface $sm
     */
    public function __construct ( ServiceLocatorInterface $sm )
    {
        $this->_sm = $sm;
    }

    public function __invoke ()
    {
        if ( !isset( $this->_pluginmanager ) )
        {
            $config = $this->_sm->getServiceLocator ()
                                ->get ( 'config' );
            Config::has ( 'zf-complement', $config );
            $this->_pluginmanager = new JQueryPluginManager( $config[ 'zf-complement' ] );
            $this->_pluginmanager->setServiceLocator ( $this->_sm->getServiceLocator () );
        }

        return $this->_pluginmanager;
    }

}