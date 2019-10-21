<?php namespace Pyro\ModuleLinkTypeExtension;

use Anomaly\Streams\Platform\Model\ModuleLinkType\ModuleLinkTypeModulesEntryModel;

/**
 * Class ModuleLinkTypeModel
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class ModuleLinkTypeModel extends ModuleLinkTypeModulesEntryModel
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
