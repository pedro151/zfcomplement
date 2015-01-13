<?php

namespace ZfComplemente\JQuery\Validate\Rule;

use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\Validator\ValidatorInterface;

interface RuleInterface extends TranslatorAwareInterface
{

    /**
     * Get the validation
     *
     * @param ValidatorInterface $validator
     * @return mixed
     */
    public function setValidator(ValidatorInterface $validator);

    /**
     * Get the validation rules
     *
     * @return array
     */
    public function getRules();

    /**
     * Get the validation message
     *
     * @return string
     */
    public function getMessages();

    /**
     * Get the file JQuery Validator
     *
     * @return string
     */
    public function getFile();

    /**
     * @return bool
     */
    public function hasFile();
}
