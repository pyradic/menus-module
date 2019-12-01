<style lang="scss">
@import "../../base";


.#{$menu-editor-prefix}-type-list {
    $self: &;
    &__item {

    }

    &__link {
        border-left : 3px solid transparent;

        &:hover {
            /*border-left-color: rgb(89, 98, 62);*/
            #{$self}__description {
                display: block;
            }
            #{$self}__title {
                box-shadow: none;
            }
        }
    }

    &__title {
        background-color : rgb(64, 91, 179);
        font-size        : 11px;
        padding          : 5px 10px;
        text-shadow      : 1px 1px 0px #3D3D3DE3;
        /* height: 17px; */
        font-weight      : 500;
        line-height      : 1;
        color            : #FFFFFF;
        text-align       : start;
        white-space      : nowrap;
        text-transform   : uppercase;
        /* margin-left: -10px; */
        display          : inline-block;
        width            : 100%;
        box-shadow       : 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    &__description {
        padding: 10px 5px 2px 5px;
        font-size : 12px;
    }
}
</style>
<template>
    <ul :class="classes" :style="style">
        <slot name="type_list">
            <li v-for="(type, typeIndex) in types"
                class="nav-item"
                :class="e('item',type)"
            >
                <a
                        href="javascript: void(0);"
                        @click="onTypeClick(type)"
                        :data-link-type="type.namespace"
                        class="nav-link link-type-option"
                        :class="e('link',type)"
                >
                    <div :class="e('title',type)" :style="{ backgroundColor: type.color }">{{ type.title }}</div>
                    <div :class="e('description',type)">{{ type.description }}</div>
                </a>
            </li>
        </slot>
    </ul>
</template>
<script lang="ts">
import { Component, component, prop, Styles } from '@pyro/platform';
import { MenuType } from '../../interfaces';
import { style } from 'typestyle'

@component()
export default class MenuEditorTypeList extends Component {
    @prop.classPrefix('me-type-list') classPrefix: string

    get classes() {
        return {
            [ this.classPrefix ]: true,
            'nav'               : true,
            'nav-pills'         : true,
            'nav-stacked'       : true
        }
    }

    get style(): Styles {
        return {}
    }

    get types(): MenuType[] {return Object.values(this.$py.data.get('pyro.menus.types'))}

    get styles(): Record<string, (type: MenuType) => string> {
        return {
            'item'       : type => style({}),
            'link'       : type => style({
                $nest: {
                    '&:hover': {
                        borderLeftColor: type.color
                    }
                }
            }),
            'title'      : type => style({}),
            'description': type => style({})
        }
    }

    e(name, type?: MenuType) {
        let cls = `${this.classPrefix}__${name}`;
        if ( name in this.styles ) {
            cls += ' ' + this.styles[ name ](type)
        }
        return cls;
    }

    onTypeClick(type: MenuType) {
        this.$emit('click', type)
    }
}
</script>