<?php

declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts\Logging;

use Shopware\Core\Framework\Context;

interface LoggingServiceInterface
{
    public function addLogEntry($message): void;

    public function saveLogging(Context $context): void;
}
