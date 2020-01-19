<?php namespace Pyro\MenusModule\Type\Contract;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use League\Uri\Uri;
use Pyro\MenusModule\Link\Contract\LinkInterface;

interface LinkTypeInterface
{

    /**
     * Return the link URL.
     *
     * @param  LinkInterface $link
     * @return string
     */
    public function url(LinkInterface $link);

    /**
     * Return the link title.
     *
     * @param  LinkInterface $link
     * @return string
     */
    public function title(LinkInterface $link);

    /**
     * Return if the link exists or not.
     *
     * @param  LinkInterface $link
     * @return bool
     */
    public function exists(LinkInterface $link);

    /**
     * Return if the link is enabled or not.
     *
     * @param  LinkInterface $link
     * @return bool
     */
    public function enabled(LinkInterface $link);

    public function info(LinkInterface $link);

    /**
     * Return the form builder for
     * the link type entry.
     *
     * @return FormBuilder
     */
    public function builder();
}
