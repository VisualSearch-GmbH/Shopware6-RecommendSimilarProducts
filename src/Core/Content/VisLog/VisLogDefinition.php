<?php

namespace Vis\RecommendSimilarProducts\Core\Content\VisLog;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;

class VisLogDefinition extends EntityDefinition
{

    public function getEntityName(): string
    {
        return 's_plugin_vis_log';
    }

    public function getEntityClass(): string
    {
        return VisLogEntity::class;
    }

    public function getCollectionClass(): string
    {
        return VisLogCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new StringField('message', 'message')),
            (new IntField('level', 'level')),
            (new StringField('channel', 'channel')),
        ]);
    }
}
