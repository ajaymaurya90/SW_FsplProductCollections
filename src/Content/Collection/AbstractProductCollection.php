<?php declare(strict_types=1);

namespace Fspl\ProductCollections\Content\Collection;

use Shopware\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

/**
 * Base class for product collections.
 * Handles storefront visibility & active products.
 */
abstract class AbstractProductCollection implements ProductCollectionInterface
{
    protected function createBaseCriteria(int $limit): Criteria
    {
        $criteria = new Criteria();
        $criteria->setLimit($limit);

        // Required storefront conditions
        $criteria->addFilter(new EqualsFilter('active', true));
        $criteria->addAssociation('visibilities');
        $criteria->addFilter(
            new EqualsFilter(
                'visibilities.visibility',
                ProductVisibilityDefinition::VISIBILITY_ALL
            )
        );

        return $criteria;
    }
}
