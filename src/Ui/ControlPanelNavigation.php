<?php

namespace Pyro\MenusModule\Ui;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Pyro\MenusModule\Ui\Command\BuildFullControlPanelNavigation;

class ControlPanelNavigation
{
    use DispatchesJobs;

    protected $resolved;

    /**
     * @return \Illuminate\Support\Collection|\Pyro\MenusModule\Ui\ItemCollection|\Pyro\MenusModule\Ui\Item[]
     */
    public function resolve($force = false)
    {
        try {
            if ( ! $this->resolved) {
                $this->resolved = $this->dispatchNow(new BuildFullControlPanelNavigation());
            }
        }catch (\Throwable $e){
            return collect();
        }
        return $this->resolved;
    }
}
