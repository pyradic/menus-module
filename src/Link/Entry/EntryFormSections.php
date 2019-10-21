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

        $optionFieldSlugs = ['target','class','allowed_roles'];
        $fields = array_diff($link->getFormFieldSlugs(), $optionFieldSlugs);

        $builder->setSections(
            [
                'link' => [

                    'stacked'           => true,
                    'tabs' => [
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
                            'fields' => Arr::prefix('link_', $optionFieldSlugs)
                        ],
                    ],
                ],
                'fields' => [
                    'fields' =>Arr::prefix('link_', $fields)
                ]
            ]
        );
    }
}
