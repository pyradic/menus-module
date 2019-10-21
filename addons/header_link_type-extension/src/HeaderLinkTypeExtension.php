<?php

namespace Pyro\HeaderLinkTypeExtension;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Pyro\HeaderLinkTypeExtension\Form\HeaderLinkTypeFormBuilder;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;

class HeaderLinkTypeExtension extends LinkTypeExtension
{

    /**
     * This extension provides the URL
     * link type for the Navigation module.
     *
     * @var string
     */
    protected $provides = 'pyro.module.menus::link_type.header';

    /**
     * Return the entry URL.
     *
     * @param LinkInterface $link
     *
     * @return string
     */
    public function url(LinkInterface $link)
    {
        return 'javascript:;';
    }

    /**
     * Return the entry title.
     *
     * @param LinkInterface $link
     *
     * @return string
     */
    public function title(LinkInterface $link)
    {
        return $link->getEntry()->getTitle();
    }

    public function info(LinkInterface $link)
    {
        return $link->getEntry()->getAttribute('subtitle');
    }

    /**
     * Return the form builder for
     * the link type entry.
     *
     * @return FormBuilder
     */
    public function builder()
    {
        return app(HeaderLinkTypeFormBuilder::class);
    }

    public function view()
    {
        return 'pyro.extension.header_link_type::header-link';
    }
}
