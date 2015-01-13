<?php


namespace ZfComplemente\JQuery\Validate\Factory;

use ZfComplemente\JQuery\Validate\Rule\RuleCollection;
use ZfComplemente\JQuery\Validate\Rule\RulePluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RuleFactory
 * @package ZfComplemente\JQuery\Validate\Factory
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