import './component';
import './config';
import './preview';

Shopware.Service('cmsService').registerCmsElement({
    name: 'product-collection',
    label: 'Product Collection',
    component: 'sw-cms-el-product-collection',
    configComponent: 'sw-cms-el-config-product-collection',
    previewComponent: 'sw-cms-el-preview-product-collection',
    defaultConfig: {
        collectionType: {
            source: 'static',
            value: 'new_arrivals'
        },
        limit: {
            source: 'static',
            value: 8
        },
        layout: {
            source: 'static',
            value: 'grid'
        },
        days: {
            source: 'static',
            value: 30
        }
    }
});
