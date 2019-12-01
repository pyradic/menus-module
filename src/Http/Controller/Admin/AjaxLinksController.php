<?php

namespace Pyro\MenusModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Support\Authorizer;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Pyro\MenusModule\Link\Command\ConvertStringToColors;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Link\Contract\LinkRepositoryInterface;
use Pyro\MenusModule\Link\Entry\EntryFormBuilder;
use Pyro\MenusModule\Link\Form\LinkFormBuilder;
use Pyro\MenusModule\Link\Tree\LinkTreeBuilder;
use Pyro\MenusModule\Menu\Contract\MenuInterface;
use Pyro\MenusModule\Menu\Contract\MenuRepositoryInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;
use Pyro\Platform\Http\PlatformAjaxResponse;

class AjaxLinksController extends AdminController
{

    public function index(MenuRepositoryInterface $menus, ExtensionCollection $extensions, $menu = null)
    {
//        app('Anomaly\Streams\Platform\View\ViewTemplate')->set('module', app('module.collection')->get('pyro.module.menus'));

        if ( ! $menu) {
            $this->messages->warning('Please choose a menu first.');
            return $this->response->redirectTo('admin/navigation');
        }

        $treeBuilder = $this->renderTree($menu);
        if ($this->request->isMethod('POST')) {
            return $treeBuilder->getTreeResponse();
        }
        $tree       = $treeBuilder->getTreeContent();
        $menu_types = $extensions->search('pyro.module.menus::link_type.*')->enabled();
        $this->setPlatformData($menu, $menu_types);
        return view('module::ajax_links', [ 'tree' => $tree, 'menu_types' => $menu_types, 'menu' => $menu ]);
    }

    public function tree($menu)
    {
        return response($this->getRenderedTree($menu));
    }

    public function create(
        LinkFormBuilder $linkFormBuilder,
        EntryFormBuilder $formBuilder,
        LinkRepositoryInterface $links,
        MenuRepositoryInterface $menus,
        ExtensionCollection $extensions,
        $menu,
        $type,
        $parent = null
    )
    {
        $isPost = request()->method() === 'POST';

        if ($type instanceof LinkTypeExtension === false) {
            /* @var LinkTypeExtension $type */
            $type = $extensions->search('pyro.module.menus::link_type.*')->get($type); //$this->request->get('menu_type'));
        }
        if ($menu instanceof MenuInterface === false) {
            $menu = $menus->findBySlug($menu);
        }
        /* @var LinkInterface $parent */
        if ($parent = $links->find($parent)) {
            $linkFormBuilder->setParent($parent);
        }
        $typeBuilder = $type->builder();
        if ($isPost) {
            $formBuilder->setAjax(true);
            $typeBuilder->setAjax(true);
            $linkFormBuilder->setAjax(true);
        }

        $link = $linkFormBuilder->setType($type)->setMenu($menu);
        $formBuilder->addForm('type', $typeBuilder);
        $formBuilder->addForm('link', $link);

        return $this->createFormResponse($type, $formBuilder);
    }

    public function edit(
        LinkFormBuilder $linkFormBuilder,
        EntryFormBuilder $formBuilder,
        LinkRepositoryInterface $links,
        MenuRepositoryInterface $menus,
        ExtensionCollection $extensions,
        $slug,
        $id
    )
    {
        $isPost = request()->method() === 'POST';

        /* @var LinkInterface $entry */
        $entry = $links->find($id);

        $type = $entry->getType();

        $formBuilder->addForm(
            'type',
            $type->builder()->setEntry($entry->getEntry()->getId())
        );

        $formBuilder->addForm(
            'link',
            $linkFormBuilder->setEntry($id)->setType($entry->getType())->setMenu($menu = $menus->findBySlug($slug))
        );
        return $this->createFormResponse($type, $formBuilder);
    }

    public function choose(ExtensionCollection $extensions, $menu)
    {
        return view(
            'module::ajax/choose_menu_type',
            [
                'menu_types' => $extensions
                    ->search('pyro.module.menus::link_type.*')
                    ->enabled(),
                'menu'       => $menu,
            ]
        );
    }

    public function change(LinkRepositoryInterface $links, ExtensionCollection $extensions, $menu)
    {
        /* @var LinkInterface $link */
        $link = $links->find($this->route->parameter('id'));

        return view(
            'module::ajax/change_link_type',
            [
                'link_types' => $extensions
                    ->search('pyro.module.menus::link_type.*')
                    ->enabled(),
                'link'       => $link,
                'menu'       => $menu,
            ]
        );
    }

    public function delete(LinkRepositoryInterface $links, Authorizer $authorizer)
    {
        abort_unless($authorizer->authorize('pyro.module.menus::links.delete'), trans('streams::message.access_denied'));
        $links->forceDelete($links->find($this->route->parameter('id')));

        if ($this->request->expectsJson()) {
            return $this->response->json([
                'success' => true,
            ]);
        }
        return $this->redirect->back();
    }

    protected $originalAssets;

