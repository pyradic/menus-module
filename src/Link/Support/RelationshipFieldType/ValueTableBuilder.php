<?php namespace Pyro\MenusModule\Link\Support\RelationshipFieldType;

/**
 * Class ValueTableBuilder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class ValueTableBuilder extends \Anomaly\RelationshipFieldType\Table\ValueTableBuilder
{

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

}
