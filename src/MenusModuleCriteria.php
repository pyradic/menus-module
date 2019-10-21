<?php namespace Pyro\MenusModule;

use Anomaly\Streams\Platform\Addon\Plugin\PluginCriteria;

/**
 * Class MenusModuleCriteria
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MenusModuleCriteria extends PluginCriteria
{
    protected $options = [
        'cache' => true
    ];

    /**
     * Set options for Bootstrap 4
     *
     * @return $this
     */
    public function bootstrap4()
    {
        $this->options['link_attributes_dropdown'] = ['data-toggle' => 'dropdown'];
        $this->options['child_list_class']         = 'dropdown-menu';
        $this->options['child_link_class']         = 'dropdown-item';
        $this->options['item_class']               = 'nav-item';
        $this->options['link_class']               = 'nav-link';
        $this->options['list_class']               = 'nav';
        $this->options['child_item_class']         = '';

        return $this;
    }

    /**
     * Set options for Bootstrap 3
     *
     * @return $this
     */
    public function bootstrap3()
    {
        $this->options['link_attributes_dropdown'] = ['data-toggle' => 'dropdown'];
        $this->options['list_class']               = 'nav navbar-nav';
        $this->options['child_list_class']         = 'dropdown-menu';

        return $this;
    }

    public function pyroAdmin()
    {
        $this->options['tag'] = 'el-menu';
        $this->options['item_tag'] = 'el-menu-item';
        $this->options['submenu_tag'] = 'el-submenu';
        $this->options['horizontal'] = true;
        $this->options['submenu_trigger'] = 'hover';
        $this->options['submenu_type'] = 'dropdown';
        $this->options['view'] = 'pyro.module.menus::admin_menu';

        return $this;
    }
}
