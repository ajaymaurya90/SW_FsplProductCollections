<?php declare(strict_types=1);

namespace Fspl\ProductCollections\Content\Collection;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;

class NewArrivalsCollection extends AbstractProductCollection
{
    public function getType(): string
    {
        return ProductCollectionTypes::NEW_ARRIVALS;
    }

    public function buildCriteria(int $limit): Criteria
    {
        $criteria = $this->createBaseCriteria($limit);

        $criteria->addSorting(
            new FieldSorting('createdAt', FieldSorting::DESCENDING)
        );

        return $criteria;
    }
}
