<?php

namespace Pyro\CpActionLinkTypeExtension\Command;


use Pyro\Platform\Ui\ControlPanel\Command\TransformControlPanelNavigation;
use Pyro\Platform\Ui\ControlPanel\Component\Button;

class GetOptionAction
{
    protected $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function handle()
    {
        foreach($this->getFlattened() as $node){
            if($node->getKey() === $this->key){
                return $node;
            }
        }
//        return $this->getFlattened()->firstWhere('key', $this->key);
    }

    /** @return \Illuminate\Support\Collection */
    protected function getFlattened()
    {
        /** @var \Pyro\Platform\Ui\ControlPanel\Component\NavigationNode $node */
        $node = dispatch_now(new TransformControlPanelNavigation());
        $buttons = $node->getAllDescendants()->sections()->map->getButtons()->flatten(1);
        return $buttons->filter(function($button){
            return $button instanceof Button;
        });
    }
}
