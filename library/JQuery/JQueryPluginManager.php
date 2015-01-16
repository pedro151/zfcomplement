<?php

namespace ZfComplement\JQuery;

use Zend\Debug\Debug;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;
use ZfComplement\JQuery\Validate\AbstractValidate;

class JQueryPluginManager extends AbstractPluginManager
{
    /**
     * @var Config
     */
    private $config;

    /**
     * Default set of rules
     *
     * @var array
     */
    protected $invokableClasses = array (
        'validate' => 'ZfComplement\JQuery\Validate\Validate',
    );

    private $helperManager;

    /**
     * Constructor
     *
     * After invoking parent constructor, add an initializer to inject the
     * attached renderer and translator, if any, to the currently requested helper.
     *
     * @param null $configuration
     */
    public function __construct ( $configuration = null )
    {
        parent::__construct ( null );

        Config::has ( 'jquery', $configuration );
        $this->config = new Config( $configuration[ 'jquery' ], $this->invokableClasses );

        $this->addInitializer ( array (
            $this,
            'injectConfig'
        ) );

    }

    /**
     * {@inheritDoc}
     */
    public function validatePlugin ( $plugin )
    {
        if ( $plugin instanceof JQueryPluginManagerAwareInterface )
        {
            // we're okay
            return;
        }

        throw new \InvalidArgumentException( sprintf (
            'Plugin of type %s is invalid; must implement %s\RuleInterface',
            ( is_object ( $plugin ) ? get_class ( $plugin ) : gettype ( $plugin ) ),
            __NAMESPACE__
        ) );
    }

    /**
     * Inject a helper instance with the registered translator
     *
     * @param  JQueryInterface
     * @return void
     */
    public function injectConfig ( JQueryPluginManagerAwareInterface $JQuery )
    {
        if ( $JQuery instanceof JQueryPluginManagerAwareInterface )
        {
            $JQuery->setOptions ( $this->config->getExtraOption ( Filter::getClassName ( $JQuery ) ) );
            $JQuery->setServiceLocator ( $this->getServiceLocator () );
            $this->initJQueryFiles ();
            $JQuery->__invoke ();
            $this->instanceFilesJS ( $JQuery->getFiles () );
            $this->initScriptJS ( $JQuery->getScript () );
        }
    }

    public function setOptions ( $options )
    {
        $this->config->setOptions ( $options );
    }

    public function getHelperManager ()
    {
        if ( !isset( $this->helperManager ) )
        {
            $this->helperManager = $this->getServiceLocator ()
                                        ->get ( 'viewmanager' )
                                        ->getHelperManager ();
        }

        return $this->helperManager;
    }

    public function instanceFilesJS ( $files )
    {
        foreach ( $files as $file )
        {
            $base = $this->getBase ();

            $this->getHelperManager ()
                 ->get ( 'headScript' )
                 ->appendFile ( $base . $file );
        }
    }

    public function getBase ()
    {
        return $this->getHelperManager ()
                    ->get ( 'basePath' )
                    ->__invoke ();
    }

    public function initScriptJS ( $script )
    {
        $this->getHelperManager ()
             ->get ( 'inlineScript' )
             ->appendScript ( $script );
    }

    public function initJQueryFiles ()
    {
        $this->config->setOptions ( array ( 'basePath' => $this->getBase () ) );

        if ( $this->config->is ( 'ui-enable' ) )
        {
            $this->getHelperManager ()
                 ->get ( 'headScript' )
                 ->prependFile ( $this->config->getJQueryUiLibraryPath () );
        }

        if ( $this->config->is ( 'enable' ) )
        {
            $this->getHelperManager ()
                 ->get ( 'headScript' )
                 ->prependFile ( $this->config->getJQueryLibraryPath () );
        }
    }


}