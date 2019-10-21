<?php namespace Pyro\MenusModule\Link\Command;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Link\LinkCollection;


/**
 * Class SetParentRelations
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class SetParentRelations
{

    /**
     * The link collection.
     *
     * @var LinkCollection
     */
    protected $links;

    /**
     * Create a new SetParentRelations instance.
     *
     * @param LinkCollection $links
     */
    public function __construct(LinkCollection $links)
    {
        $this->links = $links;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        /* @var LinkInterface|EloquentModel $link */
        foreach ($this->links as $link) {

            /* @var LinkInterface $parent */
            if (($id = $link->getParentId()) && $parent = $this->links->find($id)) {
                $link->setRelation('parent', $parent);
            }
        }
    }
}
