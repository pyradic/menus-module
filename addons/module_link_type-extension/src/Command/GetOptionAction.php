<?php

namespace Pyro\ModuleLinkTypeExtension\Command;

use Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure;

class GetOptionAction
{
    protected $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function handle()
    {
        return $this->getFlattened()->firstWhere('key', $this->key);
    }

    /** @return \Illuminate\Support\Collection */
    protected function getFlattened()
    {
        /** @var array $structure = \Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure::example() */
        $structure = dispatch_now(new GetRecursiveControlPanelStructure);
        $sections  = $structure->pluck('children')->map->toArray()->flatten(1);
//        $buttons   = $sections->pluck('children')->map->toArray()->flatten(1);
        return $sections; //$sections->merge($buttons);
    }
}
