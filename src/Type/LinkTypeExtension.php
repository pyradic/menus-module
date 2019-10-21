<?php namespace Pyro\MenusModule\Type;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Link\Contract\LinkRepositoryInterface;
use Pyro\MenusModule\Type\Contract\LinkTypeInterface;

/**
 * Class LinkTypeExtension
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class LinkTypeExtension extends Extension implements LinkTypeInterface
{

    /**
     * Return the link URL.
     *
     * @param LinkInterface $link
     *
     * @return string
     */
    public function url(LinkInterface $link)
    {
        return null;
    }

    /**
     * Return the link title.
     *
     * @param LinkInterface $link
     *
     * @return string
     */
    public function title(LinkInterface $link)
    {
        return null;
    }

    /**
     * Return if the link exists or not.
     *
     * @param LinkInterface $link
     *
     * @return bool
     */
    public function exists(LinkInterface $link)
    {
        return true;
    }

    /**
     * Return if the link is enabled or not.
     *
     * @param LinkInterface $link
     *
     * @return bool
     */
    public function enabled(LinkInterface $link)
    {
        return true;
    }

    public function info(LinkInterface $link)
    {
        return false;
    }


    public function view()
    {
        return null;
    }

    /**
     * Return the form builder for
     * the link type entry.
     *
     * @return FormBuilder
     */
    public function builder()
    {
        return null;
    }

    public function onUninstalling(LinkTypeExtension $extension, LinkRepositoryInterface $links)
    {
        /** @var \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] $all */
        $all = $links->findAllBy('type', $extension->getNamespace());

        foreach ($all as $link) {
            $link->isEnabled();
        }

        $ids         = $all->pluck('id')->toArray();
        $childIds    = [];
        $resultIds   = $ids;
        $resultCount = 1;
        while ($resultCount > 0) {
            $result      = $links->newQuery()->whereIn('parent_id', $resultIds)->get()->pluck('id');
            $resultIds   = $result->toArray();
            $resultCount = $result->count();
            $result->call('array_push', [ &$childIds ], false);
        }
        $deleteIds = array_unique(array_merge($ids, $childIds));
        $links->findAll($deleteIds)->each([ $links, 'delete' ]);
    }
}
