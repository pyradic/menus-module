<?php

namespace Pyro\MenusModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Support\Authorizer;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Link\Contract\LinkRepositoryInterface;
use Pyro\MenusModule\Link\Entry\EntryFormBuilder;
use Pyro\MenusModule\Link\Form\LinkFormBuilder;
use Pyro\MenusModule\Link\Tree\LinkTreeBuilder;
use Pyro\MenusModule\Menu\Contract\MenuInterface;
use Pyro\MenusModule\Menu\Contract\MenuRepositoryInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;

class AjaxLinksController extends AdminController
{


    public function index(MenuRepositoryInterface $menus, ExtensionCollection $extensions, $menu = null)
    {
        app('Anomaly\Streams\Platform\View\ViewTemplate')->set('module', app('module.collection')->get('pyro.module.menus'));

        if ( ! $menu) {
            $this->messages->warning('Please choose a menu first.');
            return $this->response->redirectTo('admin/navigation');
        }

        $isPost = $this->request->isMethod('POST');

        /** @var \Anomaly\Streams\Platform\Ui\Tree\TreeBuilder $treeBuilder */
        $treeBuilder = $this->call('renderTree', compact('menu'));
        $tree        = $treeBuilder->getTreeContent();
        if ($isPost) {
            return $treeBuilder->getTreeResponse();
        }
        $menu_types = $extensions->search('pyro.module.menus::link_type.*')->enabled();
        $this->setPlatformData($menu, $menu_types);
        return view('module::ajax_links', [ 'tree' => $tree, 'menu_types' => $menu_types, 'menu' => $menu ]);
    }

    protected function call($method, $params = [])
    {
        return app()->call([ $this, $method ], $params);
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

    public function renderTree(LinkTreeBuilder $treeBuilder, MenuRepositoryInterface $menus, $menu)
    {
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
        $assets->add('tree', 'streams::js/tree/tree.js');
        /** @var LinkTreeBuilder $treeBuilder */
        $treeBuilder = $this->call('renderTree', compact('menu'));
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

    public function getTree($menu)
    {

        return response($this->getRenderedTree($menu));
    }

    public function getForm(
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

        $formBuilder->setOption('wrapper_view', 'pyro.module.menus::wrapper_view');
        $this->rebindAssetsForAjax();

        if ($isPost) {
            $formBuilder->setAjax(true);
            $formBuilder->render();
            return $formBuilder->getFormResponse();
        }

        $formBuilder->render();
        $content = $formBuilder->getFormContent();

        $assets = resolve(Asset::class);
        $js     = $assets->has('scripts.js') ? $assets->content('scripts.js') : '';
        $css    = $assets->has('styles.css') ? $assets->inline('styles.css') : '';
        return response()->json([
            'form' => $content->render(),
            'css'  => $css,
            'js'   => "
(function(){
    var module = {};

    {$js}
    ;

}.call());                 
            ",
        ]);
        return $content;
    }

    public function addFormAssetsToContent($content)
    {
        $assets = resolve(Asset::class);
        $js     = $assets->has('scripts.js') ? $assets->content('scripts.js') : '';
        $css    = $assets->has('styles.css') ? $assets->inline('styles.css') : '';
        return "
<style type='text/css'>{$css}</style>

{$content}

<py-script>
(function(){
    var module = {};

    {$js}
    ;

}.call());     
 </py-script>";
    }

    public function getEditForm(
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

        $assets = $this->rebindAssetsForAjax();

        if ($isPost) {
            $formBuilder->setAjax(true);
            $formBuilder->render();
            return $formBuilder->getFormResponse();
        }

        $formBuilder->render();
        $content = $formBuilder->getFormContent();
        $js  = $assets->has('scripts.js') ? $assets->content('scripts.js') : '';
        $css = $assets->has('styles.css') ? $assets->inline('styles.css') : '';
        return response()->json([
            'form' => $content->render(),
            'css'  => $css,
            'js'   => "
(function(){
    var module = {};

    {$js}
    ;

}.call());                 
            ",
        ]);
    }

    public function create(
        LinkFormBuilder $link,
        EntryFormBuilder $form,
        LinkRepositoryInterface $links,
        MenuRepositoryInterface $menus,
        ExtensionCollection $extensions,
        $menu,
        $type
    )
    {
        if ($type instanceof LinkTypeExtension === false) {
            /* @var LinkTypeExtension $type */
            $type = $extensions->get($type); //$this->request->get('menu_type'));
        }
        if ($menu instanceof MenuInterface === false) {
            $menu = $menus->findBySlug($menu);
        }

        /* @var LinkInterface $parent */
        if ($parent = $links->find($this->request->get('parent'))) {
            $link->setParent($parent);
        }

        $form->addForm('type', $type->builder());
        $form->addForm('link', $link->setType($type)->setMenu($menu));

        $this->breadcrumbs->add($menu->getName(), 'admin/navigation/links/' . $menu->getSlug());

        return $form;
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

    protected function setPlatformData(string $menuSlug, ExtensionCollection $menuTypes)
    {
        $types = $menuTypes->map(function (LinkTypeExtension $type) {
            $name        = $type->getName();
            $description = $type->getDescription();
            $namespace   = $type->getNamespace();
            $title       = $type->getTitle();
            $slug        = $type->getSlug();
            return array_map('trans', compact('name', 'description', 'namespace', 'title', 'slug'));
        })->toArray();

        $urls = [
            'tree'   => $this->url->to("admin/menus/links/{$menuSlug}/tree"),
            'create' => $this->url->to("admin/menus/links/{$menuSlug}/form"),
            'edit'   => $this->url->to("admin/menus/links/{$menuSlug}/edit"),
            'delete' => $this->url->to('admin/menus/links/delete'),
        ];

        $platform = app()->platform
            ->addPublicScript('assets/js/pyro__menus.js')
            ->addPublicStyle('assets/css/pyro__menus.css')
            ->addProvider('pyro.pyro__menus.MenusServiceProvider')
            ->set('pyro.menus', compact('types', 'menuSlug', 'urls'));
    }
}
