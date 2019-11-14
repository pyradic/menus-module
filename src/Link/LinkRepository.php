<?php namespace Pyro\MenusModule\Link;

use Anomaly\Streams\Platform\Entry\EntryRepository;
use Pyro\MenusModule\Link\Contract\LinkRepositoryInterface;
use Pyro\MenusModule\Menu\Contract\MenuInterface;

/**
 * \Pyro\MenusModule\Link\LinkRepository
 *
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] all() 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] allWithTrashed() 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] allWithoutRelations() 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface first($direction = "asc") 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface find($id) 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface findWithoutRelations($id) 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface findBy($key, $value) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] findAll(array $ids) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] findAllBy(string $key, $value) 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface findTrashed($id) 
 * @method \Anomaly\Streams\Platform\Entry\EntryQueryBuilder newQuery() 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface create(array $attributes = []) 
 * @method \Pyro\MenusModule\Link\LinkModel getModel() 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface newInstance(array $attributes = []) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] sorted($direction = "asc") 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface first($direction = "asc") 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface lastModified() 
 */
class LinkRepository extends EntryRepository implements LinkRepositoryInterface
{

    /**
     * The link model.
     *
     * @var LinkModel
     */
    protected $model;

    /**
     * Create a new LinkRepository instance.
     *
     * @param LinkModel $model
     */
    public function __construct(LinkModel $model)
    {
        $this->model = $model;
    }

    /**
     * Return links belonging to
     * the provided menu.
     *
     * @param  MenuInterface  $menu
     * @return LinkCollection
     */
    public function findAllByMenu(MenuInterface $menu)
    {
        return $this->model->where('menu_id', $menu->getId())->get();
    }
}
