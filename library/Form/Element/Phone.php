<?php
/**
 *
 * @link      https://github.com/pedro151/zf2_151 for the canonical source repository
 */

namespace ZfComplemente\Form\Element;

use Zend\Form\Element;
use Zend\InputFilter\InputProviderInterface;
use Zend\Validator\GreaterThan as GreaterThanValidator;
use Zend\Validator\LessThan as LessThanValidator;
use Zend\Validator\Regex as RegexValidator;
use Zend\Validator\Step as StepValidator;

class Phone extends Element implements InputProviderInterface
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = array(
        'type' => 'phone',
    );

    /**
     * @var array
     */
    protected $validators=array();

    /**
     * Get validator
     *
     * @return \Zend\Validator\ValidatorInterface[]
     */
    protected function getValidators()
    {
        if ($this->validators) {
            return $this->validators;
        }

        // HTML5 always transmits values in the format "1000.01", without a
        // thousand separator. The prior use of the i18n Float validator
        // allowed the thousand separator, which resulted in wrong numbers
        // when casting to float.
        $validator = new RegexValidator('/^\+?\(\d{2,3}\)\d{3,4}\-\d{3,4}$/');
        $validator->setMessage('Please enter 11 or 12 digits only!',
            RegexValidator::NOT_MATCH);

        $this->validators[] = $validator;
        return $this->validators;
    }

    /**
     * Provide default input rules for this element
     *
     * Attaches a number validator, as well as a greater than and less than validators
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return array(
            'name' => $this->getName(),
            'required' => true,
            'filters' => array(
                array('name' => 'Zend\Filter\StringTrim')
            ),
            'validators' => $this->getValidators(),
        );
    }
}
