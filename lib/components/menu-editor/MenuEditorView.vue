<template>
    <py-menu-editor :class="classes" :style="style" compact>
        <template slot="tree">
            <slot name="tree"/>
        </template>
    </py-menu-editor>
</template>
<script lang="ts">
import { Component, component, prop, Styles } from '@pyro/platform';

@component()
export default class MenuEditorView extends Component {
    @prop.classPrefix('menu-editor-view') classPrefix: string

    get classes() {
        return {
            [ this.classPrefix ]: true
        }
    }

    get style(): Styles {
        return {}
    }
}
</script>