<?php

declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class VisProductTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'vis.product_task';
    }

    public static function getDefaultInterval(): int
    {
        return 300; // 5 min
    }
}
