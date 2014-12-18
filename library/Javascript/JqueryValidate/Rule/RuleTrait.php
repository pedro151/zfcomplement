<?php

namespace ZfComplemente\Javascript\JqueryValidate\Rule;

use Zend\Validator\ValidatorInterface;
use Zend\I18n\Translator\TranslatorAwareInterface;

trait RuleTrait
{
    protected $_rule;
    protected $_message;
    protected $_jsFile;


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
    public function getRoles ()
    {
        if ( !empty( $this->_role ) )
        {

        }
        return array ($this->_role => true);
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
            return array ($this->_role => $this->translateMessage ($this->_message));
        }
    }

    /**
     * pega o nome do arquivo
     *
     * @return string
     */
    public function getFile ()
    {
        if ( !empty( $this->_jsFile ) )
        {
            return $this->_jsFile;
        }
    }
}