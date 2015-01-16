<?php


namespace ZfComplement\JQuery\Validate\Service;

use ZfComplement\JQuery\JQueryPluginManagerAwareInterface;
use ZfComplement\JQuery\Validate\Rule\RulePlugin;
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
        $plugin = new RulePlugin();
        $pluginManager = new RulePluginManager();

        $pluginManager->setServiceLocator($serviceLocator);
        $plugin->setPluginManager($pluginManager);
        return $plugin;
    }
}