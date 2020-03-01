<?php

namespace Pyro\CpActionLinkTypeExtension\Command;

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
//                $title             = trans($nav[ 'title' ]) . ' > ' . trans($section[ 'title' ]);
                foreach ($section->getButtons() as $button) {
                    $options[ $title ][ $button->getKey() ] = trans($section->getTitle()) . ' > ' . trans($button->getTitle());
                }
            }
            if (count($options[ $title ]) === 0) {
                unset($options[ $title ]);
            }
        }
        return $options;
    }
}
