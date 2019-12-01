<?php

namespace Pyro\CpActionLinkTypeExtension\Command;

use Pyro\Platform\Ui\ControlPanel\Command\BuildControlPanelStructure;

class GetActionOptions
{
    public function handle()
    {
        /** @var array $structure = \Pyro\AdminTheme\Command\GetRecursiveControlPanelStructure::example() */
        $structure = dispatch_now(new BuildControlPanelStructure());
        $options   = [];
        foreach ($structure as $nav) {
            $title             = trans($nav[ 'title' ]);
            $options[ $title ] = [];
            foreach ($nav[ 'children' ] as $section) {
//                $title             = trans($nav[ 'title' ]) . ' > ' . trans($section[ 'title' ]);
                foreach ($section[ 'children' ] as $button) {
                    $options[ $title ][ $button[ 'key' ] ] = trans($section[ 'title' ]) . ' > ' . trans($button[ 'title' ]);
                }
            }
            if(count($options[ $title ]) === 0){
                unset($options[ $title ]);
            }
        }
        return $options;
    }
}
