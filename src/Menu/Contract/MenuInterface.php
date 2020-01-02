<?php namespace Pyro\MenusModule\Menu\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Pyro\MenusModule\Link\LinkCollection;

/**
 * \Pyro\MenusModule\Menu\Contract\MenuInterface
 *
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 */
interface MenuInterface extends EntryInterface
{

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the related links.
     *
     * @return LinkCollection
     */
    public function getLinks();

    /**
     * Return the links relation.
     *
     * @return HasMany
     */
    public function links();
}
