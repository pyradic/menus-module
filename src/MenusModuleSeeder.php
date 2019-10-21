<?php namespace Pyro\MenusModule;

use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Pyro\MenusModule\Link\LinkSeeder;
use Pyro\MenusModule\Menu\MenuSeeder;

/**
 * Class MenusModuleSeeder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class MenusModuleSeeder extends Seeder
{

    /**
     * Run the seeder.
     */
    public function run()
    {
        $this->call(MenuSeeder::class);
        $this->call(LinkSeeder::class);
    }
}
