<?php

declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts\Core\Content\VisLog;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(VisLogEntity $entity)
 * @method void              set(string $key, VisLogEntity $entity)
 * @method VisLogEntity[]    getIterator()
 * @method VisLogEntity[]    getElements()
 * @method VisLogEntity|null get(string $key)
 * @method VisLogEntity|null first()
 * @method VisLogEntity|null last()
 */
class VisLogCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return VisLogEntity::class;
    }
}
