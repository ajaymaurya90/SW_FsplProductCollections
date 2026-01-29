<?php declare(strict_types=1);

namespace Fspl\ProductCollections\Content\Cms;

use DateTime;
use Fspl\ProductCollections\Content\Collection\ProductCollectionRegistry;
use Fspl\ProductCollections\Content\Collection\ProductCollectionTypes;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;


class FsplProductCollectionsCmsResolver extends AbstractCmsElementResolver
{
    /**
     * Registry that provides collection strategies
     */
    private ProductCollectionRegistry $collectionRegistry;
    public function __construct(ProductCollectionRegistry $collectionRegistry)
    {
        $this->collectionRegistry = $collectionRegistry;
    }
    public function getType(): string
    {
        return 'fspl-product-collections';
    }

    public function collect(
        CmsSlotEntity $slot,
        ResolverContext $resolverContext
    ): ?CriteriaCollection {
        /**
         * Getting Collection type and limit set by our element through administration
         */
        $config = $slot->getConfig();
        $collectionType = $config['collectionType']['value']?? ProductCollectionTypes::NEW_ARRIVALS;
        $limit = (int)$config['limit']['value']?? 8;

        // Get correct collection strategy
        $collection = $this->collectionRegistry->get($collectionType);

        // Let collection build Criteria
        $criteria = $collection->buildCriteria($limit);

        /*
        $criteria = new Criteria();
        $criteria->setLimit($limit);

        // 🔴 REQUIRED for storefront visibility
        $criteria->addFilter(new EqualsFilter('active', true));

        $criteria->addFilter(
            new EqualsFilter(
                'visibilities.salesChannelId',
                $resolverContext->getSalesChannelContext()->getSalesChannelId()
            )
        );
        $criteria->addAssociation('visibilities');
        $criteria->addAssociation('cover');

        switch ($collectionType) {

            case ProductCollectionTypes::NEW_ARRIVALS:
                $criteria->addSorting(
                    new FieldSorting('createdAt', FieldSorting::DESCENDING)
                );
                break;

            case ProductCollectionTypes::TRENDING:
                $criteria->addSorting(
                    new FieldSorting('ratingAverage', FieldSorting::DESCENDING)
                );
                break;

            case ProductCollectionTypes::FEATURED:
                $criteria->addFilter(
                    new EqualsFilter('customFields.fspl_featured', true)
                );
                break;

            case ProductCollectionTypes::SEASONAL:
                $criteria->addFilter(
                    new RangeFilter('createdAt', [
                        RangeFilter::GTE => (new DateTime('-3 months'))->format(DATE_ATOM)
                    ])
                );
                break;
        }
        */
        $criteriaCollection = new CriteriaCollection();
        $criteriaCollection->add(
            'products_' . $slot->getUniqueIdentifier(),
            ProductDefinition::class,
            $criteria
        );

        return $criteriaCollection;
    }

    public function enrich(
        CmsSlotEntity $slot,
        ResolverContext $resolverContext,
        ElementDataCollection $result
    ): void {
        $data = $result->get('products_' . $slot->getUniqueIdentifier());
        $slot->setData($data);

    }
}