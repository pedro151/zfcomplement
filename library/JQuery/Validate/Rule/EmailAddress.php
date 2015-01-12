<?php

namespace ZfComplemente\JQuery\Validate\Rule;

class EmailAddress extends AbstractRule
{
    use RuleTrait;

    protected $_rule = 'email';
    protected $_message = 'Email address is invalid';
}
