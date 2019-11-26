<?php

namespace Pyro\CpActionLinkTypeExtension\Command;

use Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure;

class GetActionOptions
{
    public function handle()
    {
        /** @var array $structure = \Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure::example() */
        $structure = dispatch_now(new GetRecursiveControlPanelStructure);
        $options   = [];
        foreach ($structure as $nav) {
            foreach ($nav[ 'children' ] as $section) {
                $title             = $nav[ 'title' ] . ' > ' . $section[ 'title' ];
                $options[ $title ] = [];
                foreach ($section[ 'children' ] as $button) {
                    $options[ $title ][ $button[ 'key' ] ] = $button[ 'title' ];
                }
                if(count($options[ $title ]) === 0){
                    unset($options[ $title ]);
                }
            }
        }
        return $options;
    }
}
