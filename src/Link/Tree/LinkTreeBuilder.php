<?php namespace Pyro\MenusModule\Link\Tree;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Database\Eloquent\Builder;
use Pyro\MenusModule\Menu\Contract\MenuInterface;

/**
 * Class LinkTreeBuilder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class LinkTreeBuilder extends TreeBuilder
{

    /**
     * The menu instance.
     *
     * @var null|MenuInterface
     */
    protected $menu = null;

    /**
     * The tree buttons.
     *
     * @var array
     */
    protected $buttons = [
        'add'    => [
            'data-action' => 'add',
            'data-id'     => '{entry.id}',
            'text'        => 'pyro.module.menus::button.create_child_link',
            'href'        => 'admin/menus/links/choose/{request.route.parameters.menu}/{entry.id}',
        ],
        'view'   => [
            'data-action' => 'view',
            'data-id'     => '{entry.id}',
            'target'      => '_blank',
        ],
        'prompt' => [
            'data-action' => 'delete',
            'data-id'     => '{entry.id}',
            'href'        => 'admin/menus/links/delete/{entry.id}',
            'permission'  => 'pyro.module.menus::links.delete',
        ],
    ];



    /**
     * Fired when the builder is ready to build.
     *
     * @throws \Exception
     */
    public function onReady()
    {
        if ( ! $this->getMenu()) {
            throw new \Exception('The $menu parameter is required.');
        }
    }

    /**
     * Fired just before starting the query.
     *
     * @param Builder $query
     */
    public function onQuerying(Builder $query)
    {
        $menu = $this->getMenu();

        $query->where('menu_id', $menu->getId());
    }

    /**
     * Get the menu.
     *
     * @return MenuInterface|null
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set the menu.
     *
     * @param $menu
     *
     * @return $this
     */
    public function setMenu(MenuInterface $menu)
    {
        $this->menu = $menu;

        return $this;
    }
}
