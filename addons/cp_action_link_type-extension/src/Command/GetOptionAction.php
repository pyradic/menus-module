<?php

namespace Pyro\CpActionLinkTypeExtension\Command;

use Illuminate\Support\NamespacedItemResolver;
use Pyro\AdminTheme\Command\GetControlPanelStructure;
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
        /** @var array $structure = \Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure::example() */
        $structure = dispatch_now(new GetRecursiveControlPanelStructure);
        $sections = $structure->pluck('children')->map->toArray()->flatten(1);
        $buttons = $sections->pluck('children')->map->toArray()->flatten(1);
        return $buttons; //$sections->merge($buttons);
    }
}
