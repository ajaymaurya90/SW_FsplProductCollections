import './component';
import './config';
import './preview';

Shopware.Service('cmsService').registerCmsElement({
    name: 'fspl-product-collections',
    label: 'Product Collections',
    component: 'sw-cms-el-fspl-product-collections',
    configComponent: 'sw-cms-el-config-fspl-product-collections',
    previewComponent: 'sw-cms-el-preview-fspl-product-collections',
    defaultConfig: {
        collectionType: {
            source: 'static',
            value: 'new_arrivals'
        },
        limit: {
            source: 'static',
            value: 8
        }
    }
});
