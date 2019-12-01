<?php namespace Pyro\ModuleLinkTypeExtension;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;
use Pyro\ModuleLinkTypeExtension\Command\GetUrl;
use Pyro\ModuleLinkTypeExtension\Form\ModuleLinkTypeFormBuilder;
use Pyro\Platform\Ui\ControlPanel\Command\BuildControlPanelStructure;

class ModuleLinkTypeExtension extends LinkTypeExtension
{
    protected $provides = 'pyro.module.menus::link_type.module';


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
        $key = $link->getEntry()->key;
        /** @var \Pyro\Platform\Ui\ControlPanel\ControlPanelStructure $structure */
        $structure  = $this->dispatchNow(new BuildControlPanelStructure());
        $navigation = $structure->getNavigation($key);
        $section    = $structure->getSection($key);

        $navigation[ 'title' ] = trans($navigation[ 'title' ] ?? '');
        $section[ 'title' ] = trans($section[ 'title' ] ?? '');
        return "{$navigation['title']}/{$section['title']}";
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
