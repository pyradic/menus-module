<?php

namespace Pyro\MenusModule\Menu\Command;


use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Pyro\MenusModule\Link\Command\GetLinks;
use Pyro\MenusModule\Link\LinkCollection;
use Pyro\MenusModule\Menu\MenuNode;
use Pyro\Platform\TreeNode\NodeInterface;

class BuildMenuNode
{
    use DispatchesJobs;
    /** @var \Pyro\MenusModule\Menu\MenuNode */
    protected $menuNode;
    /** @var \Pyro\MenusModule\Link\LinkCollection */
    protected $links;

    public function __construct(MenuNode $menuNode, ?LinkCollection $links = null)
    {
        $this->menuNode = $menuNode;
        $this->links    = $links;
    }

    public function handle(Collection $options)
    {
        $this->links = $this->dispatchNow(new GetLinks($options, $this->menuNode->getModel()));
        $this->recurse($this->links->top(), $this->menuNode);
    }

    protected function recurse($links, ?NodeInterface $parent = null)
    {
        foreach ($links as $link) {
            $node = $this->menuNode->createNode($link);
            if ($parent !== null) {
                $parent->addChild($node);
            }
            $children = $this->links->children($link);
            if ($children !== null && $children->isNotEmpty()) {
                $this->recurse($children, $node);
            }
        }
    }
}
