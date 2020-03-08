import { ServiceProvider } from '@pyro/platform';
import { MenuManager }     from '@pyro/admin-theme';


export class UrlLinkTypeExtensionServiceProvider extends ServiceProvider {
    public boot() {
        if(this.app.isBound('menus')) {
            const manager = this.app.get<MenuManager>('menus');
            manager.registerType('pyro.extension.url_link_type', 'py-default-menu-item-type');
        }
    }
}