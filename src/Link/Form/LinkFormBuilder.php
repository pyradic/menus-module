<?php namespace Pyro\MenusModule\Link\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Pyro\MenusModule\Link\Contract\LinkInterface;
use Pyro\MenusModule\Menu\Contract\MenuInterface;
use Pyro\MenusModule\Type\LinkTypeExtension;

/**
 * Class LinkFormBuilder
 *
 * @link http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface getFormEntry()
 * @method \Pyro\MenusModule\Link\LinkModel getFormModelName()
 * @method \Pyro\MenusModule\Link\LinkModel getFormModel()
 */
class LinkFormBuilder extends FormBuilder
{

    /**
     * The related link type.
     *
     * @var null|LinkTypeExtension
     */
    protected $type;

    /**
     * The related menu.
     *
     * @var null|MenuInterface
     */
    protected $menu;

    /**
     * The parent link.
     *
     * @var null|LinkInterface
     */
    protected $parent;

    /**
     * The skipped fields.
     *
     * @var array
     */
    protected $skips = [
        'parent',
        'entry',
        'type',
        'menu',
    ];

    protected $fields = [
        '*',
        'allowed_roles' => [
            'config' => [
                'mode' => 'tags'
            ]
        ]
    ];

    /**
     * Fired when the builder is ready to build.
     *
     * @throws \Exception
     */
    public function onReady()
    {
        if ( ! $this->getType() && ! $this->getEntry()) {
            throw new \Exception('The $type parameter is required when creating a link.');
        }

        if ( ! $this->getMenu() && ! $this->getEntry()) {
            throw new \Exception('The $menu parameter is required when creating a link.');
        }

        $this->on('built', function(){
            $fields=$this->getFormFields();
            return;
        });
    }

    /**
     * Fired just before saving the entry.
     */
    public function onSaving()
    {
        $parent = $this->getParent();
        $entry  = $this->getFormEntry();

        if ( ! $entry->menu_id && $menu = $this->getMenu()) {
            $entry->menu_id = $menu->getId();
        }

        if ($type = $this->getType()) {
            $entry->type = $type->getNamespace();
        }

        if ($parent) {
            $entry->parent_id = $parent->getId();
        }
    }

    /**
     * Get the type.
     *
     * @return null|LinkTypeExtension
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type.
     *
     * @param LinkTypeExtension $type
     *
     * @return $this
     */
    public function setType(LinkTypeExtension $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the menu.
     *
     * @return MenuInterface|null
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set the menu.
     *
     * @param $menu
     *
     * @return $this
     */
    public function setMenu(MenuInterface $menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get the parent link.
     *
     * @return null|LinkInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the parent link.
     *
     * @param LinkInterface $parent
     *
     * @return $this
     */
    public function setParent(LinkInterface $parent)
    {
        $this->parent = $parent;

        return $this;
    }
}
