<?php

namespace Pyro\ModuleLinkTypeExtension\Command;

use Crvs\Platform\Ui\ControlPanel\Command\TransformControlPanelNavigation;
use Crvs\Platform\Ui\ControlPanel\Component\Button;

class GetOptionAction
{
    protected $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function handle()
    {
        return $this->getFlattened()->get($this->key);
    }

    /** @return \Illuminate\Support\Collection */
    protected function getFlattened()
    {
        /** @var \Crvs\Platform\Ui\ControlPanel\Component\NavigationNode $node */
        $node = dispatch_now(new TransformControlPanelNavigation());
        $sections = $node->getAllDescendants()->sections()->map->getValue();
        $buttons = $sections->map->getButtons()->flatten(1)->filter(function($button){
            return $button instanceof Button;
        });

        return $sections->merge($buttons)->keyBy->getKey();
    }
}
