<?php namespace Pyro\MenusModule;

use Anomaly\Streams\Platform\Addon\Extension\Command\UninstallExtension;
use Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Class MenusModule
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class MenusModule extends Module
{

    /**
     * The module icon.
     *
     * @var string
     */
    protected $icon = 'link';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'menus'  => [
            'buttons' => [
                'new_menu',
            ],
        ],
        'links'  => [
            'slug'        => 'links',
            'data-toggle' => 'modal',
            'data-target' => '#modal',
            'data-href'   => 'admin/menus/links/{request.route.parameters.menu}',
            'href'        => 'admin/menus/choose',

//            'buttons' => [
//                'new_link' => [
//                    'data-toggle' => 'modal',
//                    'data-target' => '#modal',
//                    'href'        => 'admin/menus/links/choose/{request.route.parameters.menu}',
//                ],
//            ],
        ],
        'fields' => [
            'buttons' => [
                'add_field' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'href'        => 'admin/menus/fields/choose',
                ],
            ],
        ],
    ];


    public function onUninstalling(MenusModule $module, ExtensionCollection $extensions, ExtensionRepositoryInterface $extensionRepository)
    {

        /** @var \Anomaly\Streams\Platform\Addon\Extension\Extension[]|ExtensionCollection $extensions */
        $extensions = $extensions->search('pyro.module.menus::link_type.*');
        foreach ($extensions as $extension) {
            $found = $extensionRepository->findBy('namespace', $extension->getNamespace());
            if ( ! $found) {
                $extensionRepository->create([
                    'namespace' => $extension->getNamespace(),
                    'installed' => true,
                    'enabled'   => true,
                ]);
            }
            $this->dispatchNow(new UninstallExtension($extension));
        }
    }
}
