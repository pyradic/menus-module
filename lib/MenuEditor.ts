// import Vue from 'vue'
// import { component } from '@pyro/platform';
// import { Aside, Container, Main } from 'element-ui'
// import { MenuEditorMode, MenuType } from './interfaces';
// import $ from 'jquery';
//
//
// export interface MenuEditorHideables {
//     tree: boolean
//     form: boolean
//     side: boolean
// }
//
//
// @component({
//     components: {
//         'ElContainer': Container,
//         'ElAside'    : Aside,
//         'ElMain'     : Main
//     }
// })
// export default class MenuEditor extends Vue {
//     $refs: { side: Aside, tree: Container }
//     types                     = []
//     hide: MenuEditorHideables = {
//         tree: false,
//         form: true,
//         side: false
//     }
//     urls: Record<string, string>
//     mode: MenuEditorMode      = 'tree'
//
//     get sideWidth() {
//         return this.mode === 'tree' ? '25%' : '50%'
//     }
//
//     created() {
//         window[ '$menu' ] = this;
//         this.types        = this.$py.app.get('pyro.menus.types')
//         this.urls         = this.$py.app.get('pyro.menus.urls')
//     }
//
//     show(key: keyof MenuEditorHideables, value?: boolean) {
//         if ( value === undefined ) {
//
//         }
//         this.hide[ key ]
//     }
//
//
//     handleMenuTypeClick(type: MenuType) {
//         this.$log('handleMenuTypeClick', type)
//         if(this.mode !== 'tree'){
//             return;
//         }
//         this.mode = 'create'
//     }
//
//
//     async getCreateForm(type: string) {
//         const form = await this.$http.get(this.urls.create + '/' + type)
//         this.$log('getCreateForm', form, this.urls)
//         this.createFormHtml = form.data
//         this.mode = 'create';
//         return this.bindCreateForm()
//     }
//
//     async bindCreateForm(){
//         if($(this.$refs.side.$el).find('form').length === 0){
//             return setTimeout(() => this.bindCreateForm(), 100);
//         }
//         let $form       = $(this.$refs.side.$el).find('form');
//         let $actions    = $form.find('.form__actions')
//         let $buttons    = $form.find('.form__buttons')
//         let action      = $form.attr('action')
//         let method: any = $form.attr('method')
//         $actions.find('.btn').remove()
//         $buttons.find('.btn').remove()
//
//         let $submit = $('<button name="action" value="save" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> savee</button>')
//         let $cancel = $('<button name="cancel" value="cancel" type="button" class="btn btn-sm btn-default">Cancele</button>')
//
//         $actions.append($submit)
//         $buttons.append($cancel)
//
//         this.$log('getCreateForm', { $form, $actions, $buttons, action, method })
//
//         $cancel.on('click', () => {
//             // this.showLinkTypes();
//             // this.showTree();
//         })
//         $form.on('submit', async (event) => {
//             event.preventDefault();
//             event.stopPropagation();
//             // me.block('side')
//             let data: any    = {}
//             const serialized = $form.serializeArray();
//             serialized.forEach(item => data[ item.name ] = item.value)
//             this.$log('submitForm', data, this)
//             const response = await this.$http.request({ method, data, responseType: 'json', url: action })
//             this.$log('submitForm', { data, me: this })
//             // me.unblock('side')
//             if ( response.status === 200 ) {
//                 this.$log('onSuccess')
//                 // this.showLinkTypes();
//                 // return me.showTree()
//             } else {
//                 // let errors = Object.keys(response.errors).map(key => `<li>${response.errors[ key ]}</li>`).join('\n');
//                 // me._showAlert(`<ul>${errors}</ul>`)
//             }
//             this.$log('onError', response)
//         });
//
//     }
//
// }