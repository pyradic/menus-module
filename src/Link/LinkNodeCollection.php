<?php

namespace Pyro\MenusModule\Link;


use Pyro\Platform\Ui\TreeNode\NodeCollection;

class LinkNodeCollection extends NodeCollection
{
    /** @return LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] */
    public function getModels()
    {
        $models = $this->map->getModel();
        return new LinkCollection($models->all());
    }
}
