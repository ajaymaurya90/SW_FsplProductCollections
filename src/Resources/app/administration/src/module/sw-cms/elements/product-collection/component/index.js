import template from './sw-cms-el-fspl-product-collections.html.twig';

Shopware.Component.register('sw-cms-el-fspl-product-collections', {
    template,

    props: {
        element: {
            type: Object,
            required: true
        }
    },

    created() {
        this.initElementConfig('fspl-product-collections');
    }
});