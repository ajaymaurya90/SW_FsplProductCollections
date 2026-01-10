<?php declare(strict_types=1);

namespace FsplProductCollections\Content\Cms\ProductCollection;

use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;

class ProductCollectionCmsResolver extends AbstractCmsElementResolver
{
    /**
     * Must match the CMS element name
     */
    public function getType(): string
    {
        return 'product-collection';
    }

    /**
     * Build criteria for product fetching
     */
    public function collect(
        CmsSlotEntity $slot,
        Context $context
    ): ?CriteriaCollection {
        $config = $slot->getFieldConfig();

        $limit = $config->get('limit')?->getValue() ?? 8;
        $collectionType = $config->get('collectionType')?->getValue();

        $criteria = new Criteria();
        $criteria->setLimit((int) $limit);
        $criteria->addFilter(new EqualsFilter('active', true));

        /**
         * New Arrivals logic
         */
        if ($collectionType === 'new_arrivals') {
            $days = $config->get('days')?->getValue() ?? 30;

            $criteria->addFilter(
                new RangeFilter('createdAt', [
                    RangeFilter::GTE => (new \DateTime("-{$days} days"))
                        ->format('Y-m-d H:i:s'),
                ])
            );
        }

        $criteriaCollection = new CriteriaCollection();
        $criteriaCollection->add(
            'products_' . $slot->getUniqueIdentifier(),
            'product',
            $criteria
        );

        return $criteriaCollection;
    }

    /**
     * Attach fetched products to the CMS slot
     */
    public function enrich(
        CmsSlotEntity $slot,
        ResolverContext $resolverContext,
        ElementDataCollection $dataCollection
    ): void {
        $key = 'products_' . $slot->getUniqueIdentifier();
        $result = $dataCollection->get($key);

        if ($result === null) {
            return;
        }

        $slot->setData($result);
    }
}
