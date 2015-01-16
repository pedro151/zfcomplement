<?php

namespace ZfComplement\JQuery\Validate;

use Zend\Debug\Debug;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;
use ZfComplement\JQuery\AbstractConfig;
use ZfComplement\JQuery\JQueryPluginManagerAwareInterface;

/**
 * Class AbstractValidate
 *
 * @package ZfComplement\JQuery\Validate
 */
abstract class AbstractValidate extends AbstractConfig implements JQueryPluginManagerAwareInterface
{

    protected $sm;

    private $factories = array ( 'Rule' => 'ZfComplement\JQuery\Validate\Service\RuleFactory' );

    /**
     * @var array
     */
    protected $defaultOptions = array (
        'factories'               => array (),
        'useTwitterBootstrap'     => true, // Flag indicating to use the twitter bootstrap
        'initializeTrigger'       => '$(document).ready(function(){%s});', //
        'validate-path'           => '/js/validate/',
        'file-validate'           => 'jquery.validate.js',
        'file-validate-bootstrap' => 'jquery.validate.bootstrap.js',
    );

    /**
     * Abstract constructor for all validators
     * A validator should accept following parameters:
     *  - nothing f.e. Validate ()
     *  - one or multiple scalar values f.e. Validator($first, $second, $third)
     *  - an array f.e. Validator(array($first => 'first', $second => 'second', $third => 'third'))
     *  - an instance of Traversable f.e. Validator($config_instance)
     *
     * @param array|Traversable $options
     */
    public function __construct ( $options = null )
    {
        // The abstract constructor allows no scalar values
        if ( $options instanceof Traversable )
        {
            $options = ArrayUtils::iteratorToArray ( $options );
        }

        if ( isset( $this->factories ) )
        {
            $this->defaultOptions[ 'factories' ] = $this->factories;
        }

        if ( is_array ( $options ) )
        {
            $this->setOptions ( $options );
        }
    }


    /**
     * @return bool
     */
    public function isUseTwitterBootstrap ()
    {
        return (bool) $this->defaultOptions[ 'useTwitterBootstrap' ];
    }

    /**
     * @param bool $useTwitterBootstrap
     */
    public function setUseTwitterBootstrap ( $useTwitterBootstrap )
    {
        $this->abstractOptions[ 'useTwitterBootstrap' ] = (bool) $useTwitterBootstrap;
    }

    /**
     * @return string
     */
    public function getInitializeTrigger ()
    {
        return $this->defaultOptions[ 'initializeTrigger' ];
    }


    /**
     * @param $initializeTrigger
     * @return $this
     */
    public function setInitializeTrigger ( $initializeTrigger )
    {
        $this->defaultOptions[ 'initializeTrigger' ] = $initializeTrigger;

        return $this;
    }

    public function setServiceLocator ( ServiceLocatorInterface $serviceLocatorInterface )
    {
        $this->sm = $serviceLocatorInterface;
    }

    public function getServiceLocator ()
    {
        return $this->sm;
    }

    public function hasFactories ()
    {
        return (bool) count ( $this->defaultOptions[ 'factories' ] );
    }

    protected function _initFactories ()
    {
        if ( $this->hasFactories () )
        {
            foreach ( $this->defaultOptions[ 'factories' ] as $alias => $factory )
            {
                $this->getServiceLocator ()
                     ->setFactory ( $alias, $factory );
            }
        }

    }

    public function __invoke ()
    {
        $this->_initFactories ();
    }


}
