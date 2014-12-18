<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 12/11/14
 * Time: 10:09
 */

namespace ZfComplemente\Javascript\JqueryValidate\Rule;


class Cpf extends AbstractRule
{
    use RuleTrait;

    protected $_role='cpf';
    protected $_message = '';
    protected $_jsFile='jquery.cpf.js';
}