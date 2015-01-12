<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 12/11/14
 * Time: 10:09
 */

namespace ZfComplemente\JQuery\Validate\Rule;


class Cpf extends AbstractRule
{
    use RuleTrait;

    protected $_rule='cpf';
    protected $_message = 'Informe um CPF válido.';
    protected $_jsFile='jquery.cpf.js';
}