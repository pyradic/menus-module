import { ServiceProvider }                 from '@crvs/platform';
import { MenuManager }                        from '@pyro/admin-theme';
import { DisabledLinkTypeExtensionVuePlugin } from './DisabledLinkTypeExtensionVuePlugin';


export class DisabledLinkTypeExtensionServiceProvider extends ServiceProvider {
    public register() {
        // this.vuePlugin(DisabledLinkTypeExtensionVuePlugin);
    }

    public boot() {
        if ( this.app.isBound('menus') ) {
            const manager = this.app.get<MenuManager>('menus');
            manager.registerType('pyro.extension.disabled_link_type', 'py-default-menu-item-type');

        }
    }
}