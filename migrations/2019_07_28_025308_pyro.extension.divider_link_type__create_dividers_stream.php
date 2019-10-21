<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class PyroExtensionDividerLinkTypeCreateDividersStream extends Migration
{
    protected $namespace = 'divider_link_type';

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'         => 'dividers',
        'title_column' => 'id',
        'translatable' => false,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
    ];

}
