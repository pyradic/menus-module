<?php namespace Pyro\MenusModule\Link\Command;

use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Menu\Command\GetMenu;

/**
 * Class RenderMenus
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class RenderMenusJson
{

    use DispatchesJobs;

    /**
     * The rendering options.
     *
     * @var Collection
     */
    protected $options;

    protected $hidden = [ 'created_at', 'created_by_id', 'updated_at', 'updated_by_id', 'deleted_at', 'menu_id', 'entry_type' ];

    /**
     * Create a new RenderMenus instance.
     *
     * @param Collection $options
     */
    function __construct(Collection $options)
    {
        $this->options = $options;
    }

    /**
     * Handle the command.
     *
     * @param Factory $view
     *
     * @return null|string
     */
    public function handle(Factory $view)
    {
        $this->dispatch(new HandlePresets($this->options));

        /** @var \Pyro\MenusModule\Menu\Contract\MenuInterface $menu */
        $menu = $this->dispatch(new GetMenu($this->options->get('menu')));
        /** @var \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] $links */
        $links = $this->dispatch(new GetLinks($this->options, $menu));

        $tree = $this->makeTree($links->top());

        $menuData = $menu->toArray();
        $menuData['children']=$tree;
        app()->platform->getData()->set('menus.' . $menu->getSlug(), $menuData);


        return "<py-menu  :menu='menus.{$menu->getSlug()}' horizontal></py-menu> ";
    }

    /**
     * @param \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] $links
     *
     * @return array
     */
    protected function makeTree($links)
    {
        $tree = [];
        foreach ($links as $link) {
            $item               = $this->getLinkArray($link);
            $item[ 'children' ] = [];

            if ($link->children->isNotEmpty()) {
                $item[ 'children' ] = $this->makeTree($link->children);
            }
            $tree[] = $item;
        }
        return $tree;
    }

    protected function getLinkArray(LinkInterface $link)
    {
        $hidden = $link->getHidden();
        $link->setHidden($this->hidden);
        $array = $link->toArray();
        $link->setHidden($hidden);
        return $array;
    }
}
