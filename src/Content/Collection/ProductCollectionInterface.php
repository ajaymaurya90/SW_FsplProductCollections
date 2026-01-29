<?php declare(strict_types=1);

namespace Fspl\ProductCollections\Content\Collection;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

/**
 * Every product collection strategy must implement this interface.
 * This allows the CollectionBuilder to work generically.
 */
interface ProductCollectionInterface
{
    /**
     * Returns the unique collection type key
     * (new_arrivals, trending, featured, seasonal)
     */
    public function getType(): string;

    /**
     * Modify the criteria to fetch products for this collection.
     */
    public function buildCriteria(int $limit): Criteria;
}
