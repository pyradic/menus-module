import { ServiceProvider } from '@pyro/platform';
import MenusVuePlugin from './MenusVuePlugin';


export class MenusModuleServiceProvider extends ServiceProvider {
    public register() {
        // this.app.instance('pyro.menus.types', PLATFORM_DATA.pyro.menus.types);
        // this.app.instance('pyro.menus.urls', PLATFORM_DATA.pyro.menus.urls);

        this.vuePlugin(MenusVuePlugin)
    }
}