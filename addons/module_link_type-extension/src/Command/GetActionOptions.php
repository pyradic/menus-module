<?php

namespace Pyro\ModuleLinkTypeExtension\Command;

use Crvs\Platform\Ui\ControlPanel\Command\TransformControlPanelNavigation;

class GetActionOptions
{
    public function handle()
    {
        /** @var \Crvs\Platform\Ui\ControlPanel\Component\NavigationNode $node */
        $node    = dispatch_now(new TransformControlPanelNavigation());
        $options = [];
        foreach ($node->getChildren() as $nav) {
            $title             = trans($nav->getTitle());
            $options[ $title ] = [];
            foreach ($nav->getChildren() as $section) {
                $options[ $title ][ $section->getKey() ] = $title . ' :: ' . trans($section->getTitle());

                foreach ($section->getButtons() as $button) {
                    $options[ $title ][ $button->getKey() ] = $title . ' :: ' . trans($section->getTitle()) . ' > ' . trans($button->getTitle());
                }
                if ($section->hasChildren()) {
                    foreach ($section->getChildren() as $child) {
                        $options[ $title ][ $child->getKey() ] = $title . ' :: ' . trans($section->getTitle()) . ' :: ' . trans($child->getTitle());

                        foreach ($child->getButtons() as $button) {
                            $options[ $title ][ $button->getKey() ] = $title . ' :: ' . trans($section->getTitle()) . ' :: ' . trans($child->getTitle()) . ' > ' . trans($button->getTitle());
                        }
                    }
                } else {
                    $options[ $title ][ $section->getKey() ] = $title . ' :: ' . trans($section->getTitle());
                }
            }
            if (count($options[ $title ]) === 0) {
                unset($options[ $title ]);
            }
        }
        return $options;
    }
}
