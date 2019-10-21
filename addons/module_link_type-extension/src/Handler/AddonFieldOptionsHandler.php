<?php

namespace Pyro\ModuleLinkTypeExtension\Handler;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Pyro\MenusModule\Ui\ControlPanelNavigation;

class AddonFieldOptionsHandler
{
    public function handle(FieldType $fieldType, ControlPanelNavigation $navigation)
    {
        $options = [];
        $links   = $navigation->resolve();
        foreach ($links as $link) {
            $options[ $link->title ] = [];
            foreach ($link[ 'children' ] as $child) {
                $options[ $link->title ][ $link->slug . ':' . $child->slug ] = $child->title;
            }
        }

        $fieldType->setOptions($options);
        return [];
    }
}
