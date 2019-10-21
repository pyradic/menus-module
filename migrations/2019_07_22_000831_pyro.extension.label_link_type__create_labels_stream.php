<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class PyroExtensionLabelLinkTypeCreateLabelsStream extends Migration
{

    protected $namespace = 'label_link_type';

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'         => 'labels',
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
        'subtitle'    => [
            'translatable' => true,
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
        'subtitle'    => 'anomaly.field_type.text',
        'description' => 'anomaly.field_type.textarea',
    ];
}
