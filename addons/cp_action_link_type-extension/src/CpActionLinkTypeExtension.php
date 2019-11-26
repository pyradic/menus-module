<?php namespace Pyro\CpActionLinkTypeExtension;

use Illuminate\Support\NamespacedItemResolver;
use Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure;
use Pyro\CpActionLinkTypeExtension\Command\GetUrl;
use Pyro\CpActionLinkTypeExtension\Form\CpActionLinkTypeFormBuilder;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;

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
$key=$link->getEntry()->key;
        $resolver = resolve(NamespacedItemResolver::class);
        [ $nav, $sectionKey, $buttonKey ] = $resolver->parseKey($key);
        /** @var \Illuminate\Support\Collection|array $structure = \Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure::example() */
        $structure = $this->dispatchNow(new GetRecursiveControlPanelStructure());
        $sections  = $structure->pluck('children')->map->toArray()->flatten(1);
        $section = $sections->firstWhere('key', $nav . '::' . $sectionKey);

        $buttons = $sections->pluck('children')->map->toArray()->flatten(1);
        $button = $buttons->firstWhere('key', $nav . '::' . $sectionKey . '.' );


        if ( ! isset($section) || ! isset($button)) {
            return false;
        }
        return "{$section['title']} -> {$button['title']}";
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
