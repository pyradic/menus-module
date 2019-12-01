

export interface MenuType {
    name:string
    namespace:string
    description:string
    title:string
    slug:string
    color:string
    darkerColor:string
    lighterColor:string
}

export type MenuEditorMode = 'tree' | 'create' | 'edit' | 'hide'


export interface IMenu {
    description:string
    locale:string
    name:string
    slug:string
    children:IMenuItem[]

}

export interface IMenuItem {
    children:IMenuItem[]
    class?:string
    entry_id:number
    id:number
    parent_id?:number
    sort_order:number
    target:'_blank'|'_self'|'_parent'|'_top'
    title:string
    type:string
    url:string
    [key:string]:any

}