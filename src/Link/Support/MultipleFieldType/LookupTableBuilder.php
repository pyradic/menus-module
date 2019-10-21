<?php namespace Pyro\MenusModule\Link\Support\MultipleFieldType;

/**
 * Class LookupTableBuilder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class LookupTableBuilder extends \Anomaly\MultipleFieldType\Table\LookupTableBuilder
{

    /**
     *
     * @var array
     */
    protected $filters = [
        'menu',
        'target',
    ];

    /**
     * The table columns.
     *
     * @var array
     */
    protected $columns = [
        'link' => [
            'heading'     => 'pyro.module.menus::label.link',
            'sort_column' => 'title',
            'wrapper'     => '
                    <strong>{value.title}</strong>
                    <br>
                    <small class="text-muted">{value.url}</small>',
            'value'       => [
                'url'   => 'entry.url',
                'title' => 'entry.title',
            ],
        ],
        'entry.type.title',
        'menu',
    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [
        'order_by' => [
            'parent_id'  => 'ASC',
            'sort_order' => 'ASC',
        ],
        'sortable' => false,
    ];

}
