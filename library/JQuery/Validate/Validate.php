<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 14/01/15
 * Time: 18:27
 */

namespace ZfComplement\JQuery\Validate;


use Zend\Debug\Debug;
use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Json\Json;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfComplement\JQuery\Filter;
use ZfComplement\JQuery\Validate\Rule\RuleInterface;

class Validate extends AbstractValidate
{
    /**
     * @var array
     */
    protected $skipValidators = array (
        'Explode',
        'Upload'
    );

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
     * @var array
     */
    protected $forms = array ();

    /**
     * @return mixed
     */
    public function __invoke ()
    {
        parent::__invoke ();
        $this->initValidateFileJs();
    }

    /**
     * Executed before the ZF2 view helper renders the element
     *
     * @param string        $formAlias
     * @param FormInterface $form
     */
    public function getScript ()
    {
        $viewmanager = $this->getServiceLocator ()
                            ->get ( 'viewmanager' );

        $contentVariables = $viewmanager->getRenderer ()
                                        ->vars ()
                                        ->getArrayCopy ();

        $layoutVariables = $viewmanager->getViewModel ()
                                       ->getVariables ()
                                       ->getArrayCopy ();

        $arrVariables = array_merge ( $contentVariables, $layoutVariables );

        foreach ( $arrVariables as $value )
        {
            if ( $value instanceof FormInterface && !in_array ( $value, $this->forms ) )
            {
                $this->forms[ ] = $this->buildInlineJavascript ( $value );
            }
        }

        return sprintf (
            $this->getInitializeTrigger (),
            implode ( '', $this->forms )
        );
    }

    /**
     * @param FormInterface $form
     * @return string
     */
    protected function buildInlineJavascript ( FormInterface $form )
    {
        $elementRules = $this->getElementAndRules ( $form, $form->getInputFilter () );
        foreach ( $elementRules as $rules )
        {
            foreach ( $rules[ 'rules' ] as $rule )
            {
                if ( !is_null ( $rule ) )
                {
                    $this->addFile ( $rule );
                    $this->addRule ( $rules[ 'element' ], $rule );
                    $this->addMessages ( $rules[ 'element' ], $rule );
                }
            }
        }

        if ( empty( $this->_rules ) )
        {
            return;
        }

        return
            sprintf (
                '$(\'form[name="%s"]\').validate({"rules":%s,"messages":%s});',
                $form->getName (),
                Json::encode ( $this->_rules ),
                Json::encode ( $this->_messages )
            );
    }

    /**
     * Iterate through all the elements and retrieve their validators
     *
     * @param FieldsetInterface    $formOrFieldset
     * @param InputFilterInterface $inputFilter
     * @return array
     */
    private function getElementAndRules ( FieldsetInterface $formOrFieldset, InputFilterInterface $inputFilter )
    {
        $elements = array ();
        foreach ( $formOrFieldset->getElements () as $element )
        {
            $validators = Filter::getValidatorsForElement ( $inputFilter, $element );
            if ( count ( $validators ) > 0 && !empty( $element ) )
            {
                $rules = array ();
                foreach ( $validators as $validator )
                {
                    $rule = $this->getServiceLocator ()
                                 ->get ( 'Rule' )
                                 ->getRule ( $validator[ 'instance' ] );
                    if ( !is_null ( $rule ) )
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
            $elements = array_merge ( $elements,
                $this->getElementAndRules ( $fieldset, $inputFilter->get ( $key ) ) );
        }

        return $elements;
    }

    /**
     * @param ElementInterface $element
     * @param RuleInterface    $rule
     */
    public function addRule ( ElementInterface $element, RuleInterface $rule )
    {
        $elementName = Filter::getElementName ( $element );
        if ( !isset( $this->_rules[ $elementName ] ) )
        {
            $this->_rules[ $elementName ] = array ();
        }
        $this->_rules[ $elementName ] = array_merge ( $this->_rules[ $elementName ], $rule->getRules () );
    }

    /**
     * @param string $elementName
     * @param array  $messages
     */
    protected function addMessages ( ElementInterface $element, RuleInterface $rule )
    {
        $elementName = Filter::getElementName ( $element );
        if ( !isset( $this->_messages[ $elementName ] ) )
        {
            $this->_messages[ $elementName ] = array ();
        }
        $this->_messages[ $elementName ] = array_merge ( $this->_messages[ $elementName ], $rule->getMessages () );
    }

    /**
     * @param ElementInterface $element
     * @param RuleInterface    $rule
     */
    public function addFile ( RuleInterface $rule )
    {
        $clasName = Filter::getClassName ( $rule );
        if ( $rule->hasFile () )
        {
            $this->_file[ $clasName ] = $this->get ( 'validate-path' ) . $rule->getFile ();
        }
    }

    public function getFiles ()
    {
        return $this->_file;
    }

    public function initValidateFileJs ()
    {
        $this->_file[ 'validate' ] = $this->get ( 'validate-path' ) . $this->get ( 'file-validate' );

        if ( $this->isUseTwitterBootstrap () )
        {
            $this->_file[ 'bootstrap' ] = $this->get ( 'validate-path' ) . $this->get ( 'file-validate-bootstrap' );
        }

    }
}