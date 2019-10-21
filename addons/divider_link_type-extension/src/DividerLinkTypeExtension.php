<?php namespace Pyro\DividerLinkTypeExtension;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Pyro\DividerLinkTypeExtension\Form\DividerLinkTypeFormBuilder;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;

class DividerLinkTypeExtension extends LinkTypeExtension
{

    /**
     * This extension provides the URL
     * link type for the Navigation module.
     *
     * @var string
     */
    protected $provides = 'pyro.module.menus::link_type.divider';

    /**
     * Return the entry URL.
     *
     * @param LinkInterface $link
     *
     * @return string
     */
    public function url(LinkInterface $link)
    {
        return '';
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
        return '';
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
        return app(DividerLinkTypeFormBuilder::class);
    }

    public function view()
    {
        return 'pyro.extension.divider_link_type::divider-link';
    }
}
