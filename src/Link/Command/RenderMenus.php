<?php namespace Pyro\MenusModule\Link\Command;

use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Pyro\MenusModule\Menu\Command\GetMenu;

/**
 * Class RenderMenus
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class RenderMenus
{

    use DispatchesJobs;

    /**
     * The rendering options.
     *
     * @var Collection
     */
    protected $options;

    /**
     * Create a new RenderMenus instance.
     *
     * @param Collection $options
     */
    function __construct(Collection $options)
    {
        $this->options = $options;
    }

    /**
     * Handle the command.
     *
     * @param  Factory $view
     * @return null|string
     */
    public function handle(Factory $view)
    {
        $this->dispatch(new HandlePresets($this->options));

        $menu  = $this->dispatch(new GetMenu($this->options->get('menu')));
        $links = $this->dispatch(new GetLinks($this->options, $menu));

        return $view->make(
            $this->options->get('view', 'pyro.module.menus::links'),
            [
                'menu'    => $menu,
                'links'   => $links,
                'options' => $this->options,
            ]
        )->render();
    }
}
