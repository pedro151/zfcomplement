<?php

namespace ZfComplement\JQuery\Validate\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Json\Json;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfComplement\JQuery\Filter;
use ZfComplement\JQuery\Validate\Options;
use ZfComplement\JQuery\Validate\Rule\RuleInterface;

class Form extends \Zend\Form\View\Helper\Form
{

    /**
     * @var array
     */
    protected $skipValidators = array (
        'Explode',
        'Upload'
    );

    /**
     * @var ServiceLocatorInterface
     */
    protected $_sm;

    /**
     * @var array
     */
    protected $_rules = array ();

    /**
     * @var array
     */
    protected $_messages = array ();

    /**
     * @var
     */
    protected $_file = array ();

    /**
     * @param ServiceLocatorInterface $sm
     */
    public function __construct ( ServiceLocatorInterface $sm )
    {
        $this->_sm = $sm;
    }

    /**
     * Render a form from the provided $form,
     *
     * @param  FormInterface $form
     * @return string
     */
    public function openTag ( FormInterface $form )
    {
        $this->preRenderForm ($form);

        return parent::openTag ($form);
    }


    /**
     * Executed before the ZF2 view helper renders the element
     *
     * @param string $formAlias
     * @param FormInterface $form
     */
    public function preRenderForm ( FormInterface $form = null )
    {
        /** @var $options Options */
//        $options = $this->getOptions();

        $inlineScript = $this->getView ()
                             ->plugin ('inlineScript');
        $inlineScript->appendScript ($this->buildInlineJavascript ($form));
//
//        if ($options->getIncludeAssets()) {
//            $assetBaseUri = $this->getHttpRouter()->assemble(array(), array('name' => 'strokerform-asset'));
//            $inlineScript->appendFile($assetBaseUri . '/jquery_validate/js/jquery.validate.js');
//            $inlineScript->appendFile($assetBaseUri . '/jquery_validate/js/custom_rules.js');
//            if ($options->isUseTwitterBootstrap() === true) {
//                $inlineScript->appendFile($assetBaseUri . '/jquery_validate/js/jquery.validate.bootstrap.js');
//            }
//        }
    }

    /**
     * @param FormInterface $form
     * @return string
     */
    protected function buildInlineJavascript ( FormInterface $form )
    {
        $validateOptions = array ();
        $elementRules    = $this->getElementAndRules ($form, $form->getInputFilter ());

        foreach ( $elementRules as $rules )
        {
            foreach ( $rules[ 'rules' ] as $rule )
            {
                if ( !is_null ($rule) )
                {
                    $this->addFile ($rule);
                    $this->addRule ($rules[ 'element' ], $rule);
                    $this->addMessages ($rules[ 'element' ], $rule);
                }
            }
        }

        return sprintf (
        // $options->getInitializeTrigger (),
            sprintf (
                '$(\'form[name="%s"]\').validate({"rules":%s,"messages":%s});',
                $form->getName (),
                json::encode ($this->_rules),
                json::encode ($this->_messages)
            )
        );
    }

    /**
     * Iterate through all the elements and retrieve their validators
     *
     * @param FieldsetInterface $formOrFieldset
     * @param InputFilterInterface $inputFilter
     * @return array
     */
    private function getElementAndRules ( FieldsetInterface $formOrFieldset, InputFilterInterface $inputFilter )
    {
        $elements = array ();

        foreach ( $formOrFieldset->getElements () as $element )
        {
            $validators = Filter::getValidatorsForElement ($inputFilter, $element);
            if ( count ($validators) > 0 && !empty( $element ) )
            {
                $rules = array ();
                foreach ( $validators as $validator )
                {
                    $rule = $this->_sm->getServiceLocator ()
                                      ->get ('Rule')
                                      ->getRule ($validator[ 'instance' ]);
                    if ( !is_null ($rule) )
                    {
                        $rules[ ] = $rule;
                    }
                }

                $elements[ ] = array (
                    'element' => $element,
                    'rules'   => $rules
                );
            }
        }

        foreach ( $formOrFieldset->getFieldsets () as $key => $fieldset )
        {
            $elements = array_merge ($elements,
                $this->getElementAndRules ($fieldset, $inputFilter->get ($key)));
        }

        return $elements;
    }

    /**
     * @param ElementInterface $element
     * @param RuleInterface $rule
     */
    public function addRule ( ElementInterface $element, RuleInterface $rule )
    {
        $elementName = Filter::getElementName ($element);

        if ( !isset( $this->_rules[ $elementName ] ) )
        {
            $this->_rules[ $elementName ] = array ();
        }

        $this->_rules[ $elementName ] = array_merge ($this->_rules[ $elementName ], $rule->getRules ());
    }

    /**
     * @param string $elementName
     * @param array $messages
     */
    protected function addMessages ( ElementInterface $element, RuleInterface $rule )
    {
        $elementName = Filter::getElementName ($element);

        if ( !isset( $this->_messages[ $elementName ] ) )
        {
            $this->_messages[ $elementName ] = array ();
        }
        $this->_messages[ $elementName ] = array_merge ($this->_messages[ $elementName ], $rule->getMessages ());
    }

    /**
     * @param ElementInterface $element
     * @param RuleInterface $rule
     */
    public function addFile ( RuleInterface $rule )
    {
        $clasName = Filter::getClassName ($rule);
        if ( $rule->hasFile () )
        {
            $this->_file[ $clasName ] = $rule->getFile ();
        }
    }

}