<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class PyroModuleMenusCreateLinksStream extends Migration
{


    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'      => 'links',
        'trashable' => true,
        'sortable'  => true,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'menu'   => [
            'required' => true,
        ],
        'type'   => [
            'required' => true,
        ],
        'entry'  => [
            'required' => true,
        ],
        'target' => [
            'required' => true,
        ],
        'class',
        'parent',
        'allowed_roles',
        'icon'
    ];


}
