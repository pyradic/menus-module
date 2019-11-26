<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class PyroExtensionCpActionLinkTypeCreateCpActionStream extends Migration
{
    protected $namespace = 'cp_action_link_type';

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'         => 'cp_action',
        'title_column' => 'title',
        'translatable' => true,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'title'       => [
            'required'     => true,
            'translatable' => true,
        ],
        'key'        => [
            'required' => true,
        ],
        'description' => [
            'translatable' => true,
        ],
    ];

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'title'       => 'anomaly.field_type.text',
        'key'         =>[
            'type'   => 'anomaly.field_type.select',
            'config' => [
                'handler' => Pyro\CpActionLinkTypeExtension\Handler\AddonFieldOptionsHandler::class . '@handle',
            ],
            ],
        'description' => 'anomaly.field_type.textarea',
    ];

}
