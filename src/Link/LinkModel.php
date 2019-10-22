<?php namespace Pyro\MenusModule\Link;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryCollection;
use Anomaly\Streams\Platform\Model\Menus\MenusLinksEntryModel;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Menu\Contract\MenuInterface;
use Pyro\MenusModule\Type\Contract\LinkTypeInterface;

/**
 * Pyro\MenusModule\Link\LinkModel
 *
 * @property int                                                                                                  $id
 * @property int|null                                                                                             $sort_order
 * @property \Illuminate\Support\Carbon                                                                           $created_at
 * @property int|null                                                                                             $created_by_id
 * @property \Illuminate\Support\Carbon|null                                                                      $updated_at
 * @property int|null                                                                                             $updated_by_id
 * @property \Illuminate\Support\Carbon|null                                                                      $deleted_at
 * @property int                                                                                                  $menu_id
 * @property string                                                                                               $type
 * @property int                                                                                                  $entry_id
 * @property string                                                                                               $entry_type
 * @property string                                                                                               $target
 * @property string|null                                                                                          $class
 * @property int|null                                                                                             $parent_id
 * @property \Anomaly\UsersModule\Role\RoleCollection|\Anomaly\UsersModule\Role\RoleModel[]                       $allowedRoles
 * @property \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\LinkModel[]                             $children
 * @property \Anomaly\UsersModule\User\UserModel|null                                                             $createdBy
 * @property \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\LinkModel[]                             $entry
 * @property mixed|null                                                                                           $raw
 * @property \Anomaly\Streams\Platform\Entry\EntryCollection|\Pyro\MenusModule\Menu\MenuModel[]                   $menu
 * @property \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\LinkModel[]                             $parent
 * @property \Anomaly\UsersModule\User\UserModel|null                                                             $updatedBy
 * @property \Anomaly\Streams\Platform\Version\VersionCollection|\Anomaly\Streams\Platform\Version\VersionModel[] $versions
 * @method static \Pyro\MenusModule\Link\LinkModel make($attributes=[])
 * @method static \Anomaly\Streams\Platform\Entry\EntryQueryBuilder|\Pyro\MenusModule\Link\LinkModel newModelQuery()
 * @method static \Anomaly\Streams\Platform\Entry\EntryQueryBuilder|\Pyro\MenusModule\Link\LinkModel newQuery()
 * @method static \Anomaly\Streams\Platform\Entry\EntryQueryBuilder|\Pyro\MenusModule\Link\LinkModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Anomaly\Streams\Platform\Entry\EntryModel sorted($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Anomaly\Streams\Platform\Model\EloquentModel translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\Anomaly\Streams\Platform\Model\EloquentModel translatedIn($locale)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereEntryType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Pyro\MenusModule\Link\LinkModel whereUpdatedById($value)
 * @mixin \Eloquent
 * @property int|null $allowed_roles_count
 * @property int|null $children_count
 * @property int|null $versions_count
 * @property string|null $icon
 */
class LinkModel extends MenusLinksEntryModel implements LinkInterface
{

    /**
     * The cascaded relations.
     *
     * @var array
     */
    protected $cascades = [
        'children',
        'entry',
    ];

    /**
     * Touch relations.
     *
     * @var array
     */
    protected $touches = [
        'menu',
    ];

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * The current flag.
     *
     * @var bool
     */
    protected $current = false;

    /**
     * Eager load these relationships.
     *
     * @var array
     */
    protected $with = [
        'entry',
        'allowedRoles',
    ];

    /**
     * Return the host.
     *
     * @return string
     */
    public function host()
    {
        return array_get(parse_url($this->getUrl()), 'host');
    }

    /**
     * Return the URI path.
     *
     * @return string
     */
    public function path()
    {
        $pattern = '/^\/(' . implode('|', array_keys(config('streams::locales.supported'))) . ')(\/|$)/';

        return preg_replace($pattern, '/', array_get(parse_url($this->getUrl()), 'path'));
    }

    /**
     * Get the URL.
     *
     * @return string
     */
    public function getUrl()
    {
        $type = $this->getType();

        if (!$type) {
            return null;
        }

        return $type->url($this);
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle()
    {
        $type = $this->getType();

        if (!$type) {
            return null;
        }

        return $type->title($this);
    }

    /**
     * Get the broken flag.
     *
     * @return bool
     */
    public function isBroken()
    {
        $type = $this->getType();

        if (!$type) {
            return null;
        }

        return $type->broken($this);
    }

    /**
     * Get the enabled flag.
     *
     * @return bool
     */
    public function isEnabled()
    {
        $type = $this->getType();

        if (!$type) {
            return null;
        }

        return $type->enabled($this);
    }

    /**
     * Get the type.
     *
     * @return LinkTypeInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the related entry.
     *
     * @return EntryInterface
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Get the link target.
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Get the related allowed roles.
     *
     * @return EntryCollection
     */
    public function getAllowedRoles()
    {
        return $this->allowedRoles;
    }

    /**
     * Get the related parent.
     *
     * @return null|LinkInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get the parent ID.
     *
     * @return null|int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Set the parent ID.
     *
     * @param $id
     * @return $this
     */
    public function setParentId($id)
    {
        $this->parent_id = $id;

        return $this;
    }

    /**
     * Get the related child links.
     *
     * @return LinkCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get the menu.
     *
     * @return MenuInterface
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Get the menu slug.
     *
     * @return string
     */
    public function getMenuSlug()
    {
        $menu = $this->getMenu();

        return $menu->getSlug();
    }

    /**
     * Set the active flag.
     *
     * @param $true
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Return the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set the current flag.
     *
     * @param $true
     * @return $this
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Return the current flag.
     *
     * @return bool
     */
    public function isCurrent()
    {
        return $this->current;
    }

    /**
     * Return the child links relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('Pyro\MenusModule\Link\LinkModel', 'parent_id', 'id');
    }

    public function grandchildren()
    {
        return $this->children()->with('grandchildren');
    }

    /**
     * Return the model as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();

        $array['url']   = $this->getUrl();
        $array['title'] = $this->getTitle();

        return $array;
    }
}
