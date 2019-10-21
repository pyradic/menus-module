<?php namespace Pyro\MenusModule\Link\Command;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Link\LinkCollection;


/**
 * Class SetChildrenRelations
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class SetChildrenRelations
{

    /**
     * The link collection.
     *
     * @var LinkCollection
     */
    protected $links;

    /**
     * Create a new SetChildrenRelations instance.
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
            $link->setRelation('children', $this->links->children($link));
        }
    }
}
