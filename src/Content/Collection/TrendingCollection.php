<?php declare(strict_types=1);

namespace Fspl\ProductCollections\Content\Collection;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;

class TrendingCollection extends AbstractProductCollection
{
    public function getType(): string
    {
        return ProductCollectionTypes::TRENDING;
    }

    public function buildCriteria(int $limit): Criteria
    {
        $criteria = $this->createBaseCriteria($limit);

        $criteria->addSorting(
            new FieldSorting('ratingAverage', FieldSorting::DESCENDING)
        );

        return $criteria;
    }
}
