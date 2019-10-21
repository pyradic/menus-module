<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class PyroExtensionHeaderLinkTypeCreateHeadersStream extends Migration
{
    protected $namespace = 'header_link_type';

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'         => 'headers',
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
    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'title'       => 'anomaly.field_type.text',
    ];

}
