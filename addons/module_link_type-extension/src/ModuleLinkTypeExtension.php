<?php namespace Pyro\ModuleLinkTypeExtension;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Support\NamespacedItemResolver;
use Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure;
use Pyro\MenusModule\Ui\ControlPanelNavigation;
use Pyro\ModuleLinkTypeExtension\Command\GetUrl;
use Pyro\ModuleLinkTypeExtension\Form\ModuleLinkTypeFormBuilder;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;

class ModuleLinkTypeExtension extends LinkTypeExtension
{
    /** @var ControlPanelNavigation */
    protected $navigation;
    protected $provides = 'pyro.module.menus::link_type.module';

    public function __construct(ControlPanelNavigation $navigation)
    {
        $this->navigation = $navigation;
    }

    public function url(LinkInterface $link)
    {
        return $this->dispatchNow(new GetUrl($link->getEntry()));
    }

    /**
     * Return the entry title.
     *
     * @param LinkInterface $link
     *
     * @return string
     */
    public function title(LinkInterface $link)
    {
        return $link->getEntry()->getTitle();
    }

    public function info(LinkInterface $link)
    {
        [ $nav, $sectionKey, $buttonKey ] = resolve(NamespacedItemResolver::class)->parseKey($link->getEntry()->key);
        /** @var \Illuminate\Support\Collection|array $structure = \Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure::example() */
        $structure = $this->dispatchNow(new GetRecursiveControlPanelStructure());
        $module = $structure->firstWhere('key', $nav);
        $section  = $structure->pluck('children')
            ->map->toArray()->flatten(1)
            ->firstWhere('key', $nav . '::' . $sectionKey);

        return "{$module['title']}/{$section['title']}";
    }

    /**
     * Return the form builder for
     * the link type entry.
     *
     * @return FormBuilder
     */
    public function builder()
    {
        return app(ModuleLinkTypeFormBuilder::class);
    }
}
