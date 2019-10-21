<?php

namespace Pyro\MenusModule\Ui\Command;

use Anomaly\Streams\Platform\View\Event\TemplateDataIsLoading;
use Pyro\MenusModule\Ui\ControlPanelNavigation;
use Pyro\MenusModule\Ui\Item;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Str;

class AddCPNavToTemplate
{
    public function handle(Dispatcher $dispatcher)
    {
        $dispatcher->listen(TemplateDataIsLoading::class, function (TemplateDataIsLoading $event) {
            $nav = resolve(ControlPanelNavigation::class)->resolve();
            $nav->each(function (Item $item) {
                $this->handleItem($item);
            });
            $event->getTemplate()->set('cp_nav', $nav);
        });
    }

    public function handleItem(Item $item)
    {
        if ( ! Str::startsWith($item->icon, 'fa')) {
            $item->icon = 'fa fa-' . $item->icon;
        }
        if (Str::contains($item->icon, 'glyphicon')) {
            $item->icon = str_replace('glyphicon', 'fa', $item->icon);
        }
        if ($item->hasChildren()) {
            $item->set('attributes.href', 'javascript:;');
            $item->href = 'javascript:;';
            $item->children->each(function (Item $child) {
                $this->handleItem($child);
            });
        }
    }

}
