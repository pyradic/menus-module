<?php namespace Pyro\MenusModule\Menu\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

/**
 * Interface MenuRepositoryInterface
 *
 * @link http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @mixin \Pyro\MenusModule\Menu\MenuRepository
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
