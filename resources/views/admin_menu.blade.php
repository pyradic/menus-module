<?php /**
 * @var \Anomaly\Streams\Platform\Support\Collection                                                                   $options
 * @var Pyro\MenusModule\Link\LinkPresenter[]|\Pyro\MenusModule\Link\LinkModel[]|\Pyro\MenusModule\Link\LinkCollection $links
 * @var Pyro\MenusModule\Link\LinkPresenter|\Pyro\MenusModule\Link\LinkModel                                           $link
 * @var Pyro\MenusModule\Link\LinkPresenter|\Pyro\MenusModule\Link\LinkModel                                           $child
 */ ?>
<el-menu
    mode="horizontal"
>
        @each('pyro.module.menus::admin_links',$links->top(),'link')
</el-menu>
