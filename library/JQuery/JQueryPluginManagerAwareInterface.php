<?php
namespace ZfComplement\JQuery;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

/**
 * Interface JQueryInterface
 *
 * @package ZfComplement\JQuery
 */
interface JQueryPluginManagerAwareInterface
{
    /**
     * @param array $options
     * @return mixed
     */
    public function setOptions ( $options );

    /**
     * @param ServiceLocatorInterface $serviceLocatorInterface
     * @return mixed
     */
    public function setServiceLocator ( ServiceLocatorInterface $serviceLocatorInterface );

    /**
     * @return mixed
     */
    public function getServiceLocator ();

    /**
     * @return mixed
     */
    public function __invoke ();

    public function getScript();

    public function getFiles();
}