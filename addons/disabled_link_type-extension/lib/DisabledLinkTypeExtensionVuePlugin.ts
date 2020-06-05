import Vue                   from 'vue';
import { VuePlugin }            from '@crvs/platform';
import { DisabledMenuItemType } from './DisabledMenuItemType';

export class DisabledLinkTypeExtensionVuePlugin extends VuePlugin {

    private static __installed = false;

    public static install(_Vue: typeof Vue, opts: any = {}) {
        if ( this.__installed ) {
            return;
        }
        this.__installed = true;

        this.prefixAndRegisterComponents(_Vue, {
            DisabledMenuItemType: async () => {
                let m = await import('./DisabledMenuItemType');
                return m.DisabledMenuItemType;
            },
            // DisabledMenuItemType
        });


    }
}