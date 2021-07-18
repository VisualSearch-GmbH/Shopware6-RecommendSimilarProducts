<?php

namespace Vis\RecommendSimilarProducts\Core\Content\VisSoldClickedProducts;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Vis\RecommendSimilarProducts\Core\Content\VisSoldClickedProducts\VisSoldClickedProductsEntity;

/**
 * @method void              add(VisSoldClickedProductsEntity $entity)
 * @method void              set(string $key, VisSoldClickedProductsEntity $entity)
 * @method VisSoldClickedProductsEntity[]    getIterator()
 * @method VisSoldClickedProductsEntity[]    getElements()
 * @method VisSoldClickedProductsEntity|null get(string $key)
 * @method VisSoldClickedProductsEntity|null first()
 * @method VisSoldClickedProductsEntity|null last()
 */
class VisSoldClickedProductsCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return VisSoldClickedProductsEntity::class;
    }
}
