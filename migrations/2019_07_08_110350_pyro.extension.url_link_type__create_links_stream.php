<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class AnomalyExtensionUrlLinkTypeCreateLinksStream
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class PyroExtensionUrlLinkTypeCreateLinksStream extends Migration
{
    protected $namespace = 'url_link_type';

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'         => 'urls',
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
        'url'         => [
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
        'description' => 'anomaly.field_type.textarea',
    ];

}
