import './component';
import './preview';

Shopware.Service('cmsService').registerCmsBlock({
    name: 'product-collection-block',
    label: 'Product Collection Block',
    category: 'commerce',
    component: 'sw-cms-block-product-collection',
    previewComponent: 'sw-cms-preview-product-collection',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        sizingMode: 'boxed'
    },
    slots: {
        content: {
            type: 'content'
        }
    }
});