    protected function rebindAssetsForAjax()
    {
        $this->originalAssets = resolve(Asset::class);
        app()->singleton(Asset::class, AjaxAsset::class);
        $assets = resolve(Asset::class);
        $assets->setDirectory(public_path());
        return $assets;
    }

    protected function revertRebindAssets()
    {
        app()->singleton(Asset::class, Asset::class);
        app()->instance(Asset::class, $this->originalAssets);
        return $this->originalAssets;
    }

    protected function renderTree($menu)
    {
        $treeBuilder = resolve(LinkTreeBuilder::class);
        $menus       = resolve(MenuRepositoryInterface ::class);
        if ($menu instanceof MenuInterface === false) {
            $menu = $menus->findBySlug((string)$menu);
        }

        abort_if(! $menu, Response::HTTP_NOT_ACCEPTABLE, 'Could not find menu');

        $treeBuilder->setMenu($menu);
        $treeBuilder->render();
        return $treeBuilder;
    }

    protected function getRenderedTree($menu)
    {

        $assets = resolve(Asset::class);
        /** @noinspection PhpUnhandledExceptionInspection */
        $assets->add('tree', 'streams::js/tree/tree.js');
        /** @var LinkTreeBuilder $treeBuilder */
        $treeBuilder = $this->renderTree($menu);
        $tree        = $treeBuilder->getTreeContent();
        $treeJs      = $assets->content('tree');

        $lines               = Str::lines($treeJs);
        $total               = count($lines);
        $lines[ 0 ]          = '(function(){';
        $lines[ $total - 2 ] = '})()';
        $treeJs              = implode("\n", $lines);

        $tree = "{$tree}<script>{$treeJs}</script>";

        return $tree;
    }

    protected function createFormResponse(Addon $type, EntryFormBuilder $formBuilder)
    {
        $assets = $this->rebindAssetsForAjax();
        if (request()->isMethod('POST')) {
            $formBuilder->setAjax(true);
            $formBuilder->render();
            return $formBuilder->getFormResponse();
        }
        $formBuilder->render();

        $data           = $this->getCachedFormAssets($type, $formBuilder);
        $data[ 'form' ] = $formBuilder->getFormContent()->render(); // content is a view, requires render()

        return PlatformAjaxResponse::create($data);
    }

    /**
     * @param \Anomaly\Streams\Platform\Addon\Addon         $type
     * @param \Pyro\MenusModule\Link\Entry\EntryFormBuilder $formBuilder
     * @param \DateTimeInterface|\DateInterval|int|null     $ttl
     *
     * @return array = ['scripts' => '', 'styles' => '']
     */
    protected function getCachedFormAssets(Addon $type, EntryFormBuilder $formBuilder, $ttl = null)
    {
        $cacheKey = $type->getNamespace() . '::' . $formBuilder->getFormFields()->map->getType()->implode(';');
        $ttl      = $ttl ?? now()->addDays(3);
        return resolve(Repository::class)->remember($cacheKey, $ttl, function () {
            return $this->getFormAssets();
        });
    }

    /**
     * @return array = ['scripts' => '', 'styles' => '']
     */
    protected function getFormAssets()
    {
        $assets = resolve(Asset::class);
        $styles = implode(PHP_EOL, $assets->inlines('styles.css'));
        $styles = \CssMin::minify($styles);

        $scripts = implode(PHP_EOL, $assets->inlines('scripts.js'));
        $scripts = implode(PHP_EOL, [ '(function(){', 'var module = {};', $scripts, ';', '}.call());' ]);
        $scripts = \JSMin::minify($scripts);

        return compact('styles', 'scripts');
    }

    protected function setPlatformData(string $menuSlug, ExtensionCollection $menuTypes)
    {
        $types = $menuTypes->map(function (LinkTypeExtension $type) {
            $name        = $type->getName();
            $description = $type->getDescription();
            $namespace   = $type->getNamespace();
            $title       = $type->getTitle();
            $slug        = $type->getSlug();
            /** @var array $colors = \Pyro\MenusModule\Link\Command\ConvertStringToColors::returnCompletion() */
            $colors       = dispatch_now(new ConvertStringToColors($type->getTitle()));
            $color        = (string)$colors[ 'color' ];
            $darkerColor  = (string)$colors[ 'darker' ];
            $lighterColor = (string)$colors[ 'lighter' ];
            return array_map('trans', compact('name', 'description', 'namespace', 'title', 'slug', 'color', 'darkerColor','lighterColor'));
        })->toArray();

        $urls = [
            'tree'   => $this->url->to("admin/menus/links/{$menuSlug}/tree"),
            'create' => $this->url->to("admin/menus/links/{$menuSlug}/create"),
            'edit'   => $this->url->to("admin/menus/links/{$menuSlug}/edit"),
            'delete' => $this->url->to('admin/menus/links/delete'),
        ];

        $platform = app()->platform
            ->addWebpackEntry('@pyro/menus-module')
            ->set('pyro.menus', compact('types', 'menuSlug', 'urls'));
    }
}
