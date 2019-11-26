<?php

namespace Pyro\CpActionLinkTypeExtension\Handler;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Pyro\CpActionLinkTypeExtension\Command\GetActionOptions;

class AddonFieldOptionsHandler
{
    public function handle(FieldType $fieldType)
    {
        $options = dispatch_now(new GetActionOptions());
        $fieldType->setOptions($options);
        return [];
    }
}
