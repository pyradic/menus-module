<?php namespace Pyro\MenusModule\Link\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;
use Pyro\MenusModule\Link\LinkCollection;
use Pyro\MenusModule\Menu\Contract\MenuInterface;

/**
 * Interface LinkRepositoryInterface
 *
 * @link http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @mixin \Pyro\MenusModule\Link\LinkRepository
 */
interface LinkRepositoryInterface extends EntryRepositoryInterface
{

    /**
     * Return links belonging to
     * the provided menu.
     *
     * @param  MenuInterface  $menu
     * @return LinkCollection
     */
    public function findAllByMenu(MenuInterface $menu);
}
