import Vue                   from 'vue';
import { VuePlugin }         from '@crvs/platform';
import { LabelMenuItemType } from './LabelMenuItemType';

export class LabelLinkTypeExtensionVuePlugin extends VuePlugin {

    private static __installed = false;

    public static install(_Vue: typeof Vue, opts: any = {}) {
        if ( this.__installed ) {
            return;
        }
        this.__installed = true;

        this.prefixAndRegisterComponents(_Vue, {
            LabelMenuItemType: async () => {
                let m = await import('./LabelMenuItemType');
                return m.LabelMenuItemType;
            },
            // LabelMenuItemType
        });


    }
}