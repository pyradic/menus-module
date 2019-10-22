<?php namespace Pyro\MenusModule;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Support\Decorator;
use Pyro\MenusModule\Link\Command\GetLinks;
use Pyro\MenusModule\Link\Command\RenderMenus;
use Pyro\MenusModule\Menu\Command\BuildMenuNode;
use Pyro\MenusModule\Menu\Contract\MenuRepositoryInterface;
use Pyro\MenusModule\Menu\MenuModel;

/**
 * Class MenusModulePlugin
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class MenusModulePlugin extends Plugin
{

    /**
     * Get the functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'menu_tree',
                function ($menu = null) {
                    $menu = resolve(MenuRepositoryInterface::class)->findBySlug($menu);
                    $tree = $menu->toTree();
                    $this->dispatchNow(new BuildMenuNode($tree));
                    return $tree;
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new \Twig_SimpleFunction(
                'menu',
                function ($menu = null) {
                    $menu =  (new MenusModuleCriteria(
                        'render',
                        function (Collection $options) use ($menu) {
                            return $this->dispatch(new RenderMenus($options->put('menu', $menu)));
                        }
                    ))
                        ->setModel(MenuModel::class)
                        ->setCachePrefix('pyro.module.menus::menu.render:' . $menu);

                    return $menu;
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new \Twig_SimpleFunction(
                'links',
                function ($menu = null) {
                    return (new MenusModuleCriteria(
                        'get',
                        function (Collection $options) use ($menu) {
                            return (new Decorator())->decorate(
                                $this->dispatch(new GetLinks($options->put('menu', $menu)))
                            );
                        }
                    ))
                        ->setModel(MenuModel::class)
                        ->setCachePrefix('pyro.module.menus::menu.links');
                }
            ),
        ];
    }
}
