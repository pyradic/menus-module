<?php namespace Pyro\MenusModule\Menu;

use Anomaly\Streams\Platform\Entry\EntryRepository;
use Pyro\MenusModule\Menu\Contract\MenuInterface;
use Pyro\MenusModule\Menu\Contract\MenuRepositoryInterface;

/**
 * \Pyro\MenusModule\Menu\MenuRepository
 *
 * @method \Anomaly\Streams\Platform\Entry\EntryCollection|\Pyro\MenusModule\Menu\Contract\MenuInterface[] all() 
 * @method \Anomaly\Streams\Platform\Entry\EntryCollection|\Pyro\MenusModule\Menu\Contract\MenuInterface[] allWithTrashed() 
 * @method \Anomaly\Streams\Platform\Entry\EntryCollection|\Pyro\MenusModule\Menu\Contract\MenuInterface[] allWithoutRelations() 
 * @method \Pyro\MenusModule\Menu\Contract\MenuInterface first($direction = "asc") 
 * @method \Pyro\MenusModule\Menu\Contract\MenuInterface find($id) 
 * @method \Pyro\MenusModule\Menu\Contract\MenuInterface findWithoutRelations($id) 
 * @method \Pyro\MenusModule\Menu\Contract\MenuInterface findBy($key, $value) 
 * @method \Anomaly\Streams\Platform\Entry\EntryCollection|\Pyro\MenusModule\Menu\Contract\MenuInterface[] findAll(array $ids) 
 * @method \Anomaly\Streams\Platform\Entry\EntryCollection|\Pyro\MenusModule\Menu\Contract\MenuInterface[] findAllBy(string $key, $value) 
 * @method \Pyro\MenusModule\Menu\Contract\MenuInterface findTrashed($id) 
 * @method \Anomaly\Streams\Platform\Entry\EntryQueryBuilder newQuery() 
 * @method \Pyro\MenusModule\Menu\Contract\MenuInterface create(array $attributes = []) 
 * @method \Pyro\MenusModule\Menu\MenuModel getModel() 
 * @method \Pyro\MenusModule\Menu\Contract\MenuInterface newInstance(array $attributes = []) 
 * @method \Anomaly\Streams\Platform\Entry\EntryCollection|\Pyro\MenusModule\Menu\Contract\MenuInterface[] sorted($direction = "asc") 
 * @method \Pyro\MenusModule\Menu\Contract\MenuInterface first($direction = "asc") 
 * @method \Pyro\MenusModule\Menu\Contract\MenuInterface lastModified() 
 */
class MenuRepository extends EntryRepository implements MenuRepositoryInterface
{

    /**
     * The menu model.
     *
     * @var MenuModel
     */
    protected $model;

    /**
     * Create a new MenuRepository instance.
     *
     * @param MenuModel $model
     */
    public function __construct(MenuModel $model)
    {
        $this->model = $model;
    }

    /**
     * Find a menu by it's slug.
     *
     * @param $slug
     * @return null|MenuInterface
     */
    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
