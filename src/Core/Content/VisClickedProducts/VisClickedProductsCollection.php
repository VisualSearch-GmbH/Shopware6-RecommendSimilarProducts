<?php

declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

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
