import template from './sw-cms-el-config-fspl-product-collections.html.twig';

Shopware.Component.register('sw-cms-el-config-fspl-product-collections', {
    template,

    props: {
        element: {
            type: Object,
            required: true
        }
    },

    computed: {
        collectionTypeOptions() {
            return [
                { value: 'new_arrivals', label: 'New arrivals' },
                { value: 'trending', label: 'Trending products' },
                { value: 'featured', label: 'Featured products' },
                { value: 'seasonal', label: 'Seasonal products' }
            ];
        }
    }
});


/*import template from './config.vue';

Shopware.Component.register('sw-cms-el-config-product-collection', {
    template
}); */