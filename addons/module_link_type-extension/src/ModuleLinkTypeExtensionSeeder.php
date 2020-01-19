<?php

namespace Pyro\ModuleLinkTypeExtension;

use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Pyro\MenusModule\MenuModuleSeederHelper;
use Pyro\UrlLinkTypeExtension\UrlLinkTypeModel;

class ModuleLinkTypeExtensionSeeder extends Seeder
{
    public function run()
    {
        $helper = resolve(MenuModuleSeederHelper::class)->menu('footer');


        $helper->model(ModuleLinkTypeModel::class);
        $link   = $helper->createLink('Mod', [ 'key' => 'pyro_module_clients::types' ]);
        $first  = $helper->createLink('Mod First', [ 'key' => 'pyro_module_clients::types' ], [ 'parent_id' => $link->getId() ]);
        $second = $helper->createLink('Mod Second', [ 'key' => 'pyro_module_clients::types' ], [ 'parent_id' => $link->getId() ]);
        $third  = $helper->createLink('Mod Third', [ 'key' => 'pyro_module_clients::types' ], [ 'parent_id' => $link->getId() ]);


        $helper->model(UrlLinkTypeModel::class);

        $helper->createLink('Mod Child ', [ 'url' => 'http://pyrocms.com/' ], [ 'parent_id' => $link->getId() ]);
        $helper->createLink('Mod Child First', [ 'url' => 'http://pyrocms.com/' ], [ 'parent_id' => $first->getId() ]);
        $helper->createLink('Mod Child Second', [ 'url' => 'http://pyrocms.com/' ], [ 'parent_id' => $second->getId() ]);
        $helper->createLink('Mod Child Third', [ 'url' => 'http://pyrocms.com/' ], [ 'parent_id' => $third->getId() ]);
    }

}
