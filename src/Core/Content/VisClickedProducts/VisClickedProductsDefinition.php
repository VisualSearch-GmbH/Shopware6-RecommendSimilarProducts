<?php

namespace Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
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


            new FkField('product_id', 'productId', ProductDefinition::class),
            (new ReferenceVersionField(ProductDefinition::class))->addFlags(new Required()),
            new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class, 'id', false),

            (new ReferenceVersionField(ProductDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new IntField('number_click', 'numberClick')),

            (new DateField('date', 'date')),
        ]);
    }
}
