<?php declare(strict_types=1);

namespace Vis\RecommendSimilarProducts\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1625092309VisSoldClidkedProducts extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1625092309;
    }

    public function update(Connection $connection): void
    {
        $connection->executeUpdate('
            CREATE TABLE IF NOT EXISTS `s_plugin_vis_sold_clicked_products` (
              `id` BINARY(16) NOT NULL,
              `number_click` INT NOT NULL,
              `number_sold` INT NULL,
              `total_amount` DOUBLE NULL,
              `date` DATETIME(3) NOT NULL,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
