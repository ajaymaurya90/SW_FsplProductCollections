<?php declare(strict_types=1);

namespace Fspl\ProductCollections\Content\Collection;

/**
 * Central place for all supported product collection types.
 * Keeps strings consistent across admin, resolver, and logic.
 */
final class ProductCollectionTypes
{
    public const NEW_ARRIVALS = 'new_arrivals';
    public const FEATURED    = 'featured';
    public const SEASONAL    = 'seasonal';
    public const TRENDING    = 'trending';

    public static function all(): array
    {
        return [
            self::NEW_ARRIVALS,
            self::FEATURED,
            self::SEASONAL,
            self::TRENDING,
        ];
    }
}
