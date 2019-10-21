<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\UsersModule\Role\RoleModel;
use Pyro\MenusModule\Link\LinkModel;
use Pyro\MenusModule\Menu\MenuModel;

class PyroModuleMenusCreateMenusFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'name'          => 'anomaly.field_type.text',
        'enabled'       => 'anomaly.field_type.boolean',
        'class'         => 'anomaly.field_type.text',
        'description'   => 'anomaly.field_type.textarea',
        'entry'         => 'anomaly.field_type.polymorphic',
        'slug'          => [
            'type'   => 'anomaly.field_type.slug',
            'config' => [
                'slugify' => 'name',
            ],
        ],
        'menu'          => [
            'type'   => 'anomaly.field_type.relationship',
            'config' => [
                'related' => MenuModel::class,
            ],
        ],
        'parent'        => [
            'type'   => 'anomaly.field_type.relationship',
            'config' => [
                'related' => LinkModel::class,
            ],
        ],
        'allowed_roles' => [
            'type'   => 'anomaly.field_type.multiple',
            'config' => [
                'related' => RoleModel::class,
            ],
        ],
        'type'          => [
            'type'   => 'anomaly.field_type.addon',
            'config' => [
                'type'   => 'extension',
                'search' => 'pyro.module.menus::link_type.*',
            ],
        ],
        'target'        => [
            'type'   => 'anomaly.field_type.select',
            'config' => [
                'default_value' => '_self',
                'options'       => [
                    '_self'  => 'pyro.module.menus::field.target.option.self',
                    '_blank' => 'pyro.module.menus::field.target.option.blank',
                ],
            ],
        ],
        'tooltip' => [
            'type' => 'anomaly.field_type.text',
            'locked' => 0
        ]
    ];

}
