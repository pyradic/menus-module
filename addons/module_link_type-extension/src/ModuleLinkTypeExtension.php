<?php namespace Pyro\ModuleLinkTypeExtension;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;
use Pyro\ModuleLinkTypeExtension\Command\GetActionOptions;
use Pyro\ModuleLinkTypeExtension\Command\GetUrl;
use Pyro\ModuleLinkTypeExtension\Form\ModuleLinkTypeFormBuilder;
use Pyro\Platform\Ui\ControlPanel\Command\BuildControlPanelStructure;
use Pyro\Platform\Ui\ControlPanel\Command\TransformControlPanelNavigation;
use Pyro\Platform\Ui\ControlPanel\Component\Button;

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
        $options = dispatch_now(new         GetActionOptions());
        foreach($options as $title => $option){
            if(array_key_exists($key, $option)){
                return $option[$key];
            }
        }
            return $link->getEntryTitle();
    }

    public function color()
    {
        return '#607d8b';
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
