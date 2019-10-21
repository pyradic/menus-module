<?php namespace Pyro\UrlLinkTypeExtension;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Pyro\UrlLinkTypeExtension\Command\GetUrl;
use Pyro\UrlLinkTypeExtension\Form\UrlLinkTypeFormBuilder;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;

/**
 * Class UrlLinkTypeExtension
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class UrlLinkTypeExtension extends LinkTypeExtension
{

    /**
     * This extension provides the URL
     * link type for the Navigation module.
     *
     * @var string
     */
    protected $provides = 'pyro.module.menus::link_type.url';

    /**
     * Return the entry URL.
     *
     * @param  LinkInterface $link
     * @return string
     */
    public function url(LinkInterface $link)
    {
        return url($this->dispatch(new GetUrl($link->getEntry())));
    }

    /**
     * Return the entry title.
     *
     * @param  LinkInterface $link
     * @return string
     */
    public function title(LinkInterface $link)
    {
        return $link->getEntry()->getTitle();
    }

    public function info(LinkInterface $link)
    {
        return $this->url($link);
    }

    /**
     * Return the form builder for
     * the link type entry.
     *
     * @return FormBuilder
     */
    public function builder()
    {
        return app(UrlLinkTypeFormBuilder::class);
    }
}
