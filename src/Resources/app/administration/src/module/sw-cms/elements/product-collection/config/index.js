import template from './sw-cms-el-config-fspl-product-collections.html.twig';

Shopware.Component.register('sw-cms-el-config-fspl-product-collections', {
    template,

    props: {
        element: {
            type: Object,
            required: true
        }
    }
});


/*import template from './config.vue';

Shopware.Component.register('sw-cms-el-config-product-collection', {
    template
}); */