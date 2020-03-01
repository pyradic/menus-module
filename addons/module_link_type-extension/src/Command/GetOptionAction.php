<?php

namespace Pyro\ModuleLinkTypeExtension\Command;

use Pyro\Platform\Ui\ControlPanel\Command\BuildControlPanelStructure;
use Pyro\Platform\Ui\ControlPanel\Command\TransformControlPanelNavigation;

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
                return $node->getValue();
            }
        }
//        return $this->getFlattened()->firstWhere('key', $this->key);
    }

    /** @return \Illuminate\Support\Collection */
    protected function getFlattened()
    {
        /** @var \Pyro\Platform\Ui\ControlPanel\Component\NavigationNode $node */
        $node = dispatch_now(new TransformControlPanelNavigation());
        /** @var \Illuminate\Support\Collection $sections */
        $sections = $node->getChildren()->map->getChildren()->flatten(1);
        return $sections; //$sections->merge($buttons);
    }
}
