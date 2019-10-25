<?php namespace Pyro\MenusModule;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\AddonIntegrator;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Model\Menus\MenusLinksEntryModel;
use Anomaly\Streams\Platform\Model\Menus\MenusMenusEntryModel;
use Anomaly\Streams\Platform\View\Event\TemplateDataIsLoading;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Pyro\MenusModule\Link\Contract\LinkRepositoryInterface;
use Pyro\MenusModule\Link\LinkModel;
use Pyro\MenusModule\Link\LinkRepository;
use Pyro\MenusModule\Menu\Command\BuildMenuNode;
use Pyro\MenusModule\Menu\Contract\MenuInterface;
use Pyro\MenusModule\Menu\Contract\MenuRepositoryInterface;
use Pyro\MenusModule\Menu\MenuModel;
use Pyro\MenusModule\Menu\MenuRepository;
use Pyro\MenusModule\Seeder\AdminMenuSeeder;

/**
 * Class MenusModuleServiceProvider
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class MenusModuleServiceProvider extends AddonServiceProvider
{

    protected $plugins = [
        MenusModulePlugin::class,
    ];

    protected $bindings = [
        MenusLinksEntryModel::class => LinkModel::class,
        MenusMenusEntryModel::class => MenuModel::class,
    ];

    protected $singletons = [
        LinkRepositoryInterface::class => LinkRepository::class,
        MenuRepositoryInterface::class => MenuRepository::class,
    ];

    protected $routes = [
        'admin/menus'                                    => [ 'as' => 'pyro.module.menus', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\MenusController@index' ],
        'admin/menus/choose'                             => [ 'as' => 'pyro.module.menus::choose', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\MenusController@choose' ],
        'admin/menus/create'                             => [ 'as' => 'pyro.module.menus::create', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\MenusController@create' ],
        'admin/menus/edit/{id}'                          => [ 'as' => 'pyro.module.menus::edit', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\MenusController@edit' ],
        'admin/menus/links/{menu?}'                      => [ 'as' => 'pyro.module.menus::links', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\AjaxLinksController@index', 'csrf' => false ],
        'admin/menus/links/{menu}/tree'                  => [ 'as' => 'pyro.module.menus::links.tree', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\AjaxLinksController@getTree' ],
        'admin/menus/links/{menu}/form/{type}/{parent?}' => [ 'as' => 'pyro.module.menus::links.form', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\AjaxLinksController@getForm' ],
        'admin/menus/links/{menu}/edit/{id}'             => [ 'as' => 'pyro.module.menus::links.edit', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\AjaxLinksController@getEditForm' ],
        'admin/menus/links/{menu}/create'                => [ 'as' => 'pyro.module.menus::links.create', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\LinksController@create' ],
        'admin/menus/links/{menu}/view/{id}'             => [ 'as' => 'pyro.module.menus::links.view', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\LinksController@view' ],
        'admin/menus/links/{menu}/change/{id}'           => [ 'as' => 'pyro.module.menus::links.change', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\LinksController@change' ],
        'admin/menus/links/delete/{id}'                  => [ 'as' => 'pyro.module.menus::links.delete', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\AjaxLinksController@delete' ],
//        'admin/menus/links/delete/{id}'                  => [ 'as' => 'pyro.module.menus::links.delete', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\LinksController@delete' ],
        'admin/menus/links/choose/{menu}/{parent?}'      => [ 'as' => 'pyro.module.menus::links.choose', 'uses' => 'Pyro\MenusModule\Http\Controller\Admin\LinksController@choose' ],

        //        'admin/menus/links/{menu?}'                 => 'Pyro\MenusModule\Http\Controller\Admin\LinksController@index',
        //        'admin/menus/links/{menu}/edit/{id}'        => 'Pyro\MenusModule\Http\Controller\Admin\LinksController@edit',

    ];

    public function register(AddonIntegrator $integrator, AddonCollection $addons)
    {
        $names = [ 'divider', 'header', 'label', 'module', 'url' ];
        foreach ($names as $name) {
            $addons->push($integrator->register(
                dirname(__DIR__) . '/addons/' . $name . '_link_type-extension/',
                'pyro.extension.' . $name . '_link_type',
                true,
                true
            ));
        }

        AdminMenuSeeder::registerSeed();

        $this->app->events->listen(TemplateDataIsLoading::class, function (TemplateDataIsLoading $event) {
            $template = $event->getTemplate();
            /** @var \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanel $cp */
            $cp = $template->get('cp');
            /** @var \Anomaly\Streams\Platform\Addon\Module\Module|\Anomaly\Streams\Platform\Addon\Module\ModulePresenter $module */
            $module = $template->get('module');
            /** @var \Pyro\Platform\Addon\Theme\Theme $theme */
            $theme = $template->get('theme');
            if ($theme->getNamespace() === 'pyro.theme.admin') {
                $repo = $this->app->make(MenuRepositoryInterface::class);

return;
$menus = $repo->newQuery()->where('slug', 'like', 'admin_%')->get();
                /** @var \Illuminate\Support\Collection|\Pyro\MenusModule\Menu\MenuNode[] $nodes */
                $nodes = $menus->filter(function (MenuInterface $menu) {
                    return Str::startsWith($menu->getSlug(), 'admin_');
                })
                    ->map(function (MenuInterface $menu) {
                        /** @var \Pyro\MenusModule\Menu\MenuNode $node */
                        $node = $this->dispatchNow(new BuildMenuNode($menu->toTree()));
                        return $node;
                    });

                $data = $this->app->platform->getData();
                foreach ($nodes->map->toArray()->keyBy('slug') as $slug => $menu) {
                    $data->set('menus.' . $slug, $menu);
                }
            }
        });
    }

    public function boot()
    {
    }

    public function map(Router $router)
    {
    }
}
