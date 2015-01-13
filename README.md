Zf2 ZfComplement
=========
in module.config.php insert

    'view_helpers'    => array (
        'factories' => array (
            'Form' => function ( $sm )
            {
                return new ZfComplement\JQuery\Validate\View\Helper\Form($sm);
            }
        )
    ),
    'service_manager' => array (
        'factories'          => array (
            'Rule' => 'ZfComplement\JQuery\Validate\Service\RuleFactory',
        ),
    ),
