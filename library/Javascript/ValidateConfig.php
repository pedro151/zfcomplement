<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZfComplemente\Javascript;

use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Service manager configuration for form view helpers
 */
class ValidateConfig implements ConfigInterface
{
    /**
     * Pre-aliased view helpers
     *
     * @var array
     */
    protected $invokables = array(
        'cpf'                    => 'ZfComplemente\Javascript\Validate\Cpf',
    );

    /**
     * Configure the provided service manager instance with the configuration
     * in this class.
     *
     * Adds the invokables defined in this class to the SM managing helpers.
     *
     * @param  ServiceManager $serviceManager
     * @return void
     */
    public function configureServiceManager(ServiceManager $serviceManager)
    {
        $path = new Path($serviceManager);
        foreach ($this->invokables as $name => $service) {
             $serviceManager->setInvokableClass($name, $service);
        }
    }
}
