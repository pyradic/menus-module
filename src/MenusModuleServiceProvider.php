<?php namespace Pyro\MenusModule;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\AddonIntegrator;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\Menus\MenusLinksEntryModel;
use Anomaly\Streams\Platform\Model\Menus\MenusMenusEntryModel;
use Illuminate\Routing\Router;
use Pyro\MenusModule\Link\Contract\LinkRepositoryInterface;
use Pyro\MenusModule\Link\LinkModel;
use Pyro\MenusModule\Link\LinkRepository;
use Pyro\MenusModule\Menu\Contract\MenuRepositoryInterface;
use Pyro\MenusModule\Menu\MenuModel;
use Pyro\MenusModule\Menu\MenuRepository;

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
    }

    public function boot()
    {
    }

    public function map(Router $router)
    {
    }
}
