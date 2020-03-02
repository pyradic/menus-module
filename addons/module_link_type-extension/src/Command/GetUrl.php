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
        $action = dispatch_now(new GetOptionAction($this->entry->key));
        return $action ? $action->getUrl() : '';
    }
}
