<?php


namespace ZfComplement\JQuery\Validate\Service;

use ZfComplement\JQuery\Validate\Rule\RuleCollection;
use ZfComplement\JQuery\Validate\Rule\RulePluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RuleFactory
 * @package ZfComplement\JQuery\Validate\Service
 */
class RuleFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $collection = new RuleCollection();
        $pluginManager = new RulePluginManager();

        $pluginManager->setServiceLocator($serviceLocator);
        $collection->setPluginManager($pluginManager);
        return $collection;
    }
}