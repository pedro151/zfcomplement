<?php

namespace StrokerForm\Renderer\JqueryValidate\Rule;

class EmailAddress extends AbstractRule
{
    protected $_rule = 'email';
    protected $_message = 'Email address is invalid';
}
