<?php namespace Pyro\MenusModule\Link;

use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Pyro\UrlLinkTypeExtension\UrlLinkTypeModel;
use Pyro\MenusModule\MenuModuleSeederHelper;

/**
 * \Pyro\MenusModule\Link\LinkSeeder
 *
 */
class LinkSeeder extends Seeder
{
    public function run()
    {
        $helper = resolve(MenuModuleSeederHelper::class)
            ->menu('footer')
            ->model(UrlLinkTypeModel::class);

        $link = $helper->createLink('First', [ 'url' => 'http://pyrocms.com/' ]);
        $helper->createLink('Firsts First', [ 'url' => 'http://pyrocms.com/' ], [ 'parent_id' => $link->getId() ]);
        $helper->createLink('Firsts Second', [ 'url' => 'http://pyrocms.com/' ], [ 'parent_id' => $link->getId() ]);
        $helper->createLink('Firsts Third', [ 'url' => 'http://pyrocms.com/' ], [ 'parent_id' => $link->getId() ]);
    }
}
