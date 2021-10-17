<?php

namespace Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts\VisClickedProductsEntity;

/**
 * @method void              add(VisClickedProductsEntity $entity)
 * @method void              set(string $key, VisClickedProductsEntity $entity)
 * @method VisSoldClickedProductsEntity[]    getIterator()
 * @method VisSoldClickedProductsEntity[]    getElements()
 * @method VisSoldClickedProductsEntity|null get(string $key)
 * @method VisSoldClickedProductsEntity|null first()
 * @method VisSoldClickedProductsEntity|null last()
 */
class VisClickedProductsCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return VisClickedProductsEntity::class;
    }
}
