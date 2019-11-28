<?php

namespace Pyro\ModuleLinkTypeExtension\Handler;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Pyro\ModuleLinkTypeExtension\Command\GetActionOptions;

class AddonFieldOptionsHandler
{
    public function handle(FieldType $fieldType)
    {
        $options = dispatch_now(new GetActionOptions());
        $fieldType->setOptions($options);
    }
}
