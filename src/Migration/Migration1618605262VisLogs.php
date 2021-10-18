<?php

declare(strict_types=1);

namespace Vis\RecommendSimilarProducts\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1618605262VisLogs extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1618605262;
    }

    public function update(Connection $connection): void
    {
        $connection->executeUpdate('
            CREATE TABLE IF NOT EXISTS `recommend_similar_products_logs` (
              `id` BINARY(16) NOT NULL,
              `message` VARCHAR(1500) NULL,
              `level` SMALLINT NULL,
              `channel` VARCHAR(50) NULL,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
