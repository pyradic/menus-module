<?php namespace Pyro\MenusModule\Link;

use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Support\Decorator;
use Pyro\MenusModule\Link\Contract\LinkInterface;

/**
 * \Pyro\MenusModule\Link\LinkPresenter
 *
 * @property \Pyro\MenusModule\Link\LinkModel $object
 * @method \Pyro\MenusModule\Link\LinkModel getObject()
 * @mixin \Pyro\MenusModule\Link\LinkModel
 * @property \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter $menu
 * @property \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter $type
 * @property \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter $entry
 * @property \Anomaly\SelectFieldType\SelectFieldTypePresenter $target
 * @property \Anomaly\TextFieldType\TextFieldTypePresenter $class
 * @property \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter $parent
 * @property \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter $allowed_roles
 * @property \Anomaly\IconFieldType\IconFieldTypePresenter $icon
 * @property \Anomaly\TextFieldType\TextFieldTypePresenter $hash
 * @property \Anomaly\TextFieldType\TextFieldTypePresenter $querystring
 */
class LinkPresenter extends EntryPresenter
{

    /**
     * The decorated object.
     * This is for IDE hinting.
     *
     * @var LinkInterface
     */
    protected $object;

    /**
     * Return the edit link.
     *
     * @return string
     */
    public function editLink()
    {
        return app('html')->link(
            implode(
                '/',
                array_filter(
                    [
                        'admin',
                        $this->object->getStreamNamespace(),
                        $this->object->getStreamSlug(),
                        $this->object->getMenuSlug(),
                        'edit',
                        $this->object->getId(),
                    ]
                )
            ),
            $this->object->getTitle()
        );
    }

    /**
     * Return the related children.
     *
     * @return LinkCollection
     */
    public function children()
    {
        return (new Decorator())->decorate($this->object->getChildren());
    }

    public function view()
    {
        return $this->object->getType()->view();
    }

    /**
     * Return the string output.
     *
     * @return string
     */
    public function __toString()
    {
        $classes = [];

        if ($this->object->isActive()) {
            $classes[] = 'active';
        }

        if ($this->object->isCurrent()) {
            $classes[] = 'current';
        }

        return (string)app('html')->link(
            $this->object->getUrl(),
            $this->object->getTitle(),
            [
                'class' => implode(' ', array_filter($classes)),
            ]
        );
    }

}
