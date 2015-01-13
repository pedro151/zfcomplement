<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 19/12/14
 * Time: 19:02
 */

namespace ZfComplement\JQuery;


use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;
use Zend\InputFilter\InputFilterInterface;

class Filter {
    /**
     * Get the classname of the zend
     *
     * @param  mixed $object
     * @return mixed
     */
    static function getClassName($object = null)
    {
        if(empty($object))
        {
            return;
        }
        $namespaces = explode('\\', get_class($object));
        return end($namespaces);
    }



    /**
     * Get all validators for a given element
     *
     * @param InputFilterInterface $inputFilter
     * @param ElementInterface     $element
     * @return mixed
     */
    static function getValidatorsForElement(InputFilterInterface $inputFilter, ElementInterface $element)
    {

        // Check if we are dealing with a fieldset element
        if (preg_match('/^.*\[(.*)\]$/', $element->getName(), $matches)) {
            $elementName = $matches[1];
        } else {
            $elementName = $element->getName();
        }

        if (!$inputFilter->has($elementName)) {
            return;
        }
        $input = $inputFilter->get($elementName);

        // Make sure NotEmpty validator is added when input is required
       // $input->isValid();

        $chain = $input->getValidatorChain();
        return $chain->getValidators();
    }

    /**
     * Get the name of the form element
     *
     * @param  ElementInterface $element
     * @return string
     */
    static function getElementName(ElementInterface $element)
    {
        $elementName = $element->getName();
        if ($element instanceof MultiCheckbox && !$element instanceof Radio) {
            $elementName .= '[]';
        }

        return $elementName;
    }

} 