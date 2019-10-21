<?php namespace Pyro\MenusModule\Menu;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryObserver;
use Anomaly\Streams\Platform\Http\Command\ClearHttpCache;
use Pyro\MenusModule\Menu\Contract\MenuInterface;

/**
 * Class MenuObserver
 *
 * @link http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MenuObserver extends EntryObserver
{

    /**
     * Fired just after saving the entry.
     *
     * @param EntryInterface|MenuInterface $entry
     */
    public function saved(EntryInterface $entry)
    {
        $this->dispatch(new ClearHttpCache());

        return parent::saved($entry);
    }
}
