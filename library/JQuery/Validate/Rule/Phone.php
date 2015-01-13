<?php
/**
 * Created by PhpStorm.
 * User: perdro
 * Date: 12/11/14
 * Time: 10:09
 */

namespace ZfComplemente\JQuery\Validate\Rule;


class Phone extends AbstractRule
{
    use RuleTrait;

    protected $_role='phone';
    protected $_message = '';
    protected $_jsFile='jquery.cpf.js';
}