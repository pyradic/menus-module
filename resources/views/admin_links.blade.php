<?php /**
 * @var Pyro\MenusModule\Link\LinkPresenter|\Pyro\MenusModule\Link\LinkModel $link
 * @var Pyro\MenusModule\Link\LinkPresenter|\Pyro\MenusModule\Link\LinkModel $child
 */ ?>

@if($link->children->isNotEmpty())
    <el-submenu index="{{$link->id}}" href="{{ $link->url }}" class="{{$link->class}}">
        <template slot="title">{{$link->title}}</template>
        @each('pyro.module.menus::admin_links', $link->children, 'link')
    </el-submenu>
@else
    <el-menu-item index="{{$link->id}}" href="{{ $link->url }}" class="{{$link->class}}">
        <i class="{{$link->icon}}"></i>
        <span>{{$link->title}}</span>
    </el-menu-item>
@endif
