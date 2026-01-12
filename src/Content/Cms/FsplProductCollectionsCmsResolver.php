<?php declare(strict_types=1);

namespace FsplProductCollections\Content\Cms;

use FsplProductCollections\Content\Collection\ProductCollectionTypes;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;


class FsplProductCollectionsCmsResolver extends AbstractCmsElementResolver
{
    public function getType(): string
    {
        return 'fspl-product-collections';
    }

    public function collect(
        CmsSlotEntity $slot,
        ResolverContext $resolverContext
    ): ?CriteriaCollection {
        $config = $slot->getConfig();
        $collectionType   = $config['collectionType']['value'] ?? ProductCollectionTypes::NEW_ARRIVALS;
        $limit = $config['limit']['value'] ?? 8;

        $criteria = new Criteria();
        $criteria->setLimit($limit);
        $criteria->addAssociation('cover');

        switch ($collectionType) {

            case ProductCollectionTypes::NEW_ARRIVALS:
                $criteria->addSorting(
                    new FieldSorting('createdAt', FieldSorting::DESCENDING)
                );
                break;

            case ProductCollectionTypes::TRENDING:
                /**
                 * Simple trending logic for now.
                 * Can be replaced later with sales-based logic.
                 */
                $criteria->addSorting(
                    new FieldSorting('ratingAverage', FieldSorting::DESCENDING)
                );
                break;

            case ProductCollectionTypes::FEATURED:
                /**
                 * Requires a boolean custom field on product:
                 * customFields.fspl_featured = true
                 */
                $criteria->addFilter(
                    new EqualsFilter('customFields.fspl_featured', true)
                );
                break;

            case ProductCollectionTypes::SEASONAL:
                /**
                 * Products created within last 3 months.
                 * Can be extended to date ranges or season flags.
                 */
                $criteria->addFilter(
                    new RangeFilter('createdAt', [
                        RangeFilter::GTE => (new \DateTime('-3 months'))->format(DATE_ATOM)
                    ])
                );
                break;
        }
        $criteriaCollection = new CriteriaCollection();
        $criteriaCollection->add(
            'products_' . $slot->getUniqueIdentifier(),
            'product',
            $criteria
        );

        return $criteriaCollection;
    }

    public function enrich(
        CmsSlotEntity $slot,
        ResolverContext $resolverContext,
        ElementDataCollection $dataCollection
    ): void {
        //dump('enrich called');
        $slot->setData(
            $dataCollection->get('products_' . $slot->getUniqueIdentifier())
        );
    }
}
