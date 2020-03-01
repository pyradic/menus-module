<?php

namespace Pyro\ModuleLinkTypeExtension\Command;

use Pyro\Platform\Ui\ControlPanel\Command\TransformControlPanelNavigation;

class GetActionOptions
{
    public function handle()
    {

        /** @var \Pyro\Platform\Ui\ControlPanel\Component\NavigationNode $node */
        $node    = dispatch_now(new TransformControlPanelNavigation());
        $options = [];
        foreach ($node->getChildren() as $nav) {
            $title             = trans($nav->getTitle());
            $options[ $title ] = [];
            foreach ($nav->getChildren() as $section) {
                $options[ $title ][ $section->getKey() ] = trans($section->getTitle());
            }
            if (count($options[ $title ]) === 0) {
                unset($options[ $title ]);
            }
        }
        return $options;
    }

    public function handle2()
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
            if (count($options[ $title ]) === 0) {
                unset($options[ $title ]);
            }
        }
        return $options;
    }
}
