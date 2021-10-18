<?php

declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts\VisClickedProductsEntity;
use Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts\VisClickedProductsCollection;

class VisClickedProductsDefinition extends EntityDefinition
{
    public function getEntityName(): string
    {
        return 'recommend_similar_products_clicks';
    }

    public function getEntityClass(): string
    {
        return VisClickedProductsEntity::class;
    }

    public function getCollectionClass(): string
    {
        return VisClickedProductsCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new DateField('date', 'date')),
        ]);
    }
}
