<?php

namespace Vis\RecommendSimilarProducts\Core\Content\VisSoldProducts;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(VisSoldProductsEntity $entity)
 * @method void              set(string $key, VisSoldProductsEntity $entity)
 * @method VisSoldProductsEntity[]    getIterator()
 * @method VisSoldProductsEntity[]    getElements()
 * @method VisSoldProductsEntity|null get(string $key)
 * @method VisSoldProductsEntity|null first()
 * @method VisSoldProductsEntity|null last()
 */
class VisSoldProductsCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return VisSoldProductsEntity::class;
    }
}
