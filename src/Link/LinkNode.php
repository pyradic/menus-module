<?php

namespace Pyro\MenusModule\Link;

use Crvs\Platform\Ui\TreeNode\ModelNode;

/**
 * @method \Pyro\MenusModule\Link\LinkModel|\Pyro\MenusModule\Link\Contract\LinkInterface|\Pyro\MenusModule\Link\LinkPresenter getValue()
 * @method \Pyro\MenusModule\Link\LinkNodeCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[]|\Pyro\MenusModule\Link\LinkPresenter[] getChildren()
 * @mixin \Pyro\MenusModule\Link\LinkModel
 */
class LinkNode extends ModelNode
{
    protected $collectionClass = LinkNodeCollection::class;
    protected $hidden = [ 'created_at', 'created_by_id', 'updated_at', 'updated_by_id', 'deleted_at', 'menu_id', 'entry_type' ];


}
