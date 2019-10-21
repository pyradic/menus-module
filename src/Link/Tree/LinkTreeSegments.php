<?php namespace Pyro\MenusModule\Link\Tree;

use Anomaly\Streams\Platform\Support\Parser;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Translation\Translator;
use Pyro\MenusModule\Link\Command\ConvertStringToColorCode;
use Pyro\MenusModule\Link\Contract\LinkInterface;


/**
 * Class LinkTreeSegments
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class LinkTreeSegments
{
    use DispatchesJobs;

    /**
     * Handle the segments.
     *
     * @param LinkTreeBuilder $builder
     */
    public function handle(LinkTreeBuilder $builder)
    {
        $builder->setSegments(
            [
                'entry.title' => [
                    'href' => 'admin/menus/links/{request.route.parameters.menu}/edit/{entry.id}',
                    'attributes' => [
                        'data-type' => '{entry.type}'
                    ]
                ],
                [
                    'class' => 'py-me__tree-item-tag',
                    'value' => function (LinkInterface $entry, Translator $translator, Parser $parser) {

                        $type      = $entry->getType();
                        $title     = $translator->trans($type->getTitle());
                        $tooltip   = '';
                        $converted = $this->dispatchNow(new ConvertStringToColorCode($type->getTitle()));
                        $color     = $converted[ 'color' ];
                        $infoColor = $converted[ 'darker' ];
                        $html      = '<span class="small tag tag-success" data-toggle="tooltip" title="{tooltip}" style="padding-right:10px; background-color: {color};">{title}</span>';
                        $info      = $type->info($entry) ?: '';
                        if ($type->info($entry)) {
                            $html = '<span class="small info-tag tag tag-success" data-toggle="tooltip" title="{tooltip}" style="padding-right:10px; background-color: {infoColor}">{info}</span>' . $html;
                        }
                        return $parser->parse($html, compact('color', 'tooltip', 'title', 'info', 'infoColor'));
                    },
                ],
                [
                    'data-toggle' => 'tooltip',
                    'class'       => 'text-danger',
                    'value'       => '<i class="fa fa-external-link"></i>',
                    'attributes'  => [
                        'title' => 'module::message.external',
                    ],
                    'enabled'     => function (LinkInterface $entry) {
                        return $entry->getTarget() === '_blank';
                    },
                ],
                [
                    'data-toggle' => 'tooltip',
                    'class'       => 'text-muted',
                    'value'       => '<i class="fa fa-lock"></i>',
                    'attributes'  => [
                        'title' => 'module::message.restricted',
                    ],
                    'enabled'     => function (LinkInterface $entry) {

                        $roles = $entry->getAllowedRoles();

                        return ! $roles->isEmpty();
                    },
                ],
                [
                    'data-toggle' => 'tooltip',
                    'class'       => 'text-danger',
                    'value'       => '<i class="fa fa-chain-broken"></i>',
                    'attributes'  => [
                        'title' => 'module::message.broken',
                    ],
                    'enabled'     => function (LinkInterface $entry) {

                        $type = $entry->getType();

                        return ! $type->exists($entry);
                    },
                ],
            ]
        );
    }
}
