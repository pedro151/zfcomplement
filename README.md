zend2_151
=========
in module.config.php insert

    'view_helpers'    => array (
        'factories' => array (
            'Form' => function ( $sm )
            {
                return new ZfComplemente\JQuery\Validate\View\Helper\Form($sm);
            }
        )
    ),
    'service_manager' => array (
        'factories'          => array (
            'Rule' => 'ZfComplemente\JQuery\Validate\Service\RuleFactory',
        ),
    ),
