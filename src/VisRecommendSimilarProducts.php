<?php

declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Api\Util\AccessKeyHelper;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\System\Integration\IntegrationDefinition;
use Vis\RecommendSimilarProducts\Util\SwHosts;
use Vis\RecommendSimilarProducts\Util\SwRepoUtils;

class VisRecommendSimilarProducts extends Plugin
{
    public function install(InstallContext $installContext): void
    {
        parent::install($installContext);

        $this->createRole();
        $keys = $this->createIntegration();

        // util class retrieve hosts
        $retrieveHosts = new SwHosts($this->container->get('sales_channel.repository'));
        $hosts = $retrieveHosts->getLocalHosts();

        // send notification
        $this->notification($hosts, $keys, 'shopware6;install');
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);

        if (!$uninstallContext->keepUserData()) {
            $this->deleteRole();
            $this->deleteIntegration();

            /** @var Connection $connection */
            $connection = $this->container->get(Connection::class);
            $connection->executeUpdate('DROP TABLE IF EXISTS `recommend_similar_products_logs`');
            $connection->executeUpdate('DROP TABLE IF EXISTS `recommend_similar_products_clicks`');
        }

        // delete cross-sellings
        $swRepo = new SwRepoUtils();
        $name = $swRepo->getCrossSellingName($this->container->get('system_config.repository'));
        $swRepo->deleteCrossSellings($this->container->get('product_cross_selling.repository'), $name);

        // util class retrieve hosts
        $retrieveHosts = new SwHosts($this->container->get('sales_channel.repository'));
        $hosts = $retrieveHosts->getLocalHosts();

        // send notification
        $this->notification($hosts, '', 'shopware6;uninstall');
    }

    public function activate(ActivateContext $activateContext): void
    {
        parent::activate($activateContext);
    }

    public function notification($hosts, $keys, $type): void
    {
        $url = 'https://api.visualsearch.wien/installation_notify';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Vis-API-KEY: marketing',
            'Vis-SYSTEM-HOSTS:' . $hosts,
            'Vis-SYSTEM-KEY:' . $keys,
            'Vis-SYSTEM-TYPE: VisRecommendSimilarProducts;' . $type,
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    public function createRole()
    {
        /** @var EntityRepositoryInterface $aclRoleRepository */
        $aclRoleRepository = $this->container->get('acl_role.repository');

        $aclRoleObject = [
            'id' => '3082295f733345d5a37b8c9c4da8820a',
            'name' => 'VisualSearch',
            'description' => 'Berechtigung Produkte zu bearbeiten / Permission to edit products',
            'privileges' => [
                "category:read",
                "cms_block:read",
                "cms_page:read",
                "cms_section:read",
                "cms_slot:read",
                "currency:read",
                "custom_field:read",
                "custom_field_set:read",
                "custom_field_set_relation:read",
                "delivery_time:read",
                "document_base_config:read",
                "landing_page:read", "language:read",
                "locale:read", "mail_template:read",
                "mail_template_media:read",
                "main_category:create",
                "main_category:read",
                "media:create",
                "media:read",
                "media:update",
                "media_default_folder:create",
                "media_default_folder:read",
                "media_default_folder:update",
                "media_folder:create",
                "media_folder:delete",
                "media_folder:read",
                "media_folder:update",
                "media_folder_configuration:create",
                "media_folder_configuration:delete",
                "media_folder_configuration:read",
                "media_folder_configuration:update",
                "media_folder_configuration_media_thumbnail_size:create",
                "media_folder_configuration_media_thumbnail_size:delete",
                "media_folder_configuration_media_thumbnail_size:update",
                "media_thumbnail_size:create",
                "media_thumbnail_size:delete",
                "media_thumbnail_size:read",
                "media_thumbnail_size:update",
                "message_queue_stats:read",
                "number_range:read",
                "number_range_type:read",
                "payment_method:read",
                "product.editor",
                "product.viewer",
                "product:read",
                "product:update",
                "product_category:create",
                "product_category:delete",
                "product_category:read",
                "product_configurator_setting:create",
                "product_configurator_setting:delete",
                "product_configurator_setting:read",
                "product_configurator_setting:update",
                "product_cross_selling:create",
                "product_cross_selling:delete",
                "product_cross_selling:read",
                "product_cross_selling_assigned_products:create",
                "product_cross_selling_assigned_products:delete",
                "product_cross_selling_assigned_products:read",
                "product_feature_set:create",
                "product_feature_set:delete",
                "product_feature_set:read",
                "product_feature_set:update",
                "product_manufacturer:create",
                "product_manufacturer:delete",
                "product_manufacturer:read",
                "product_media:create",
                "product_media:delete",
                "product_media:read",
                "product_option:create",
                "product_price:create",
                "product_price:delete",
                "product_price:read",
                "product_property:create",
                "product_property:delete",
                "product_property:read",
                "product_review:create",
                "product_review:delete",
                "product_review:read",
                "product_sorting:read",
                "product_stream:create",
                "product_stream:delete",
                "product_stream:read",
                "product_stream_filter:read",
                "product_tag:create",
                "product_tag:delete",
                "product_tag:read",
                "product_visibility:create",
                "product_visibility:delete",
                "product_visibility:read",
                "property_group:read",
                "property_group_option:read",
                "review:delete",
                "review:read",
                "rule:read",
                "sales_channel:read",
                "sales_channel_type:read",
                "seo_url:read",
                "shipping_method:read",
                "tag:create",
                "tag:read",
                "tax:read",
                "unit:read",
                "user:read",
                "user_config:create",
                "user_config:read",
                "user_config:update"
            ]
        ];

        $aclRoleRepository->upsert([$aclRoleObject], Context::createDefaultContext());
    }

    public function deleteRole()
    {
        /** @var EntityRepositoryInterface $aclRoleRepository */
        $aclRoleRepository = $this->container->get('acl_role.repository');

        $aclRoleRepository->delete([['id' => '3082295f733345d5a37b8c9c4da8820a']], Context::createDefaultContext());
    }

    public function createIntegration(): string
    {
        /** @var EntityRepositoryInterface $integrationRepository */
        $integrationRepository = $this->container->get('integration.repository');

        $access_key = AccessKeyHelper::generateAccessKey('integration');
        $secret_access_key = AccessKeyHelper::generateSecretAccessKey();

        /** @var IntegrationDefinition $integrationObject */
        $integrationObject = [
            'id' => '9af0f21128c24cf3b4c74504d0d6c1f3',
            'writeAccess' => false,
            'accessKey' => $access_key,
            'secretAccessKey' => $secret_access_key,
            'label' => 'VisualSearch',
            'admin' => false,
            'aclRoles' => [['id' => '3082295f733345d5a37b8c9c4da8820a']]
        ];

        $integrationRepository->upsert([$integrationObject], Context::createDefaultContext());

        return implode(";", [$access_key,$secret_access_key]);
    }

    public function deleteIntegration()
    {
        /** @var EntityRepositoryInterface $integrationRepository */
        $integrationRepository = $this->container->get('integration.repository');

        $integrationRepository->delete([['id' => '9af0f21128c24cf3b4c74504d0d6c1f3']], Context::createDefaultContext());
    }
}
