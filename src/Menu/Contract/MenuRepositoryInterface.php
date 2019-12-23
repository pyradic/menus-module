<?php namespace Pyro\MenusModule\Menu\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

/**
 * \Pyro\MenusModule\Menu\Contract\MenuRepositoryInterface
 *
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
 * @mixin  \Pyro\MenusModule\Menu\MenuRepository
 */
interface MenuRepositoryInterface extends EntryRepositoryInterface
{

    /**
     * Find a menu by it's slug.
     *
     * @param $slug
     * @return null|MenuInterface
     */
    public function findBySlug($slug);
}
