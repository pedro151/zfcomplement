<?php

namespace ZfComplement\JQuery\Validate\Rule;

use Zend\Validator\ValidatorInterface;
use Zend\I18n\Translator\TranslatorAwareInterface;

/**
 * Class RuleTrait
 * @package ZfComplement\JQuery\Validate\Rule
 */
trait RuleTrait
{

    /**
     * Get the validation object
     *
     * @param ValidatorInterface $validator
     */
    public function setValidator ( ValidatorInterface $validator )
    {
        $this->_validator = $validator;
    }

    /**
     * Get the validation rules
     *
     * @return string
     */
    public function getRules ()
    {
        if ( !empty( $this->_rule ) )
        {
            return array ($this->_rule => true);
        }
    }

    /**
     *  Get the validation message
     *
     * @return string
     */
    public function getMessages ()
    {
        if ( !empty( $this->_message ) )
        {
            return array ($this->_rule => $this->translateMessage ($this->_message));
        }
    }

    /**
     * pega o nome do arquivo
     *
     * @return string
     */
    public function getFile ()
    {
        return $this->_jsFile;
    }


    /**
     * @return bool
     */
    public function hasFile ()
    {
        return !empty( $this->_jsFile ) ? true : false;
    }
}