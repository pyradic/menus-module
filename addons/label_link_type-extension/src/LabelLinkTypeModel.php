<?php

namespace Pyro\LabelLinkTypeExtension;

use Anomaly\Streams\Platform\Model\LabelLinkType\LabelLinkTypeLabelsEntryModel;

class LabelLinkTypeModel extends LabelLinkTypeLabelsEntryModel
{

    /**
     * Eager load these relations.
     *
     * @var array
     */
    protected $with = [
        'translations',
    ];
}
