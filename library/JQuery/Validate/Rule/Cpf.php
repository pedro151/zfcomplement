<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 12/11/14
 * Time: 10:09
 */

namespace ZfComplement\JQuery\Validate\Rule;


/**
 * Class Cpf
 * @package ZfComplement\JQuery\Validate\Rule
 */
class Cpf extends AbstractRule
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $_rule='cpf';
    /**
     * @var string
     */
    protected $_message = 'Enter a valid CPF.';
    /**
     * @var string
     */
    protected $_jsFile='jquery.cpf.js';
}