<?php declare(strict_types=1);

namespace Fspl\ProductCollections\Content\Collection;

use RuntimeException;

/**
 * Registry that maps collection type → implementation
 */
class ProductCollectionRegistry
{
    /**
     * @var ProductCollectionInterface[]
     */
    private array $collections = [];

    public function __construct(iterable $collections)
    {
        foreach ($collections as $collection) {
            $this->collections[$collection->getType()] = $collection;
        }
    }

    public function get(string $type): ProductCollectionInterface
    {
        if (!isset($this->collections[$type])) {
            throw new RuntimeException(sprintf('Unknown product collection type "%s"', $type));
        }

        return $this->collections[$type];
    }
}
