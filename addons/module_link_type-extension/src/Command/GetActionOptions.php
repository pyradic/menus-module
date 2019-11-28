<?php

namespace Pyro\ModuleLinkTypeExtension\Command;

use Pyro\Platform\Ui\ControlPanel\Command\BuildControlPanelStructure;

class GetActionOptions
{
    public function handle()
    {
        /** @var array $structure = \Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure::example() */
        $structure = dispatch_now(new BuildControlPanelStructure());
        $options   = [];
        foreach ($structure as $nav) {
            $title             = $nav[ 'title' ];
            $options[ $title ] = [];
            foreach ($nav[ 'children' ] as $section) {
                $options[ $title ][ $section[ 'key' ] ] = $section[ 'title' ];
            }
            if(count($options[ $title ]) === 0){
                unset($options[ $title ]);
            }
        }
        return $options;
    }
}
