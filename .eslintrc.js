module.exports = {
    extends: 'eslint:recommended',
    env: {
        es6: true,
        node: true,
        browser: true,
        commonjs: true,
    },
    parserOptions: {
        ecmaVersion: 2019,
        sourceType: 'module',
        modules: true
    },
    rules: {
        indent: ['error', 2, {
            FunctionDeclaration: {
                parameters: 'first',
            },
            FunctionExpression: {
                parameters: 'first',
            },
            CallExpression: {
                arguments: 'first',
            }},
        ],
        camelcase: 0,
        quotes: ['error', 'single', {'allowTemplateLiterals': true, 'avoidEscape': true}],
        semi: ['error', 'always', {'omitLastInOneLineBlock': true}],
    },
};
