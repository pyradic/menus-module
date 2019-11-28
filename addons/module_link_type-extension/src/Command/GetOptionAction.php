<?php

namespace Pyro\ModuleLinkTypeExtension\Command;

use Pyro\Platform\Ui\ControlPanel\Command\BuildControlPanelStructure;

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
        /** @var \Pyro\Platform\Ui\ControlPanel\ControlPanelStructure $structure */
        $structure = dispatch_now(new BuildControlPanelStructure());
        /** @var \Illuminate\Support\Collection $sections */
        $sections = $structure->pluck('children')->map->toArray()->flatten(1);
        return $sections; //$sections->merge($buttons);
    }
}
