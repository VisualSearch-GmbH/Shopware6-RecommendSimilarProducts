<?php

namespace Vis\RecommendSimilarProducts\Core\Content\VisSoldClickedProducts;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FloatField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Vis\RecommendSimilarProducts\Core\Content\VisSoldClickedProducts\VisSoldClickedProductsEntity;

class VisSoldClickedProductsDefinition extends EntityDefinition
{
    public function getEntityName(): string
    {
        return 's_plugin_vis_sold_clicked_products';
    }

    public function getEntityClass(): string
    {
        return VisSoldClickedProductsEntity::class;
    }

    public function getCollectionClass(): string
    {
        return VisSoldClickedProductsCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new IntField('number_click', 'numberClick')),
            (new IntField('number_sold', 'numberSold')),
            (new FloatField('total_amount', 'totalAmount')),
            (new DateField('date', 'date')),
        ]);
    }
}
