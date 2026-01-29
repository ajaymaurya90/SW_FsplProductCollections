<?php declare(strict_types=1);

namespace Fspl\ProductCollections\Content\Collection;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

class FeaturedCollection extends AbstractProductCollection
{
    public function getType(): string
    {
        return ProductCollectionTypes::FEATURED;
    }

    public function buildCriteria(int $limit): Criteria
    {
        $criteria = $this->createBaseCriteria($limit);

        $criteria->addFilter(
            new EqualsFilter('customFields.fspl_featured', true)
        );

        return $criteria;
    }
}
