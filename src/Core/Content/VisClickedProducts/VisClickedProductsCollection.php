<?php

namespace Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts\VisClickedProductsEntity;

/**
 * @method void              add(VisClickedProductsEntity $entity)
 * @method void              set(string $key, VisClickedProductsEntity $entity)
 * @method VisClickedProductsEntity[]    getIterator()
 * @method VislickedProductsEntity[]    getElements()
 * @method VisClickedProductsEntity|null get(string $key)
 * @method VisClickedProductsEntity|null first()
 * @method VisClickedProductsEntity|null last()
 */
class VisClickedProductsCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return VisClickedProductsEntity::class;
    }
}
