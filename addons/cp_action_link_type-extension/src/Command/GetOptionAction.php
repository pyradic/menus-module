<?php

namespace Pyro\CpActionLinkTypeExtension\Command;


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
//        $resolver = resolve(NamespacedItemResolver::class);
//        [$nav, $section, $button] = $resolver->parseKey($this->key);
        /** @var array $structure = \Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure::example() */
//        $structure = dispatch_now(new GetRecursiveControlPanelStructure);
//        $sections = $structure->pluck('children')->map->toArray()->flatten(1);
//        if($button === null){
//            $sections->firstWhere()
//        }
//        $buttons = $sections->pluck('children')->map->toArray()->flatten(1);
//        $arr = $structure->toArray();

        return $this->getFlattened()->firstWhere('key', $this->key);
    }

    /** @return \Illuminate\Support\Collection */
    protected function getFlattened()
    {
        /** @var \Pyro\Platform\Ui\ControlPanel\ControlPanelStructure $structure */
        $structure = dispatch_now(new BuildControlPanelStructure());
        /** @var \Illuminate\Support\Collection $sections */
        $sections = $structure->pluck('children')->map->toArray()->flatten(1);
        /** @var \Illuminate\Support\Collection $buttons */
        $buttons = $sections->pluck('children')->map->toArray()->flatten(1);
        return $buttons; //$sections->merge($buttons);
    }
}
