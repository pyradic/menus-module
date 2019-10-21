<?php

namespace Pyro\ModuleLinkTypeExtension;

use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Pyro\UrlLinkTypeExtension\UrlLinkTypeModel;
use Pyro\MenusModule\MenuModuleSeederHelper;

class ModuleLinkTypeExtensionSeeder extends Seeder
{
    public function run()
    {
        $helper = resolve(MenuModuleSeederHelper::class)->menu('footer');


        $helper->model(ModuleLinkTypeModel::class);
        $link   = $helper->createLink('Mod', [ 'link' => 'pyro.module.clients:types' ]);
        $first  = $helper->createLink('Mod First', [ 'link' => 'pyro.module.clients:types' ], [ 'parent_id' => $link->getId() ]);
        $second = $helper->createLink('Mod Second', [ 'link' => 'pyro.module.clients:types' ], [ 'parent_id' => $link->getId() ]);
        $third  = $helper->createLink('Mod Third', [ 'link' => 'pyro.module.clients:types' ], [ 'parent_id' => $link->getId() ]);


        $helper->model(UrlLinkTypeModel::class);

        $helper->createLink('Mod Child ', [ 'url' => 'http://pyrocms.com/' ], [ 'parent_id' => $link->getId() ]);
        $helper->createLink('Mod Child First', [ 'url' => 'http://pyrocms.com/' ], [ 'parent_id' => $first->getId() ]);
        $helper->createLink('Mod Child Second', [ 'url' => 'http://pyrocms.com/' ], [ 'parent_id' => $second->getId() ]);
        $helper->createLink('Mod Child Third', [ 'url' => 'http://pyrocms.com/' ], [ 'parent_id' => $third->getId() ]);
    }

}
