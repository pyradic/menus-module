<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class PyroExtensionModuleLinkTypeCreateModulesStream extends Migration
{
    protected $namespace = 'module_link_type';

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'         => 'modules',
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
        'link'         => [
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
        'url'         => 'anomaly.field_type.text',
        'link'        => [
            'type'   => 'anomaly.field_type.select',
            'config' => [
                'handler' => Pyro\ModuleLinkTypeExtension\Handler\AddonFieldOptionsHandler::class . '@handle',
            ],
        ],
        'description' => 'anomaly.field_type.textarea',
    ];

}
