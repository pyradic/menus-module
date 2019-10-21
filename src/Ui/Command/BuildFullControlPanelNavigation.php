<?php

namespace Pyro\MenusModule\Ui\Command;


use Illuminate\Support\Str;
use Pyro\MenusModule\Ui\Item;
use Illuminate\Support\Collection;
use Pyro\MenusModule\Ui\ItemCollection;
use Laradic\Support\Concerns\DispatchesJobs;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanel;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Section;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionInput;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionFactory;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationLink;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationSorter;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\ShortcutCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationFactory;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationResolver;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\BuildSections;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationEvaluator;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationNormalizer;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\Command\BuildShortcuts;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\SetActiveSection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Command\BuildNavigation;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Command\SetMainNavigationLinks;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Command\SetActiveNavigationLink;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Contract\NavigationLinkInterface;

class BuildFullControlPanelNavigation
{
    use DispatchesJobs;

    /** @var \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanel */
    protected $cp;
    /** @var \Anomaly\Streams\Platform\Support\Authorizer */
    protected $authorizer;
    /** @var \Anomaly\Streams\Platform\Addon\Module\ModuleCollection */
    protected $modules;
    /** @var \Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionInput */
    protected $sectionInput;
    /** @var \Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionFactory */
    protected $sectionFactory;
    /** @var \Pyro\MenusModule\Ui\ItemCollection */
    protected $resolved;
    /** @var \Anomaly\Streams\Platform\Addon\Module\Module */
    protected $activeModule;
    /** @var \Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface|null */
    protected $activeSection;

    public function __construct()
    {
        if ( ! Collection::hasMacro('reset')) {
            Collection::macro('reset', function () {
                $this->items = [];
                return $this;
            });
        }
    }

    protected function createControlPanelBuilder($cp = null)
    {
        if ($cp === null) {
            $cp = new ControlPanel(
                collect(),
                new SectionCollection(),
                new ShortcutCollection(),
                new NavigationCollection());
        }
        return new ControlPanelBuilder($cp);
    }

    public function init(Authorizer $authorizer, ModuleCollection $modules, SectionInput $sectionInput, SectionFactory $sectionFactory)
    {
        $this->authorizer     = $authorizer;
        $this->modules        = $modules;
        $this->sectionInput   = $sectionInput;
        $this->sectionFactory = $sectionFactory;
        $this->resolved       = new ItemCollection();
    }

    public function handle(Container $container)
    {
        $container->call([ $this, 'init' ]);
        $builder            = $this->createControlPanelBuilder();
        $this->cp           = $builder->getControlPanel();
        $this->activeModule = $this->modules->active();

        $this->dispatchNow(new BuildNavigation($builder));
        $this->dispatchNow(new SetActiveNavigationLink($builder));
        $this->dispatchNow(new SetMainNavigationLinks($builder));
        $this->dispatchNow(new BuildSections($builder));
        $this->dispatchNow(new SetActiveSection($builder));
        $this->dispatchNow(new BuildShortcuts($builder));

        $this->activeSection = $builder->getControlPanelActiveSection();
        /** @var \Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationLink[] $links */
        $links = $builder->getControlPanelNavigation()->map(function (NavigationLink $link) {
            $link->setTitle(trans($link->getTitle()));
            $link->setBreadcrumb(trans($link->getBreadcrumb()));
            return $link;
        });


        $active = $this->modules->active();
        $this->modules->toBase()->each->setActive(false);

        foreach ($links as $link) {
            if ( ! $this->authorizer->authorize($link->getPermission())) {
                continue;
            }
            $this->handleLink($link);
        }

        $this->modules->toBase()->each->setActive(false);
        if ($active !== null) {
            $active->setActive(true);
        }
        return $this->resolved;
    }

    public function handleLink(NavigationLinkInterface $link)
    {
        $builder = $this->createControlPanelBuilder();
        $this->dispatch(new BuildNavigation($builder));
        /** @var \Anomaly\Streams\Platform\Addon\Module\Module $module */
        $module    = $this->modules->get($link->getSlug());
        $wasActive = $module->isActive();
        $module->setActive(true);
        $this->sectionInput->read($builder);
        $module->setActive($wasActive);

        foreach ($builder->getSections() as $section) {
            $section = $this->sectionFactory->make($section);
            if ( ! $this->authorizer->authorize($section->getPermission()) || $section->isHidden()) {
                continue;
            }
            $this->addResolvedSection($link, $section);
        }

        $builder->getControlPanel()->getSections()->reset();
        $builder->setSections([]);
    }

    protected function addResolvedSection(NavigationLinkInterface $link, Section $section)
    {

        if ( ! $this->resolved->has($link->getSlug())) {
            $linkData = $this->getClassData($link);
            $linkItem = new Item($linkData);
            $this->resolved->put($link->getSlug(), $linkItem);
        }


        /** @var \Pyro\MenusModule\Ui\Item $linkItem */
        $linkItem = $this->resolved->get($link->getSlug());
        if ($this->activeSection->getSlug() === $section->getSlug() && $this->activeSection->getTitle() === $section->getTitle()) {
            $section->setActive(true);

        }
        $section->setTitle(trans($section->getTitle()));

        $sectionData = $this->getClassData($section);
        $sectionItem = new Item($sectionData);
        $linkItem->children->push($sectionItem);

        return $this;
    }

    protected function getClassData($instance)
    {
        $data    = [];
        $class   = new \ReflectionClass(get_class($instance));
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $methodName = $method->getName();
            if (Str::startsWith($methodName, [ 'get', 'is' ])) {
                $name          = preg_replace('/^(get|is)/', '', $methodName);
                $name          = Str::camel($name);
                $data[ $name ] = call_user_func([ $instance, $methodName ]);
            }
        }
        if(isset($data['attributes'])){
            $data = array_replace($data, $data['attributes']);
        }
        return $data;
    }


    public function buildNavigation(
        NavigationSorter $sorter,
        NavigationResolver $resolver,
        NavigationEvaluator $evaluator,
        NavigationNormalizer $normalizer,
        NavigationFactory $factory,
        $builder
    )
    {
        $resolver->resolve($builder);
        $evaluator->evaluate($builder);
        $normalizer->normalize($builder);
        $sorter->sort($builder);

        /** @var ControlPanelBuilder $builder */
        $controlPanel = $builder->getControlPanel();
        foreach ($builder->getNavigation() as $link) {
            $controlPanel->addNavigationLink($factory->make($link));
        }
    }

}
