<?php namespace Pyro\MenusModule\Menu;

use Anomaly\Streams\Platform\Model\Menus\MenusMenusEntryModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Pyro\MenusModule\Link\LinkCollection;
use Pyro\MenusModule\Link\LinkModel;
use Pyro\MenusModule\Link\LinkTree;
use Pyro\MenusModule\Menu\Contract\MenuInterface;

/**
 * \Pyro\MenusModule\Menu\MenuModel
 *
 */

/**
 * Pyro\MenusModule\Menu\MenuModel
 *
 * @property int                                                                                                                         $id
 * @property int|null                                                                                                                    $sort_order
 * @property mixed                                                                                                                       $created_at
 * @property int|null                                                                                                                    $created_by_id
 * @property mixed                                                                                                                       $updated_at
 * @property int|null                                                                                                                    $updated_by_id
 * @property mixed                                                                                                                       $deleted_at
 * @property string                                                                                                                      $slug
 * @property \Anomaly\UsersModule\Role\RoleCollection|\Anomaly\UsersModule\Role\RoleModel[]                                              $allowedRoles
 * @property \Anomaly\UsersModule\User\UserModel|null                                                                                    $createdBy
 * @property \Anomaly\UsersModule\User\UserModel|null                                                                                    $created_by
 * @property mixed|null                                                                                                                  $raw
 * @property LinkCollection|LinkModel[]                                                                                                  $links
 * @property \Anomaly\Streams\Platform\Model\EloquentCollection|\Anomaly\Streams\Platform\Model\Menus\MenusMenusEntryTranslationsModel[] $translations
 * @property \Anomaly\UsersModule\User\UserModel|null                                                                                    $updatedBy
 * @property \Anomaly\UsersModule\User\UserModel|null                                                                                    $updated_by
 * @property \Anomaly\Streams\Platform\Version\VersionCollection|\Anomaly\Streams\Platform\Version\VersionModel[]                        $versions
 * @property string                                                                                                                      $name
 * @property string                                                                                                                      $description
 * @property \Anomaly\UsersModule\Role\RoleModel                                                                                         $allowed_roles
 * @method static \Anomaly\Streams\Platform\Entry\EntryCollection|static[] all($columns = [ '*' ])
 * @method static \Anomaly\Streams\Platform\Entry\EntryCollection|static[] get($columns = [ '*' ])
 * @method static \Pyro\MenusModule\Menu\MenuModel make($attributes = [])
 * @method static \Anomaly\Streams\Platform\Entry\EntryQueryBuilder|MenuModel newModelQuery()
 * @method static \Anomaly\Streams\Platform\Entry\EntryQueryBuilder|MenuModel newQuery()
 * @method static \Anomaly\Streams\Platform\Entry\EntryQueryBuilder|MenuModel query()
 * @method static Builder|EntryModel sorted($direction = 'asc')
 * @method static Builder|EloquentModel translated()
 * @method static Builder|EloquentModel translatedIn($locale)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereAllowedRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuModel whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuModel whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuModel whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuModel whereUpdatedById($value)
 * @mixin \Eloquent
 * @method \Anomaly\Streams\Platform\Entry\EntryPresenter getPresenter()
 * @method \Anomaly\Streams\Platform\Entry\EntryCollection newCollection()
 * @method \Anomaly\Streams\Platform\Entry\EntryRouter newRouter()
 * @method \Anomaly\Streams\Platform\Entry\EntryQueryBuilder newEloquentBuilder()
 */
class MenuModel extends MenusMenusEntryModel implements MenuInterface
{

    /**
     * The cascaded relations.
     *
     * @var array
     */
    protected $cascades = [
        'links',
    ];

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the related links.
     *
     * @return LinkCollection
     */
    public function getLinks()
    {
        return $this->links;
    }

    public function toTree()
    {
        return new MenuNode($this);
    }

    /**
     * Return the links relation.
     *
     * @return HasMany
     */
    public function links()
    {
        return $this->hasMany(LinkModel::class, 'menu_id')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('parent_id', 'ASC');
    }
}
