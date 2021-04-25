<?php declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts\Logging;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Uuid\Uuid;

class LoggingService implements LoggingServiceInterface
{
    /**
     * @var array
     */
    protected $logging = [];

    /**
     * @var EntityRepositoryInterface
     */
    private $loggingRepo;

    public function __construct(EntityRepositoryInterface $loggingRepo)
    {
        $this->loggingRepo = $loggingRepo;
    }

    public function saveLogging(Context $context): void
    {
        if (empty($this->logging)) {
            return;
        }

        $this->loggingRepo->create($this->logging, $context);

        $this->logging = [];
    }

    public function addLogEntry($message): void
    {
        $id = Uuid::randomHex();
        //$date = new DateTime();

        $this->logging[] = [
            'id' => $id,
            'message' => $message,
            'level' => 0,
            'channel' => 'channel',
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
        ];
    }
}
