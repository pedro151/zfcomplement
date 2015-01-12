<?php
/**
 * RendererFactory
 *
 * @category  StrokerForm\Factory\Renderer\Validate
 * @package   StrokerForm\Factory\Renderer\Validate
 * @copyright 2013 ACSI Holding bv (http://www.acsi.eu)
 * @version   SVN: $Id$
 */

namespace ZfComplemente\JQuery\Validate\Factory;

use ZfComplemente\JQuery\Validate\Rule\RuleCollection;
use ZfComplemente\JQuery\Validate\Rule\RulePluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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