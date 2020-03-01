<?php namespace Pyro\CpActionLinkTypeExtension;

use Pyro\CpActionLinkTypeExtension\Command\GetUrl;
use Pyro\CpActionLinkTypeExtension\Form\CpActionLinkTypeFormBuilder;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;
use Pyro\Platform\Ui\ControlPanel\Command\BuildControlPanelStructure;
use Pyro\Platform\Ui\ControlPanel\Command\TransformControlPanelNavigation;

class CpActionLinkTypeExtension extends LinkTypeExtension
{

    protected $provides = 'pyro.module.menus::link_type.cp_action';

    public function url(LinkInterface $link)
    {
        return dispatch_now(new GetUrl($link->getEntry()));
    }

    public function title(LinkInterface $link)
    {
        return $link->getEntry()->getTitle();
    }

    public function enabled(LinkInterface $link)
    {
        return true;
    }

    public function info(LinkInterface $link)
    {
        $key = $link->getEntry()->key;
        /** @var \Pyro\Platform\Ui\ControlPanel\Component\NavigationNode $nav */
        $nav     = dispatch_now(new TransformControlPanelNavigation());
        $sections   = $nav->getAllDescendants()->sections();
        $buttons = $sections->map->getButtons()->filter(function ($buttons) {
            return $buttons instanceof \Illuminate\Support\Collection;
        })->flatten(1);

        $button = $buttons->firstWhere('key', $key);
        if (!$button) {
            return '';
        }
        $section = $sections->firstWhere('key',$button->getSectionKey());
        return trans($section->getTitle()) . ' -> ' . trans($button->getTitle());

//        /** @var \Pyro\Platform\Ui\ControlPanel\ControlPanelStructure $structure */
//        $structure = $this->dispatchNow(new BuildControlPanelStructure());
//        $section   = $structure->getSection($key);
//        $button    = $structure->getButton($key);
//
//        $section[ 'title' ] = trans($section[ 'title' ] ?? '');
//        $button[ 'title' ]  = trans($button[ 'title' ] ?? '');
//        return "{$section['title']} -> {$button['title']}";
    }

    public function view()
    {
        return null;
    }

    public function builder()
    {
        return app(CpActionLinkTypeFormBuilder::class);
    }
}
