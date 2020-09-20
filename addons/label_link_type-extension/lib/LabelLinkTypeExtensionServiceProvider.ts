import { ServiceProvider }                 from '@crvs/platform';
import { MenuManager }                     from '@crvs/admin-theme';
import { LabelLinkTypeExtensionVuePlugin } from './LabelLinkTypeExtensionVuePlugin';


export class LabelLinkTypeExtensionServiceProvider extends ServiceProvider {
    public register() {
        this.vuePlugin(LabelLinkTypeExtensionVuePlugin);
    }

    public boot() {
        if ( this.app.isBound('menus') ) {
            const manager = this.app.get<MenuManager>('menus');
            manager.registerType('pyro.extension.label_link_type', 'py-label-menu-item-type');

        }
    }
}
