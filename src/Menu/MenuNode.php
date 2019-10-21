<?php

namespace Pyro\MenusModule\Menu;

use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Link\LinkNode;
use Pyro\MenusModule\Link\LinkNodeCollection;
use Pyro\Platform\Ui\TreeNode\ModelNode;

/**
 * @method \Pyro\MenusModule\Menu\MenuModel|\Pyro\MenusModule\Menu\Contract\MenuInterface getValue()
 * @mixin \Pyro\MenusModule\Menu\MenuModel
 */
class MenuNode extends ModelNode
{
    protected $nodeClass = LinkNode::class;

    protected $collectionClass = LinkNodeCollection::class;

    protected $hidden = [ 'id', 'sort_order', 'created_at', 'created_by_id', 'updated_at', 'updated_by_id', 'deleted_at', 'menu_id', 'entry_type' ];

    /** @var LinkNodeCollection|LinkNode[] */
    private $nodes;

    public function setNodeClass($nodeClass)
    {
        $this->nodeClass = $nodeClass;
        return $this;
    }

    public function createNode(LinkInterface $link)
    {
        /** @var LinkNode $node */
        $this->nodes()->push($node = new $this->nodeClass($link));
        $node->setCollectionClass($this->collectionClass);
        $node->setRoot($this);
        return $node;
    }

    public function nodes()
    {
        if ($this->nodes === null) {
            $this->nodes = $this->newCollection();
        }
        return $this->nodes;
    }

}
