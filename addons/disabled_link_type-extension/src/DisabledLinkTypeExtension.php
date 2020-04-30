<?php namespace Pyro\DisabledLinkTypeExtension;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Pyro\DisabledLinkTypeExtension\Form\DisabledLinkTypeFormBuilder;
use Pyro\DividerLinkTypeExtension\Form\DividerLinkTypeFormBuilder;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;

class DisabledLinkTypeExtension extends LinkTypeExtension
{

    /**
     * This extension provides the URL
     * link type for the Navigation module.
     *
     * @var string
     */
    protected $provides = 'pyro.module.menus::link_type.disabled';

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
        return '';
    }

    /**
     * Return the form builder for
     * the link type entry.
     *
     * @return FormBuilder
     */
    public function builder()
    {
        return app(DisabledLinkTypeFormBuilder::class);
    }

}
