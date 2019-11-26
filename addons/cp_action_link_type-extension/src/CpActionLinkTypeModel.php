<?php namespace Pyro\CpActionLinkTypeExtension;

use Anomaly\Streams\Platform\Model\CpActionLinkType\CpActionLinkTypeCpActionEntryModel;

/**
 * Class ModuleLinkTypeModel
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class CpActionLinkTypeModel extends CpActionLinkTypeCpActionEntryModel
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
