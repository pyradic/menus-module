<?php namespace Pyro\MenusModule\Link;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryObserver;
use Anomaly\Streams\Platform\Http\Command\ClearHttpCache;
use Pyro\MenusModule\Link\Contract\LinkInterface;

/**
 * \Pyro\MenusModule\Link\LinkObserver
 *
 */
class LinkObserver extends EntryObserver
{

    /**
     * Fired just after saving the entry.
     *
     * @param EntryInterface|LinkInterface $entry
     */
    public function saved(EntryInterface $entry)
    {
        $this->dispatch(new ClearHttpCache());

        return parent::saved($entry);
    }

}
