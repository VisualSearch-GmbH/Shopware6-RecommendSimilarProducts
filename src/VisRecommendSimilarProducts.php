<?php declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Vis\RecommendSimilarProducts\Util\ApiRequest;
use Vis\RecommendSimilarProducts\Util\SwHostsKeys;

class VisRecommendSimilarProducts extends Plugin
{
    public function install(InstallContext $installContext): void
    {
        // util class retrieve hosts
        $retrieveHosts = new SwHostsKeys($this->container->get('sales_channel.repository'));
        $hosts = $retrieveHosts->getLocalHosts();

        // api message
        $api = new ApiRequest();
        $api->notification($hosts, 'Install', 'shopware;install');

        parent::install($installContext);
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        // util class retrieve hosts
        $retrieveHosts = new SwHostsKeys($this->container->get('sales_channel.repository'));
        $hosts = $retrieveHosts->getLocalHosts();

        // api message
        $api = new ApiRequest();
        $api->notification($hosts, 'Uninstall', 'shopware;uninstall');

        parent::uninstall($uninstallContext);
    }

    public function activate(ActivateContext $activateContext): void
    {
        parent::activate($activateContext);
    }
}