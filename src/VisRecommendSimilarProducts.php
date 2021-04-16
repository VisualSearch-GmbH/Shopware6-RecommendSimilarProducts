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
use Vis\RecommendSimilarProducts\Util\SwHostsKeys;

class VisRecommendSimilarProducts extends Plugin
{
    public function install(InstallContext $installContext): void
    {
        // util class retrieve hosts
        $retrieveHosts = new SwHostsKeys($this->container->get('sales_channel.repository'));
        $hosts = $retrieveHosts->getLocalHosts();

        notification($hosts, 'Install', 'shopware;install');

        parent::install($installContext);
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        // util class retrieve hosts
        $retrieveHosts = new SwHostsKeys($this->container->get('sales_channel.repository'));
        $hosts = $retrieveHosts->getLocalHosts();

        notification($hosts, 'Uninstall', 'shopware;uninstall');

        parent::uninstall($uninstallContext);
    }

    public function activate(ActivateContext $activateContext): void
    {
        parent::activate($activateContext);
    }

    public function notification($hosts, $post, $type): void
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.visualsearch.wien/installation_notify',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"'.$post.'":"VisRecommendSimilarProducts"}',
            CURLOPT_HTTPHEADER => array(
                'Vis-API-KEY: marketing',
                'Vis-SYSTEM-HOSTS:'.$hosts,
                'Vis-SYSTEM-TYPE: '.$type.';VisRecommendSimilarProducts',
                'Content-Type: application/json'
            ),
        ));
        curl_exec($curl);
        curl_close($curl);
    }
}