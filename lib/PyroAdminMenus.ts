import $ from 'jquery';
declare const log

interface FormPostResponse {
    redirect?: string
    success: boolean
    errors: Array<any>
}


export interface PyroAdminMenusConfig {
    class: string
    menuSlug: string
    fetchTreeUrl: string
    createFormUrl: string
    editFormUrl: string
    linkTypeTemplate: string
}

const defaultConfig: PyroAdminMenusConfig = {
    class           : 'menu-admin-ui',
    menuSlug        : '',
    fetchTreeUrl    : '',
    createFormUrl   : '',
    editFormUrl     : '',
    linkTypeTemplate: ''

}

export interface PyroAdminMenusRefs {
    tree: JQuery
    side: JQuery
    sideHeader: JQuery
    sideBody: JQuery
}

export class PyroAdminMenus {
    private $el: JQuery
    private refs: PyroAdminMenusRefs = <any>{
        get tree() { return $(`.${this.config.class}-tree`) },
        get side() { return $(`.${this.config.class}-side`) },
        get sideHeader() { return $(`.${this.config.class}-side-header`) },
        get sideBody() { return $(`.${this.config.class}-side-body`) },
    }

    constructor(selector: JQuery.Selector | JQuery.Node | JQuery, protected config: PyroAdminMenusConfig) {
        this.config          = {
            ...defaultConfig,
            ...config
        }
        this.$el             = $(selector as any)
        this.refs['config'] = this.config;
        window[ 'pyroAdminMenus' ] = this
        $.blockUI.defaults         = {
            ...$.blockUI.defaults

        }
        $.unblockUI.defaults       = {
            ...$.unblockUI.defaults
        }
    }


    setWidth(percent: number) {
        let builderWidth = percent;
        let sideWidth    = 100 - percent;
        this.refs.tree.css({ width: builderWidth + '%' })
        this.refs.side.css({ width: sideWidth + '%' })
        return this
    }

    async showTree() {
        const me       = this
        const response = await $.ajax(this.config.fetchTreeUrl);
        log('refreshTree')
        this.refs.tree.html(response);
        this.refs.tree.find('li .card > a').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            const $el = $(this);
            const id  = parseInt($el.closest('li[data-id]').data('id'));
            me.showEditForm(id)
        })
        return this
    }


    showLinkTypes() {
        const me       = this;
        const template = document.getElementById(this.config.linkTypeTemplate) as HTMLTemplateElement
        const cloned   = template.content.cloneNode(true);
        this.refs.sideBody.html('');
        this.refs.sideBody.append(cloned as any);
        this.refs.sideBody
            .find('.link-type-option')
            .on('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                const $link    = $(this);
                const linkType = $link.data('link-type');
                me.showCreateForm(linkType);
            })

        this.refs.sideHeader.text('Create a new link')
        this.setWidth(75)
        log('show link types', this)
        return this
    }

    block(ref: keyof PyroAdminMenusRefs) {
        this.refs[ ref ].block({})
        return this
    }

    unblock(ref: keyof PyroAdminMenusRefs) {
        this.refs[ ref ].unblock({})
        return this
    }

    async showCreateForm(linkType) {
        let url = this.config.createFormUrl + '/' + linkType;
        log('showCreateForm', { linkType, url, me: this })
        this.block('side')
        let response = await $.ajax(url, {});
        log('showCreateForm response')
        this.unblock('side')
        this._setupForm(response)
        return this
    }

    async showEditForm(id) {
        let url = this.config.editFormUrl + '/' + id;
        log('showEditForm', { id, url, me: this })
        this.block('side')
        let response = await $.ajax(url, {});
        log('showEditForm response')
        this.unblock('side')
        this._setupForm(response)
        return this
    }

    _setupForm(html) {
        const me = this;
        this.refs.sideBody.html(html)
        this.refs.sideHeader.text('Link Details')
        this.setWidth(45)
        let $form    = this.refs.sideBody.find('form');
        let $actions = $form.find('.form__actions')
        let $buttons = $form.find('.form__buttons')
        let action   = $form.attr('action')
        let method   = $form.attr('method')
        $actions.find('.btn').remove()
        $buttons.find('.btn').remove()

        let $submit = $('<button name="action" value="save" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> save</button>')
        let $cancel = $('<button name="cancel" value="cancel" type="button" class="btn btn-sm btn-default">Cancel</button>')

        $actions.append($submit)
        $buttons.append($cancel)

        $cancel.on('click', () => {
            this.showLinkTypes()
            this.showTree();
        })
        $form.on('submit', async function (event) {
            event.preventDefault();
            event.stopPropagation();
            me.block('side')
            let data: any    = {}
            const serialized = $form.serializeArray();
            serialized.forEach(item => data[ item.name ] = item.value)
            log('submitForm', data, this)
            const response = await $.ajax(action, { method, data, dataType: 'json' }) as FormPostResponse
            log('submitForm', { data, me: this })
            me.unblock('side')
            if ( response.success ) {
                log('onSuccess')
                me.showLinkTypes();
                return me.showTree()
            } else {
                let errors = Object.keys(response.errors).map(key => `<li>${response.errors[ key ]}</li>`).join('\n');
                me._showAlert(`<ul>${errors}</ul>`)
            }
            log('onError', response)
        })
        return this
    }

    _showAlert(content: string, type = 'danger') {
        this._hideAlert()
        let $alert = `<div class="alert alert-${type}">${content}</div>`;
        this.refs.sideBody.prepend($alert)
        return $alert;
    }

    _hideAlert() {
        this.refs.sideBody.find('.alert').remove();
        return this
    }

}


// $.fn.pyroAdminMenus = function (...params: any[]) {
//     let retVal;
//     this.each(function (index, element) {
//         const $el = $(element)
//         let pyroAdminMenus: PyroAdminMenus
//         if ( $el.data('pyrocmsAdminMenus') ) {
//             pyroAdminMenus = $el.data('pyrocmsAdminMenus')
//         } else {
//             pyroAdminMenus = new PyroAdminMenus($(element), params[ 0 ] as PyroAdminMenusConfig)
//         }
//         retVal = pyroAdminMenus
//         let config = params[0]
//         if ( typeof config === 'string' ) {
//             let methodName = params.shift();
//             retVal         = pyroAdminMenus[ methodName ].apply(pyroAdminMenus, params);
//         }
//     })
//     return retVal;
// }
