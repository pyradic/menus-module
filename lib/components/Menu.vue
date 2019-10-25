<template>
    <el-menu ref="menu" :class="classes" :style="style">
        <template v-for="(item, index) in data.children">
            <el-menu-item></el-menu-item>
        </template>
    </el-menu>
</template>
<script lang="ts">
    import { component, prop, Styles } from '@pyro/platform';
    import Vue from 'vue';
    import { IMenu } from '../interfaces';
    import { Menu as ElMenu } from 'element-ui'

    @component()
    export default class Menu extends Vue {
        $refs: { menu: ElMenu }
        @prop.classPrefix('menu') classPrefix: string
        @prop.object() data: IMenu

        get menu(): ElMenu { return this.$refs.menu; }

        get classes() {
            return {
                [ this.classPrefix ]                        : true,
                [ `${this.classPrefix}--${this.data.slug}` ]: true
            }
        }

        get style(): Styles {
            return {}
        }

        created() {
            this.$log('created', this)
        }

        mounted() {
            this.$log('mounted', this)
        }

    }
</script>