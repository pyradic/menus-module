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
 * @property int $id
 * @property int|null $sort_order
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $created_by_id
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $updated_by_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property \Pyro\ActivityLogModule\Activity\ActivityCollection|\Pyro\ActivityLogModule\Activity\ActivityModel[] $actions
 * @property int|null $actions_count
 * @property \Pyro\ActivityLogModule\Activity\ActivityCollection|\Pyro\ActivityLogModule\Activity\ActivityModel[] $activityLogs
 * @property int|null $activity_logs_count
 * @property \Anomaly\UsersModule\Role\RoleCollection|\Anomaly\UsersModule\Role\RoleModel[] $allowedRoles
 * @property int|null $allowed_roles_count
 * @property \Anomaly\UsersModule\User\UserModel|null $createdBy
 * @property \Anomaly\UsersModule\User\UserModel|null $created_by
 * @property mixed|null $raw
 * @property \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\LinkModel[] $links
 * @property int|null $links_count
 * @property \Anomaly\Streams\Platform\Model\EloquentCollection|\Anomaly\Streams\Platform\Model\Menus\MenusMenusEntryTranslationsModel[] $translations
 * @property int|null $translations_count
 * @property \Anomaly\UsersModule\User\UserModel|null $updatedBy
 * @property \Anomaly\UsersModule\User\UserModel|null $updated_by
 * @property \Anomaly\Streams\Platform\Version\VersionCollection|\Anomaly\Streams\Platform\Version\VersionModel[] $versions
 * @property int|null $versions_count
 * @property string $name
 * @property string $description
 * @property \Anomaly\UsersModule\Role\RoleModel $allowed_roles
 * @method static \Pyro\MenusModule\Menu\MenuModel make($attributes=[])
 * @method static \Anomaly\Streams\Platform\Entry\EntryQueryBuilder|\Pyro\MenusModule\Menu\MenuModel newModelQuery()
 * @method static \Anomaly\Streams\Platform\Entry\EntryQueryBuilder|\Pyro\MenusModule\Menu\MenuModel newQuery()
 * @method static \Anomaly\Streams\Platform\Entry\EntryQueryBuilder|\Pyro\MenusModule\Menu\MenuModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Anomaly\Streams\Platform\Entry\EntryModel sorted($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Anomaly\Streams\Platform\Model\EloquentModel translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\Anomaly\Streams\Platform\Model\EloquentModel translatedIn($locale)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereAllowedRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Menu\MenuModel whereUpdatedById($value)
 * @mixin \Eloquent
 * @method \Anomaly\Streams\Platform\Entry\EntryPresenter getPresenter()
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
