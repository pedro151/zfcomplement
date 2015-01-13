<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 12/11/14
 * Time: 17:34
 */

namespace ZfComplement\JQuery;


use Zend\ServiceManager\ServiceLocatorInterface;

class Path
{
    private $_path;
    private $_diretory;
    private $_base;
    private $_jsbase;

    public function __construct ( ServiceLocatorInterface $serviceLocator )
    {
        $this->_setBasePath ($serviceLocator);
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    private function _setBasePath ( ServiceLocatorInterface $serviceLocator )
    {
        $config = $serviceLocator->get ('config');
        if ( isset( $config[ 'view_manager' ] ) && isset( $config[ 'view_manager' ][ 'base_path' ] ) )
        {
            $this->_base = $config[ 'view_manager' ][ 'base_path' ];
        }
        elseif ( method_exists ($serviceLocator->get ('Request'), 'getBasePath') )
        {
            $this->_base = $serviceLocator->get ('Request')
                                          ->getBasePath ();
        }

        if ( isset( $config[ 'js_path' ] ) )
        {
            $this->_jsbase = $config[ 'js_path' ];
        }
    }

    /**
     * @return string
     */
    public function getPath ()
    {
        if ( $this->hasDiretory ($this->_diretory) )
        {
            return "/" . $this->_base . $this->_jsbase . $this->_diretory . "/";
        }
    }

    /**
     * @return bool
     */
    public function hasPath ()
    {
        return $this->hasDiretory ($this->_diretory);
    }

    /**
     * @param $diretory
     */
    public function setDiretory ( $diretory )
    {
        if ( $this->hasDiretory ($diretory) )
        {
            $this->_diretory = $diretory;
        }
    }

    /**
     * @return string
     */
    public function getDiretory ()
    {
        return $this->_getPublicPath () . $this->_diretory;
    }

    /**
     * @param $diretory
     * @return bool
     */
    public function hasDiretory ( $diretory )
    {
        if ( empty( $diretory ) )
        {
            return false;
        }

        return is_dir ($this->_getPublicPath () . $diretory);
    }

    /**
     * @return string
     */
    private function _getPublicPath ()
    {
        return getcwd () . "/public" . $this->_jsbase . "/";
    }

} 