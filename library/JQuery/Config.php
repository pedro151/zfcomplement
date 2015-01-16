<?php

namespace ZfComplement\JQuery;


use Zend\Debug\Debug;

class Config extends AbstractConfig
{

    protected $defaultOptions = array (
        'enable'        => true,
        'ui-enable'     => false,
        'version'       => "2.1.3",    //Current default supported jQuery library version with JQuery
        'ui-version'    => "1.11.2",    //Currently supported jQuery UI library version with JQuery
        'local-path'    => null,
        'ui-local-path' => null,
        'load-ssl-path' => true,
        'basePath'      => '',

    );

    protected $extends = array ();


    /**
     * @see   http://code.google.com/apis/ajaxlibs/documentation/index.html#validate
     * @const string Base path to CDN
     */
    const CDN_BASE_GOOGLE = 'http://ajax.googleapis.com/ajax/libs/';

    /**
     * @see   http://code.google.com/apis/ajaxlibs/documentation/index.html#validate
     * @const string Base path to CDN
     */
    const CDN_BASE_GOOGLE_SSL = 'https://ajax.googleapis.com/ajax/libs/';

    /**
     * @const string
     */
    const CDN_SUBFOLDER_JQUERY = 'validate/';

    /**
     * @const string
     */
    const CDN_SUBFOLDER_JQUERYUI = 'jqueryui/';

    /**
     * Always uses compressed version, because this is assumed to be the use case
     * in production enviroment. An uncompressed version has to included manually.
     *
     * @see   http://code.google.com/apis/ajaxlibs/documentation/index.html#validate
     * @const string File path after base and version
     */
    const CDN_JQUERY_PATH_GOOGLE = '/validate.min.js';


    /**
     * @param array $options
     * @param array $extends
     */
    public function __construct ( $options = array (), $extends = array () )
    {
        // The abstract constructor allows no scalar values
        if ( $options instanceof Traversable )
        {
            $options = ArrayUtils::iteratorToArray ( $options );
        }

        if ( !empty( $extends ) )
        {
            if ( $extends instanceof Traversable )
            {
                $extends = ArrayUtils::iteratorToArray ( $extends );
            }

            $this->extends = array_intersect_key ( $options, $extends );
        }

        if ( is_array ( $options ) )
        {
            $this->setOptions ( $options );
        }
    }

    public function getExtraOption ( $extraoption )
    {
        return $this->extends[ $extraoption ];
    }

    /**
     * Is the jQuery Ui loaded from local scope?
     *
     * @return boolean
     */
    protected function useUiLocal ()
    {
        return ( null === $this->defaultOptions[ 'ui-local-path' ] ) ? false : true;
    }

    /**
     * Are we using a local path?
     *
     * @return boolean
     */
    protected function useLocalPath ()
    {
        return ( null === $this->defaultOptions[ 'local-path' ] ) ? false : true;
    }

    /**
     * @return string
     */
    protected function _getJQueryLibraryBaseCdnUri ()
    {
        if ( $this->is ( 'load-ssl-path' ) )
        {
            $baseUri = self::CDN_BASE_GOOGLE_SSL;
        }
        else
        {
            $baseUri = self::CDN_BASE_GOOGLE;
        }

        return $baseUri;
    }

    /**
     * @return string
     */
    protected function _getJQueryUiLibraryBaseCdnUri ()
    {
        if ( $this->is ( 'load-ssl-path' ) )
        {
            $baseUri = self::CDN_BASEUI_GOOGLE_SSL;
        }
        else
        {
            $baseUri = self::CDN_BASEUI_GOOGLE;
        }

        return $baseUri;
    }


    /**
     * Internal function that constructs the include path of the jQuery library.
     *
     * @return string
     */
    public function getJQueryLibraryPath ()
    {
        if ( $this->useLocalPath () )
        {
            $source = $this->defaultOptions[ 'basePath' ] . $this->get ( 'local-path' );
        }
        else
        {
            $baseUri = $this->_getJQueryLibraryBaseCdnUri ();
            $source  = $baseUri .
                       self::CDN_SUBFOLDER_JQUERY .
                       $this->get ( 'version' ) .
                       self::CDN_JQUERY_PATH_GOOGLE;
        }

        return $source;
    }


    /**
     * @return string
     */
    public function getJQueryUiLibraryPath ()
    {
        if ( $this->useUiLocal () )
        {
            $uiPath = $this->defaultOptions[ 'basePath' ] . $this->get ( 'ui-local-path' );
        }
        else
        {
            $baseUri = $this->_getJQueryLibraryBaseCdnUri ();
            $uiPath  = $baseUri .
                       self::CDN_SUBFOLDER_JQUERYUI .
                       $this->get ( 'ui-version' ) .
                       "/validate-ui.min.js";
        }

        return $uiPath;
    }

}