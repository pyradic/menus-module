<?php

namespace Pyro\MenusModule\Seeder;

use Pyro\Platform\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    static $name = 'menus.admin';
    static $description = 'Creates header, sidebar and footer menus for admin';
    public function run()
    {
        $this->call(AdminHeaderMenuSeeder::class);
        $this->call(AdminSidebarMenuSeeder::class);
        $this->call(AdminFooterMenuSeeder::class);
    }
}
