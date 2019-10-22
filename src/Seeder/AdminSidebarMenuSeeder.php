<?php

namespace Pyro\MenusModule\Seeder;

class AdminSidebarMenuSeeder  extends \Pyro\Platform\Database\Seeder
{
    public function run()
    {
        /** @var MenuModuleSeederHelper $helper */
        $helper = $this->helper(MenuModuleSeederHelper::class);
        $helper->menu('admin_sidebar')->truncate();
        $clients = $helper->label('anomaly.module.users::addon.section.users');

        $helper->module('anomaly.module.users::addon.section.users', [ 'link' => 'anomaly.module.users:users' ], [ 'parent_id' => $clients->getId() ]);
        $helper->module('anomaly.module.users::addon.section.roles', [ 'link' => 'anomaly.module.users:roles' ], [ 'parent_id' => $clients->getId() ]);
    }
}
