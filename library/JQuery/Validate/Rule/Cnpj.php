<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 12/11/14
 * Time: 10:09
 */

namespace ZfComplement\JQuery\Validate\Rule;


/**
 * Class Cnpj
 * @package ZfComplement\JQuery\Validate\Rule
 */
class Cnpj extends AbstractRule
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $_rule='cnpj';
    /**
     * @var string
     */
    protected $_message = 'Enter a valid CNPJ.';
    /**
     * @var string
     */
    protected $_jsFile='jquery.cnpj.js';
}