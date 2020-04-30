<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class PyroExtensionDisabledLinkTypeCreateDisabledStream extends Migration
{
    protected $namespace = 'disabled_link_type';

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'         => 'disabled',
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
    ];

    protected $fields = [
        'title'       => 'anomaly.field_type.text',
    ];
}
