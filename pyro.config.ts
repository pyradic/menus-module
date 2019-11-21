import { PyroBuilder } from '@pyro/webpack';


export function configure(builder: PyroBuilder) {
    builder.hooks.initialized.tap('@pyro/menus-module', builder => {
        const { wp } = builder

        // wp.module.rule('babel').exclude.add(/el-menu/)
        // wp.module.rule('el-menu').test(/\.(js|mjs|jsx)$/).include.add(/el-menu/);
        // wp.blocks.rules.babel(wp, {
        //     'presets': [ [ '@babel/env', { 'loose': true, 'modules': false, 'targets': { 'browsers': [ '> 1%', 'last 2 versions', 'not ie <= 8' ] } } ] ],
        //     'plugins': [ 'transform-vue-jsx' ],
        //     'env'    : {
        //         'utils': {
        //             'presets': [ [ '@babel/env', { 'loose': true, 'modules': 'commonjs', 'targets': { 'browsers': [ '> 1%', 'last 2 versions', 'not ie <= 8' ] } } ] ],
        //             'plugins': [ [ 'module-resolver', { 'root': [ 'element-ui' ], 'alias': { 'element-ui/src': 'element-ui/lib' } } ] ]
        //         }
        //     }
        // }, 'el-menu')
    })
}