<?php namespace Pyro\ModuleLinkTypeExtension\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Support\Parser;

class GetUrl
{

    /**
     * The URL entry.
     *
     * @var EntryInterface
     */
    protected $entry;

    protected static $resolvedEntries = [];

    /**
     * Create a new GetUrl instance.
     *
     * @param EntryInterface $entry
     */
    public function __construct(EntryInterface $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Handle the command.
     *
     * @param Parser $parser
     * @return string
     */
    public function handle(Parser $parser)
    {
        if(array_key_exists($this->entry->id, static::$resolvedEntries)){
            return static::$resolvedEntries[$this->entry->id];
        }
        $action = dispatch_now(new GetOptionAction($this->entry->key));
        return static::$resolvedEntries[$this->entry->id] = $action ? $action->getUrl() : '';
    }
}
