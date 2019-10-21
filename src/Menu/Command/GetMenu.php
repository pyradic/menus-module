<?php namespace Pyro\MenusModule\Menu\Command;

use Anomaly\Streams\Platform\Support\Presenter;
use Pyro\MenusModule\Menu\Contract\MenuInterface;
use Pyro\MenusModule\Menu\Contract\MenuRepositoryInterface;


/**
 * Class GetMenu
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class GetMenu
{

    /**
     * The menu identifier.
     *
     * @var mixed
     */
    protected $identifier;

    /**
     * Create a new GetMenu instance.
     *
     * @param mixed $identifier
     */
    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Handle the command.
     *
     * @param  MenuRepositoryInterface $menus
     * @return MenuInterface|null
     */
    public function handle(MenuRepositoryInterface $menus)
    {
        if (is_numeric($this->identifier)) {
            return $menus->find($this->identifier);
        }

        if (is_string($this->identifier)) {
            return $menus->findBySlug($this->identifier);
        }

        if ($this->identifier instanceof Presenter) {
            return $this->identifier->getObject();
        }

        if (is_object($this->identifier)) {
            return $this->identifier;
        }

        return null;
    }
}
