<?php namespace Pyro\MenusModule\Link\Entry;

use Illuminate\Support\Arr;
use Pyro\MenusModule\Link\LinkModel;

/**
 * Class EntryFormSections
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class EntryFormSections
{

    /**
     * Handle the sections.
     *
     * @param EntryFormBuilder $builder
     */
    public function handle(EntryFormBuilder $builder, LinkModel $linkModel)
    {
        $type = $builder->getChildForm('type');
        $link = $builder->getChildForm('link');

        $optionFieldSlugs = [ 'target', 'class', 'allowed_roles' ];
        $fields           = array_diff($link->getFormFieldSlugs(), $optionFieldSlugs);

        $combine = $type->getFormFields()->count() + count($fields) < 6;

        $collections = [
            'type'    => [
                // Algemeen
                'title'  => 'pyro.module.menus::tab.general',
                'fields' => function () use ($type) {
                    return array_map(
                        function ($slug) {
                            return 'type_' . $slug;
                        },
                        $type->getFormFieldSlugs()
                    );
                },
            ],
            'fields'  => [
                // Overige
                'title'  => 'Overige',
                'fields' => Arr::prefix('link_', $fields),
            ],
            'options' => [
                // Opties
                'title'  => 'pyro.module.menus::tab.options',
                'fields' => Arr::prefix('link_', $optionFieldSlugs),
            ],
        ];

        /** @var  array $grouped = \Pyro\IdeHelper\Completion\FormBuilderCompletion::sections() */
        $grouped = [
            'link' => [
                'groups' => $combine ? [
                    'main'    => [
                        'type'   => 'container',
                        'groups' => [
                            'type'   => $collections[ 'type' ],
                            'fields' => $collections[ 'fields' ],
                        ],
                    ],
                    'options' => $collections[ 'options' ],
                ] : [
                    'type'    => $collections[ 'type' ],
                    'options' => $collections[ 'options' ],
                    'fields'  => $collections[ 'fields' ],
                ],
            ],
        ];

        /** @var  array $tabbed = \Pyro\IdeHelper\Completion\FormBuilderCompletion::sections() */
        $tabbed = [
            'title'  => [
                'title' => 'Opties',
            ],
            'link'   => [
                'stacked' => true,
                'tabs'    => [
                    'general' => [
                        'title'  => 'pyro.module.menus::tab.general',
                        'fields' => function () use ($type) {
                            return array_map(
                                function ($slug) {
                                    return 'type_' . $slug;
                                },
                                $type->getFormFieldSlugs()
                            );
                        },
                    ],
                    'options' => [
                        'title'  => 'pyro.module.menus::tab.options',
                        'fields' => Arr::prefix('link_', $optionFieldSlugs),
                    ],

                ],
            ],
            'fields' => [
                'title'  => 'Overige',
                'fields' => Arr::prefix('link_', $fields),
            ],
        ];

        $builder->setSections($grouped);
//        $builder->setSections($tabbed);
    }
}
