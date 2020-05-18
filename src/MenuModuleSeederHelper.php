<?php

namespace Pyro\MenusModule;

use Anomaly\Streams\Platform\Entry\EntryRepository;
use Anomaly\UsersModule\Role\Contract\RoleInterface;
use Anomaly\UsersModule\Role\Contract\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Pyro\CpActionLinkTypeExtension\CpActionLinkTypeModel;
use Pyro\DisabledLinkTypeExtension\DisabledLinkTypeModel;
use Pyro\DividerLinkTypeExtension\DividerLinkTypeModel;
use Pyro\HeaderLinkTypeExtension\HeaderLinkTypeModel;
use Pyro\LabelLinkTypeExtension\LabelLinkTypeModel;
use Pyro\MenusModule\Link\Contract\LinkRepositoryInterface;
use Pyro\MenusModule\Menu\Contract\MenuInterface;
use Pyro\MenusModule\Menu\Contract\MenuRepositoryInterface;
use Pyro\ModuleLinkTypeExtension\Command\GetUrl;
use Pyro\ModuleLinkTypeExtension\ModuleLinkTypeModel;
use Pyro\Platform\Database\SeederHelper;
use Pyro\Platform\Ui\ControlPanel\Command\TransformControlPanelNavigation;
use Pyro\UrlLinkTypeExtension\UrlLinkTypeModel;

class MenuModuleSeederHelper extends SeederHelper
{
    /** @var \Pyro\MenusModule\Menu\MenuModel */
    protected $menu;

    /** @var EntryRepository */
    protected $repo;

    /**
     * @param MenuInterface|string|int $menu
     */
    public function menu($slug, $name = null, $description = null)
    {
        $menu        = $slug;
        $name        = $name ? $name : $menu;
        $description = $description ? $description : $name;
        $repo        = resolve(MenuRepositoryInterface::class);
        if ($menu instanceof MenuInterface === false) {
            if (is_numeric($menu)) {
                $menu = $repo->find((int)$menu);
            } else {
                $menu = $repo->findBySlug($menu);
            }
            if ($menu === null) {
                $menu = $repo->create([
                    $this->locale() => [
                        'name'        => $name,
                        'description' => $description,
                    ],
                    'slug'          => $slug,
                ]);
            }
        }

        $this->menu = $menu;
        return $this;
    }

    public function truncate()
    {
        $links = resolve(LinkRepositoryInterface::class);
        foreach ($this->menu->getLinks() as $link) {
            /** @var \Pyro\MenusModule\Link\LinkModel $link */
            $links->delete($link);
        }
        return $this;
    }

    public function model($model)
    {
        if ($this->repo === null) {
            $this->repo = new EntryRepository();
        }
        if (is_string($model)) {
            $model = app()->build($model);
        }
        $this->repo->setModel($model);
        return $this;
    }

    /**
     * @param null  $title
     * @param array $entryData
     * @param array $linkData
     *
     * @return \Pyro\MenusModule\Link\Contract\LinkInterface
     */
    public function createLink($title = null, array $entryData = [], array $linkData = [])
    {
        $links = resolve(LinkRepositoryInterface::class);
        if ($title !== null) {
            $entryData = array_replace([ $this->locale() => [ 'title' => $title, ], ], $entryData);
        }
        $entry = $this->repo->create($entryData);

        $model     = $this->repo->getModel(); //$stream = $model->getStream();
        $namespace = $model->getStreamNamespace();
        $linkData  = array_replace_recursive([
            'menu'   => $this->menu,
            'target' => '_blank',
            'entry'  => $entry,
            'type'   => 'pyro.extension.' . $namespace,
        ], $linkData);
        $link      = $links->create($linkData);

        return $link;
    }

    public function divider($title = null, array $entryData = [], array $linkData = [])
    {
        $this->model(DividerLinkTypeModel::class);
        return $this->createLink($title, $entryData, $linkData);
    }

    public function header($title = null, array $entryData = [], array $linkData = [])
    {
        $this->model(HeaderLinkTypeModel::class);
        return $this->createLink($title, $entryData, $linkData);
    }

    public function label($title = null, array $entryData = [], array $linkData = [])
    {
        $this->model(LabelLinkTypeModel::class);
        return $this->createLink($title, $entryData, $linkData);
    }

    public function module($title = null, array $entryData = [], array $linkData = [])
    {
        $this->model(ModuleLinkTypeModel::class);
        $link= $this->createLink($title, $entryData, $linkData);
        /** @var \Pyro\ModuleLinkTypeExtension\ModuleLinkTypeModel $entry */
        $entry = $link->entry;
        [$namespace,$slugs] = explode('::',$entry->key);
        $slugs = explode('.',$slugs);
        $node    = dispatch_now(new TransformControlPanelNavigation());

        $roles = resolve(RoleRepositoryInterface::class)->all();

        /** @var \Pyro\Platform\Ui\ControlPanel\Component\NavigationNode $node */
        $node    = dispatch_now(new TransformControlPanelNavigation());
        $children = $node->getAllDescendants();
        $node = $children->firstWhere('key','crvs.module.clients::requester.requests');
        $allowedRoles = $roles->filter(function(RoleInterface $role) use ($node){
            return $role->hasPermission($node->permission);
        });
        if($allowedRoles->isNotEmpty()) {
            $link->allowedRoles()->sync($allowedRoles->ids());
        }
        return $link;
    }

    public function disabled($title = null, array $entryData = [], array $linkData = [])
    {
        $this->model(DisabledLinkTypeModel::class);
        return $this->createLink($title, $entryData, $linkData);
    }

    public function url($title = null, array $entryData = [], array $linkData = [])
    {
        $this->model(UrlLinkTypeModel::class);
        return $this->createLink($title, $entryData, $linkData);
    }

    public function action($title = null, array $entryData = [], array $linkData = [])
    {
        $this->model(CpActionLinkTypeModel::class);
        return $this->createLink($title, $entryData, $linkData);
    }

}
