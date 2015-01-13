<?php

namespace ZfComplement\JQuery\Validate\Rule;

use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

class RulePluginManager extends AbstractPluginManager
{
    /**
     * Default set of rules
     *
     * @var array
     */
    protected $invokableClasses = array (
        'cpf'          => 'ZfComplement\JQuery\Validate\Rule\Cpf',
        'phone'        => 'ZfComplement\JQuery\Validate\Rule\Phone',
        'emailaddress' => 'ZfComplement\JQuery\Validate\Rule\EmailAddress'
    );

    /**
     * Constructor
     *
     * After invoking parent constructor, add an initializer to inject the
     * attached renderer and translator, if any, to the currently requested helper.
     *
     * @param null|ConfigInterface $configuration
     */
    public function __construct ( ConfigInterface $configuration = null )
    {
        parent::__construct ($configuration);

        $this->addInitializer (array (
            $this,
            'injectTranslator'
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function validatePlugin ( $plugin )
    {
        if ( $plugin instanceof RuleInterface )
        {
            // we're okay
            return;
        }

        throw new \InvalidArgumentException(sprintf (
            'Plugin of type %s is invalid; must implement %s\RuleInterface',
            ( is_object ($plugin) ? get_class ($plugin) : gettype ($plugin) ),
            __NAMESPACE__
        ));
    }

    /**
     * Inject a helper instance with the registered translator
     *
     * @param  RuleInterface $rule
     * @return void
     */
    public function injectTranslator ( $rule )
    {
        if ( $rule instanceof TranslatorAwareInterface )
        {
            $locator = $this->getServiceLocator ();
            if ( $locator && $locator->has ('MvcTranslator') )
            {
                $rule->setTranslator ($locator->get ('MvcTranslator'));
            }
            elseif ( $locator && $locator->has ('translator') )
            {
                $rule->setTranslator ($locator->get ('translator'));
            }
        }
    }

}