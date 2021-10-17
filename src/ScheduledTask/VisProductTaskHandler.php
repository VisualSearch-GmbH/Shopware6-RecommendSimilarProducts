<?php declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts\ScheduledTask;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Vis\RecommendSimilarProducts\Util\ApiRequest;
use Vis\RecommendSimilarProducts\Util\SwHosts;
use Vis\RecommendSimilarProducts\Util\SwRepoUtils;

class VisProductTaskHandler extends ScheduledTaskHandler
{
    /**
     * @var EntityRepositoryInterface
     */
    protected $scheduledTaskRepository;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var SystemConfigService
     */
    private $systemConfigService;

    public function __construct(
        EntityRepositoryInterface $scheduledTaskRepository,
        SystemConfigService $systemConfigService,
        ContainerInterface $container
    ) {
        parent::__construct($scheduledTaskRepository);
        $this->scheduledTaskRepository = $scheduledTaskRepository;
        $this->systemConfigService = $systemConfigService;
        $this->container = $container;
    }

    public static function getHandledMessages(): iterable
    {
        return [ VisProductTask::class ];
    }

    public function run(): void
    {
        // if the plugin config checkbox is not checked then the plugin is not active
        if(!$this->systemConfigService->get('VisRecommendSimilarProducts.config.enabled')){
            return;
        }

        // get name
        $name = $this->systemConfigService->get('VisRecommendSimilarProducts.config.cross');

        // get product repository
        $productRepository = $this->container->get('product.repository');

        // get category with missing cross-sellings
        $swRepo = new SwRepoUtils();
        $category = $swRepo->getFirstCategory($productRepository, $name);

        // search criteria with category
        $criteria = new Criteria();
        if(!empty($category)) {
            $criteria->addFilter(new EqualsFilter('categoryTree', $category));
        }else{
            return;
        }
        $criteria->addAssociation('cover');
        $criteria->addAssociation('crossSellings');

        // search for products
        $products = $swRepo->searchProducts($productRepository, $criteria);
        if(empty($products)){
            return;
        }

        // retrieve hosts and keys
        $retrieveHosts = new SwHosts($this->container->get('sales_channel.repository'));
        $systemHosts = $retrieveHosts->getLocalHosts();;

        // submit update request
        $api = new ApiRequest($this->container->get('recommend_similar_products_logs.repository'));
        $message = $api->update(
            $this->systemConfigService->get('VisRecommendSimilarProducts.config.apiKey'),
            $products,
            $systemHosts);
    }
}
