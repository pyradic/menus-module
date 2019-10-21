<?php namespace Pyro\ModuleLinkTypeExtension;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Pyro\MenusModule\Ui\ControlPanelNavigation;
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
        list($addonNamespaces, $sectionSlug) = explode(':', $link->getEntry()->link);
        $links       = $this->navigation->resolve();
        $moduleLink  = $links->get($addonNamespaces);
        if(!$moduleLink){
            return null;
        }
        $sectionLink = $moduleLink->children->firstWhere('slug', $sectionSlug);
        if ( ! isset($sectionLink) || ! isset($sectionLink->href)) {
            return null;
        }
        return $sectionLink->href; //url($this->dispatch(new GetUrl($link->getEntry())));
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
        list($addonNamespaces, $sectionSlug) = explode(':', $link->getEntry()->link);
        $links       = $this->navigation->resolve();
        $moduleLink  = $links->get($addonNamespaces);
        $sectionLink = $moduleLink->children->firstWhere('slug', $sectionSlug);
        if ( ! isset($sectionLink) || ! isset($sectionLink->href)) {
            return false;
        }
        return "{$moduleLink->title}/{$sectionLink->title}";
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
