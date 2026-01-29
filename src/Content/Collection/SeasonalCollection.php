<?php declare(strict_types=1);

namespace Fspl\ProductCollections\Content\Collection;

use DateTime;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;

class SeasonalCollection extends AbstractProductCollection
{
    public function getType(): string
    {
        return ProductCollectionTypes::SEASONAL;
    }

    public function buildCriteria(int $limit): Criteria
    {
        $criteria = $this->createBaseCriteria($limit);

        $criteria->addFilter(
            new RangeFilter('createdAt', [
                RangeFilter::GTE => (new DateTime('-3 months'))->format(DATE_ATOM),
            ])
        );

        return $criteria;
    }
}
