<?php

namespace Pyro\HeaderLinkTypeExtension;

use Anomaly\Streams\Platform\Model\HeaderLinkType\HeaderLinkTypeHeadersEntryModel;

class HeaderLinkTypeModel extends HeaderLinkTypeHeadersEntryModel
{

    /**
     * Eager load these relations.
     *
     * @var array
     */
    protected $with = [
        'translations',
    ];

    /**
     * Get the URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
