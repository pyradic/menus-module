<?php namespace Pyro\MenusModule\Link\Tree;

use Anomaly\Streams\Platform\Support\Parser;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;
use Pyro\MenusModule\Link\Command\ConvertStringToColors;
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
                    'href'       => 'admin/menus/links/{request.route.parameters.menu}/edit/{entry.id}',
                    'attributes' => [
                        'data-type' => '{entry.type}',
                    ],
                ],
                [
                    'class' => 'py-me__tree-item-tag',
                    'value' => function (LinkInterface $entry, Translator $translator, Parser $parser) {

                        $type    = $entry->getType();
                        $title   = $translator->trans($type->getTitle());
                        $ancronym   = Str::ancronym($title);
                        $tooltip = '';
                        /** @var array $converted = \Pyro\MenusModule\Link\Command\ConvertStringToColors::returnCompletion() */
                        $converted    = $this->dispatchNow(new ConvertStringToColors($type->getTitle(), $type->color()));
                        $color        = $converted[ 'color' ];
                        $darkerColor  = $converted[ 'darker' ];
                        $lighterColor = $converted[ 'lighter' ];
                        $html         = '<span class="small tag tag-success" data-toggle="tooltip" title="{tooltip}" style="padding-right:10px; background-color: {color};">{ancronym}</span>';
                        $info         = $type->info($entry) ?: '';
                        if ($type->info($entry)) {
                            $html = '<span class="small info-tag tag tag-success" data-toggle="tooltip" title="{tooltip}" style="padding-right:10px; background-color: {lighterColor}">{info}</span>' . $html;
                        }
                        return $parser->parse($html, compact('color', 'tooltip', 'title', 'info', 'darkerColor', 'lighterColor','ancronym'));
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
