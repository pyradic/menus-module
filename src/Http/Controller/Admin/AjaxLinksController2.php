<?php

namespace Pyro\MenusModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Support\Authorizer;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Response;
use Pyro\MenusModule\Link\Command\ConvertStringToColors;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Link\Contract\LinkRepositoryInterface;
use Pyro\MenusModule\Link\Entry\EntryFormBuilder;
use Pyro\MenusModule\Link\Form\LinkFormBuilder;
use Pyro\MenusModule\Link\Tree\LinkTreeBuilder;
use Pyro\MenusModule\Menu\Contract\MenuInterface;
use Pyro\MenusModule\Menu\Contract\MenuRepositoryInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;
use Pyro\Platform\Command\ExtractTagsFromHtml;
use Pyro\Platform\Http\PlatformAjaxResponse;

class AjaxLinksController2 extends AdminController
{

    public function index(MenuRepositoryInterface $menus, ExtensionCollection $extensions, $menu = null)
    {
//        app('Anomaly\Streams\Platform\View\ViewTemplate')->set('module', app('module.collection')->get('pyro.module.menus'));

        start_measure(__METHOD__);
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

        stop_measure(__METHOD__);
        return view('module::ajax_links', [ 'tree' => $tree, 'menu_types' => $menu_types, 'menu' => $menu ]);
    }

    public function tree($menu)
    {

        return response($this->getRenderedTree($menu));
    }

    protected function renderTree($menu)
    {
        start_measure(__METHOD__);
        $treeBuilder = resolve(LinkTreeBuilder::class);
        $menus       = resolve(MenuRepositoryInterface ::class);
        if ($menu instanceof MenuInterface === false) {
            $menu = $menus->findBySlug((string)$menu);
        }

        abort_if(! $menu, Response::HTTP_NOT_ACCEPTABLE, 'Could not find menu');

        $treeBuilder->setMenu($menu);
        $treeBuilder->render();
        stop_measure(__METHOD__);
        return $treeBuilder;
    }

    protected function getRenderedTree($menu)
    {
        start_measure(__METHOD__);
        $assets = resolve(Asset::class);
        /** @noinspection PhpUnhandledExceptionInspection */
        $assets->add('tree', 'streams::js/tree/tree.js');
        /** @var LinkTreeBuilder $treeBuilder */
        $treeBuilder = $this->renderTree($menu);
        $tree        = $treeBuilder->getTreeContent();
        stop_measure(__METHOD__);
//        $treeJs      = $assets->content('tree');
//
//        $lines               = Str::lines($treeJs);
//        $total               = count($lines);
//        $lines[ 0 ]          = '(function(){';
//        $lines[ $total - 2 ] = '})()';
//        $treeJs              = implode("\n", $lines);
//
//        $tree = "{$tree}<script>{$treeJs}</script>";

        return $tree;
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

        start_measure(__METHOD__);
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

        stop_measure(__METHOD__);
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

        start_measure(__METHOD__);
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

        stop_measure(__METHOD__);
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

    private function measureName($method = null, $suffix = null, $prefix = 'menus')
    {
        add_measure();
        debug_backtrace()[ 0 ][ 'function' ];
        return $prefix . '.' . $method . ($suffix ? '.' . $suffix : '');
    }

    protected function measure($method, $suffix = null, $prefix = 'menus')
    {
        debugbar()->startMeasure($this->measureName($method, $suffix, $prefix));
    }

    protected function measured($method, $suffix = null, $prefix = 'menus')
    {
        debugbar()->stopMeasure($this->measureName($method, $suffix, $prefix));
    }

    protected function createFormResponse(Addon $type, EntryFormBuilder $formBuilder)
    {
        $formBuilder->setAjax(true);
        start_measure(__METHOD__);
        $formBuilder->render();
        if (request()->isMethod('POST')) {
            stop_measure(__METHOD__);
            return $formBuilder->getFormResponse();
        }
        start_measure(__METHOD__ . '.render');
        $form = $formBuilder->render()->getContent();
        stop_measure(__METHOD__ . '.render');
        stop_measure(__METHOD__);

        /** @var \Pyro\Platform\Command\ExtractedTags $result */
        $result = dispatch_now(new ExtractTagsFromHtml('script', $form));
        $form = $result->getResultHtml();
        $scripts = $result->getExtractedHtml();

        $result = dispatch_now(new ExtractTagsFromHtml('link', $form));
        $form = $result->getResultHtml();
        $styles = $result->getExtractedHtml();

        return PlatformAjaxResponse::create(compact('form','styles','scripts'));
    }

    protected function extractTagFromContent($tag, $content)
    {
        $source    = new \DOMDocument();
        $extracted = new \DOMDocument();
        $source->loadHTML($content);
        $elements = $source->getElementsByTagName('script');
        $styles   = $source->getElementsByTagName('styles');
        for ($i = 0; $i < $elements->length; $i++) {
            $element = $elements->item($i);
            $extracted->importNode($element);
            $element->parentNode->removeChild($element);
        }
        return [
            $source->saveHTML(),
            $extracted->saveHTML(),
        ];
    }

    protected function setPlatformData(string $menuSlug, ExtensionCollection $menuTypes)
    {

        start_measure(__METHOD__);
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
            return array_map('trans', compact('name', 'description', 'namespace', 'title', 'slug', 'color', 'darkerColor', 'lighterColor'));
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

        stop_measure(__METHOD__);
    }
}
