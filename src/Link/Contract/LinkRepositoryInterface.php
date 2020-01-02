<?php namespace Pyro\MenusModule\Link\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;
use Pyro\MenusModule\Link\LinkCollection;
use Pyro\MenusModule\Menu\Contract\MenuInterface;

/**
 * \Pyro\MenusModule\Link\Contract\LinkRepositoryInterface
 *
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
