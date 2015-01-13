<?php

namespace ZfComplement\JQuery\Validate\Rule;

use Zend\Validator\ValidatorInterface;
use ZfComplement\JQuery\Filter;

class RuleCollection
{
    /**
     * @var RulePluginManager
     */
    protected $rulePluginManager;

    /**
     * @param RulePluginManager $rulePluginManager
     */
    public function setPluginManager ( RulePluginManager $rulePluginManager )
    {
        $this->rulePluginManager = $rulePluginManager;
    }

    /**
     * @return RulePluginManager
     */
    public function getPluginManager ()
    {
        return $this->rulePluginManager;
    }


    /**
     * @param  \Zend\Validator\ValidatorInterface $validator
     * @return null|AbstractRule
     */
    public function getRule ( ValidatorInterface $validator = null )
    {
        $validatorName = strtolower (Filter::getClassName ($validator));

        if ( $this->getPluginManager ()
                  ->has ($validatorName)
        )
        {
            $rule = $this->getPluginManager ()
                         ->get ($validatorName);
            $rule->setValidator ($validator);
            return $rule;
        }
        return null;
    }

}