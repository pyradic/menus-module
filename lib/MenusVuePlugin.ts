import Vue from 'vue'
// import MenuEditor from './MenuEditor.vue'
// import MenuEditorForm from './MenuEditorForm.vue'
import { prefixAndRegisterComponents } from '@pyro/platform';

export { MenusVuePlugin }
export default class MenusVuePlugin {
    private static __installed = false

    public static install(_Vue: typeof Vue, opts: any = {}) {
        if ( this.__installed ) {
            return;
        }
        this.__installed = true

        prefixAndRegisterComponents(_Vue, {
            'menu-editor'     : () => import('./components/menu-editor/MenuEditor.vue'),
            'menu-editor-form': () => import('./components/menu-editor/MenuEditorForm.vue')
        })

        // prefixAndRegisterComponents(_Vue, {
        //     'menu-editor': () => import('./MenuEditor.vue'),
        //     'menu-editor-form': () => import('./MenuEditorForm.vue'),
        // })
    }
}