<?php namespace Pyro\MenusModule\Menu;

use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Pyro\MenusModule\Menu\Contract\MenuRepositoryInterface;

/**
 * Class MenuSeeder
 *
 * @link http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MenuSeeder extends Seeder
{

    /**
     * The menu repository.
     *
     * @var MenuRepositoryInterface
     */
    protected $menus;

    /**
     * Create a new MenuSeeder instance.
     *
     * @param $menus
     */
    public function __construct(MenuRepositoryInterface $menus)
    {
        parent::__construct();
        $this->menus = $menus;
    }

    /**
     * Run the seeder.
     */
    public function run()
    {
        $this->menus
            ->truncate()
            ->create([
                'en'   => [
                    'name'        => 'Footer',
                    'description' => 'This is the main footer menu.',
                ],
                'slug' => 'footer',
            ]);
        $this->menus->create([
            'en'   => [
                'name'        => 'Admin Header',
                'description' => 'The admin header menu',
            ],
            'slug' => 'admin_header',
        ]);
        $this->menus->create([
            'en'   => [
                'name'        => 'Admin Footer',
                'description' => 'This is admin footer menu.',
            ],
            'slug' => 'admin_footer',
        ]);
    }
}
